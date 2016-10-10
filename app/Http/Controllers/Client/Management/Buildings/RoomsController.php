<?php
/**
 * Created by Justin McCombs.
 * Date: 11/4/15
 * Time: 9:30 AM
 */

namespace Pi\Http\Controllers\Client\Management\Buildings;


use Illuminate\Http\Request;
use Pi\Clients\Client;
use Pi\Clients\Locations\Rooms\Room;
use Pi\Http\Controllers\Controller;

class RoomsController extends Controller
{

    public function create($clientSlug, $buildingId)
    {
        $client = Client::whereSlug($clientSlug)->first();
        $this->authorize('manage', $client);
        $building = $client->buildings()->whereId($buildingId)->first();
        $this->authorize('manage', $building);
        $this->authorize('manage', [(new Room), $client]);
        return view('pages.clients.manage.buildings.rooms.create', compact('client', 'building'));
    }

    public function store(Request $request, $clientSlug, $buildingId)
    {
        $client = Client::whereSlug($clientSlug)->first();
        $this->authorize('manage', $client);
        $building = $client->buildings()->whereId($buildingId)->first();
        $this->authorize('manage', $building);
        $this->authorize('manage', [(new Room)]);
        $this->validate($request, Room::rules());
        $room = $building->rooms()->create($request->all());
        return redirect()->route('clients.manage.buildings.edit', ['clientSlug' => $clientSlug, $building->id])->with('message', ['success', 'Successfully created a new room: '. $room->name.'.']);
    }

    public function edit($clientSlug, $buildingId, $roomId)
    {
        $client = Client::whereSlug($clientSlug)->first();
        $this->authorize('manage', $client);
        $building = $client->buildings()->whereId($buildingId)->first();
        $this->authorize('manage', $building);
        $room = $building->rooms()->whereId($roomId)->with('users')->first();

        if ( ! $room )
            return redirect()->back()->with('message', ['danger', 'Could not find the room.']);

        $this->authorize('manage', $room);

        return view('pages.clients.manage.buildings.rooms.edit', compact('room', 'client', 'building'));
    }

    /**
     * Updates a Room
     * @param Request $request
     * @param $clientSlug
     * @param $buildingId
     * @param $roomId
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request, $clientSlug, $buildingId, $roomId)
    {
        $client = Client::whereSlug($clientSlug)->first();
        $this->authorize('manage', $client);
        $building = $client->buildings()->whereId($buildingId)->first();
        $this->authorize('manage', $building);
        $room = $building->rooms()->whereId($roomId)->with('users')->first();

        if ( ! $room )
            return redirect()->back()->with('message', ['danger', 'Could not find the room.']);

        $this->authorize('manage', $room);

        $this->validate($request, Room::rules());
        $room->update($request->all());
        return redirect()->route('clients.manage.buildings.edit', ['clientSlug' => $clientSlug, $building->id])->with('message', ['success', 'Successfully updated the room '.$room->name.'.']);
    }

    public function destroy($clientSlug, $buildingId, $roomId)
    {
        $client = Client::whereSlug($clientSlug)->first();
        $this->authorize('manage', $client);
        $building = $client->buildings()->whereId($buildingId)->first();
        $this->authorize('manage', $building);
        $room = $building->rooms()->whereId($roomId)->with('users')->first();
        $this->authorize('manage', $room);
        $room->delete();
        return redirect()->back()->with('message', ['warning', 'Room was removed.']);
    }

    public function addUser($clientSlug, $buildingId, $roomId, $userId)
    {
        $client = Client::whereSlug($clientSlug)->first();
        $this->authorize('manage', $client);
        $building = $client->buildings()->whereId($buildingId)->first();
        $this->authorize('manage', $building);
        /** @var Room $room */
        $room = $building->rooms()->whereId($roomId)->with('users')->first();
        $this->authorize('manage', $room);
        $user = $client->users()->whereId($userId)->first();

        if ($user->room_id == $roomId)
            return response()->json(['success' => false, 'message' => 'User already belongs to room.']);

        $user->update(['room_id' => $room->id]);

        return response()->json(['success' => true]);
    }

    public function removeUser($clientSlug, $buildingId, $roomId, $userId)
    {
        $client = Client::whereSlug($clientSlug)->first();
        $this->authorize('manage', $client);
        $building = $client->buildings()->whereId($buildingId)->first();
        $this->authorize('manage', $building);
        /** @var Room $room */
        $room = $building->rooms()->whereId($roomId)->with('users')->first();
        $this->authorize('manage', $room);
        $user = $room->users()->whereId($userId)->first();
        if (! $user)
            return redirect()->back()->with('message', ['danger', 'The user was not found or does not belong to this room.']);

        $user->update(['room_id' => null]);
        return redirect()->back()->with('message', ['success', 'User removed.']);
    }
}