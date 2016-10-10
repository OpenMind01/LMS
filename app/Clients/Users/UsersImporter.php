<?php

namespace Pi\Clients\Users;

use Pi\Auth\Role;
use Pi\Auth\User;
use Pi\Clients\Client;
use Pi\Clients\Locations\Buildings\Building;
use Pi\Clients\Locations\Rooms\Room;
use Pi\Events\Clients\ClientUsersChanged;
use Pi\Events\Users\UserCreated;
use Pi\Exceptions\Clients\Users\Import\DuplicateColumnsException;
use Pi\Exceptions\Clients\Users\Import\EmailColumnDoesntExistException;
use Pi\Exceptions\Clients\Users\Import\NamesConflictException;
use Pi\Exceptions\Clients\Users\Import\ProcessErrorsException;
use Pi\Exceptions\Clients\Users\Import\RoomAndManyBuildingsException;
use Pi\Exceptions\Clients\Users\Import\RoomAndNoBuildingsException;
use Pi\Exceptions\Clients\Users\Import\UselessBuildingColumnException;
use Pi\Http\Requests\Clients\Users\Import\ImportProcessRequest;

class UsersImporter
{
    const COLUMN_NONE = 'none';
    const COLUMN_EMAIL = 'email';
    const COLUMN_FIRST_NAME = 'first_name';
    const COLUMN_LAST_NAME = 'last_name';
    const COLUMN_FULL_NAME = 'full_name';
    const COLUMN_BUILDING = 'building';
    const COLUMN_ROOM = 'room';
    /**
     * @var UsersImportService
     */
    private $importService;

    public function __construct(UsersImportService $importService)
    {
        $this->importService = $importService;
    }

    public function getPossibleColumns()
    {
        return [
            self::COLUMN_NONE => '(not used)',
            self::COLUMN_EMAIL => 'Email',
            self::COLUMN_FIRST_NAME => 'First name',
            self::COLUMN_LAST_NAME => 'Last name',
            self::COLUMN_FULL_NAME => 'Full name',
            self::COLUMN_BUILDING => 'Building',
            self::COLUMN_ROOM => 'Room',
        ];
    }

    /**
     * @param Client $client
     * @param UsersImport $import
     * @param ImportProcessRequest $request
     * @return \Pi\Auth\User[]
     * @throws DuplicateColumnsException
     * @throws EmailColumnDoesntExistException
     * @throws NamesConflictException
     * @throws ProcessErrorsException
     */
    public function process(Client $client, UsersImport $import, ImportProcessRequest $request)
    {
        $columns = $request->getColumns();

        $this->validate($client, $columns);

        $fillers = $this->createFillers($client, $columns);

        $data = $this->importService->getCsvData($import);

        if($request->isRemoveFirstRow())
        {
            array_shift($data);
        }

        $errors = [];

        /**
         * @var User[] $users
         */
        $users = [];
        foreach($data as $row)
        {
            $user = new User();
            $user->client_id = $client->id;
            $user->role = Role::STUDENT;
            $user->active = false;

            foreach($fillers as $filler)
            {
                $filler($user, $row, $errors);
            }

            $users[] = $user;
        }

        if(count($errors))
        {
            throw new ProcessErrorsException($errors);
        }

        foreach($users as $user)
        {
            $password = str_random(8);

            $user->password = bcrypt($password);

            $user->save();

            \Event::fire(new UserCreated($user, $password));
        }

        \Event::fire(new ClientUsersChanged($client));

        return $users;
    }

    /**
     * @param Client $client
     * @param $columns
     * @throws DuplicateColumnsException
     * @throws EmailColumnDoesntExistException
     * @throws NamesConflictException
     * @throws RoomAndManyBuildingsException
     * @throws RoomAndNoBuildingsException
     * @throws UselessBuildingColumnException
     */
    private function validate(Client $client, $columns)
    {
        $counts = array_count_values($columns);

        foreach ($counts as $key => $count)
        {
            if ($key != self::COLUMN_NONE && $count > 1)
            {
                throw new DuplicateColumnsException();
            }
        }

        if (!in_array(self::COLUMN_EMAIL, $columns))
        {
            throw new EmailColumnDoesntExistException();
        }

        if (in_array(self::COLUMN_FULL_NAME, $columns) &&
            (in_array(self::COLUMN_FIRST_NAME, $columns) || in_array(self::COLUMN_LAST_NAME, $columns))
        )
        {
            throw new NamesConflictException();
        }

        if(in_array(self::COLUMN_ROOM, $columns) && !in_array(self::COLUMN_BUILDING, $columns))
        {
            // Check if there is only one building, we can use it.

            if($client->buildings->count() > 1)
            {
                throw new RoomAndManyBuildingsException();
            }

            if($client->buildings->count() == 0)
            {
                throw new RoomAndNoBuildingsException();
            }
        }

        if(in_array(self::COLUMN_BUILDING, $columns) && !in_array(self::COLUMN_ROOM, $columns))
        {
            throw new UselessBuildingColumnException();
        }
    }


    /**
     * @param Client $client
     * @param $columns
     * @return array
     */
    private function createFillers(Client $client, $columns)
    {
        $fillers = [];

        $fillers[] = $this->getEmailFiller(array_search(self::COLUMN_EMAIL, $columns));

        if (in_array(self::COLUMN_FIRST_NAME, $columns))
        {
            $fillers[] = $this->getFirstNameFiller(array_search(self::COLUMN_FIRST_NAME, $columns));
        }

        if (in_array(self::COLUMN_LAST_NAME, $columns))
        {
            $fillers[] = $this->getLastNameFiller(array_search(self::COLUMN_LAST_NAME, $columns));
        }

        if (in_array(self::COLUMN_FULL_NAME, $columns))
        {
            $fillers[] = $this->getFullNameFiller(array_search(self::COLUMN_FULL_NAME, $columns));
        }

        if(in_array(self::COLUMN_ROOM, $columns))
        {
            if(in_array(self::COLUMN_BUILDING, $columns))
            {
                $fillers[] = $this->getBuildingAndRoomFiller($client,
                    array_search(self::COLUMN_ROOM, $columns),
                    array_search(self::COLUMN_BUILDING, $columns));
            }
            else
            {
                if($client->buildings->count() == 1)
                {
                    $fillers[] = $this->getRoomForOneBuildingFiller($client,
                        $client->buildings->first(),
                        array_search(self::COLUMN_ROOM, $columns));
                }
            }
        }

        return $fillers;
    }

    /**
     * @param $emailColumnIndex
     * @return \Closure
     */
    private function getEmailFiller($emailColumnIndex)
    {
        return function (User $user, $row, &$errors) use($emailColumnIndex)
        {
            $email = trim(array_get($row, $emailColumnIndex, ''));

            if($email == '')
            {
                $errors[] = 'Empty email: ' . $email;
                return;
            }

            if(filter_var($email, FILTER_VALIDATE_EMAIL) === false)
            {
                $errors[] = 'Invalid email: ' . $email;
                return;
            }

            if(User::whereEmail($email)->count() > 0)
            {
                $errors[] = 'Email already exists: ' . $email;
                return;
            }

            $user->email = $email;
        };
    }

    /**
     * @param $columnIndex
     * @return \Closure
     */
    private function getFirstNameFiller($columnIndex)
    {
        return function (User $user, $row, &$errors) use($columnIndex)
        {
            $user->first_name = trim(array_get($row, $columnIndex, ''));
        };
    }

    /**
     * @param $columnIndex
     * @return \Closure
     */
    private function getLastNameFiller($columnIndex)
    {
        return function (User $user, $row, &$errors) use($columnIndex)
        {
            $user->last_name = trim(array_get($row, $columnIndex, ''));
        };
    }

    /**
     * @param $columnIndex
     * @return \Closure
     */
    private function getFullNameFiller($columnIndex)
    {
        return function (User $user, $row, &$errors) use($columnIndex)
        {
            $parts = explode(' ', array_get($row, $columnIndex, ''));

            $parts = array_filter($parts);

            if(count($parts))
            {
                $user->last_name = array_pop($parts);
            }

            $user->first_name = join(' ', $parts);
        };
    }

    private function getBuildingAndRoomFiller(Client $client, $roomColumnIndex, $buildingColumnIndex)
    {
        return function (User $user, $row, &$errors) use($client, $roomColumnIndex, $buildingColumnIndex)
        {
            $roomName = trim(array_get($row, $roomColumnIndex, ''));

            if($roomName == '') return;

            $buildingName = trim(array_get($row, $buildingColumnIndex, ''));

            if($buildingName == '') return;

            /**
             * @var Building $building
             */
            $building = $client->buildings()->where('name', $buildingName)->first();

            if($building == null)
            {
                $errors[] = 'Unknown building: ' . $buildingName;
                return;
            }

            $room = $building->rooms()->where('name', $roomName)->first();

            if($room == null)
            {
                $room = new Room();
                $room->building_id = $building->id;
                $room->client_id = $client->id;
                $room->name = $roomName;
                $room->number = $building->rooms()->getBaseQuery()->max('number') + 1;

                $room->save();
            }

            $user->room_id = $room->id;
        };
    }

    private function getRoomForOneBuildingFiller(Client $client, Building $building, $roomColumnIndex)
    {
        return function (User $user, $row, &$errors) use($client, $building, $roomColumnIndex)
        {
            $roomName = trim(array_get($row, $roomColumnIndex, ''));

            if($roomName == '') return;

            $room = $building->rooms()->where('name', $roomName)->first();

            if($room == null)
            {
                $room = new Room();
                $room->building_id = $building->id;
                $room->client_id = $client->id;
                $room->name = $roomName;
                $room->number = $building->rooms()->getBaseQuery()->max('number') + 1;

                $room->save();
            }

            $user->room_id = $room->id;
        };
    }
}