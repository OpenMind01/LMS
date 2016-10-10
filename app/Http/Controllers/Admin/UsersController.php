<?php
/**
 * Created by Justin McCombs.
 * Date: 9/30/15
 * Time: 4:53 PM
 */

namespace Pi\Http\Controllers\Admin;

use Illuminate\Http\Request;
use Pi\Auth\Impersonation\Impersonate;
use Pi\Auth\Permission;
use Pi\Auth\Role;
use Pi\Clients\Client;
use Pi\Clients\Courses\Course;
use Pi\Clients\Locations\Buildings\Building;
use Pi\Events\Users\UserCreated;
use Pi\Http\Controllers\Controller;
use Pi\Auth\User;
use Pi\Http\Requests\Users\UserCreateRequest;
use Pi\Http\Requests\Users\UserUpdateRequest;

class UsersController extends Controller
{

    public function __construct()
    {
//        $this->authorize('manage', (new User));
    }

    public function index()
    {
        $this->authorize(Permission::USERS_MANAGE);

        $users = User::paginate(25);
        return view('pages.admin.users.index', compact('users'));
    }

    public function create()
    {
        $this->authorize(Permission::USERS_MANAGE);
        $data = [
          'clients' => \Pi\Clients\Client::all()->lists('name','id'),
            'roles' => array_combine(Role::getAllRoles(), Role::getAllRoles())
        ];

        return view('pages.admin.users.create', $data);
    }

    public function store(UserCreateRequest $request)
    {


        $this->authorize(Permission::USERS_MANAGE);

        if (empty($request->get('password')))
        {
            $password = str_random(8);
        }
        else
        {
            $password = $request->get('password');
        }


        $user = new User($request->except('client','course'));

        $user->active = true;
        $user->password = bcrypt($password);


        if($client_id = $request->get('client'))
        {
            $client = Client::where('id','=',$client_id)->firstOrFail();
            $user->client()->associate($client);
        }


        if($course_id = $request->get('course'))
        {
            $user->save();
            $course = Course::where('id','=',$course_id)->firstOrFail();
            $user->courses()->attach([$course->id]);
        }


        $user->save();

        // Send "new user" email with temporary password only if password is auto generated
        if (empty($request->get('password')))
        {
            \Event::fire(new UserCreated($user, $password));
        }

        return redirect()->route('admin.users.edit',$user->id)->with('message', ['success', 'Successfully updated the user '.$user->full_name.'.']);
    }

    public function edit($id)
    {
        $this->authorize(Permission::USERS_MANAGE);

        $user = User::find($id);

        $rooms = [];
        if($user->client_id) {
            $buildings = Building::whereClientId($user->client_id)->with(['rooms' => function($q) {
                $q->orderBy('name');
            }])->orderBy('name')->get();
            foreach($buildings as $building) {
                $_rooms = [];
                foreach($building->rooms as $room) {
                    $_rooms[$room->id] = $room->number.' - ' . $room->name;
                }
                $rooms[$building->name] = $_rooms;
            }
        }

        $roles = array_combine(Role::getAllRoles(), Role::getAllRoles());

        $clients = \Pi\Clients\Client::all()->lists('name','id');

        if ( ! $user )
            return redirect()->back()->with('message', ['danger', 'Could not find the user.']);

        return view('pages.admin.users.edit', compact('user', 'clients', 'roles', 'role' , 'rooms'));
    }

    public function update(UserUpdateRequest $request, $id)
    {
        $this->authorize(Permission::USERS_MANAGE);

        $user = User::find($id);

        if ( ! $user )
            return redirect()->back()->with('message', ['danger', 'Could not find the user.']);

        if (!empty($request->get('password')))
        {
            $user->password = bcrypt($request->get('password'));
        }

        $user->fill($request->except('client','course'));

        if($client_id = $request->get('client'))
        {
            $client = Client::where('id','=',$client_id)->firstOrFail();
            $user->client()->associate($client);
        }


        if($course_id = $request->get('course'))
        {
            $user->save();
            $course = Course::where('id','=',$course_id)->firstOrFail();
            $user->courses()->attach([$course->id]);
        }

        $user->save();

        return redirect()->route('admin.users.edit',$user->id)->with('message', ['success', 'Successfully updated the user '.$user->full_name.'.']);
    }

    public function destroy($id)
    {
        $this->authorize(Permission::USERS_MANAGE);

        $user = User::find($id);

        if ( ! $user )
            return redirect()->back()->with('message', ['danger', 'Could not find the user.']);

        $user->delete();

        return redirect()->route('admin.users.index')->with('message', ['warning', 'User was removed.']);
    }

    public function impersonate(Impersonate $impersonate, $id)
    {
        $user = User::find($id);

        if ( ! $user )
            return redirect()->back()->with('message', ['danger', 'Could not find the user.']);

        $this->authorize('impersonate', $user);

        $impersonate->switchTo($id);

        return redirect()->to('/')->with('message', ['success', 'You are now impersonating ' . $user->full_name]);
    }

    public function unimpersonate(Impersonate $impersonate)
    {
        $impersonate->switchBack();
        return redirect()->to('/')->with('message', ['success', 'You are no longer impersonating a user.']);
    }
    /*
        public function attachClient(Request $request, ClientMembershipRepository $clientMembership, $id)
        {
            $clientId = $request->get('client_id');
            $client = Client::find($clientId);
            $user = User::find($id);

            $this->authorize('assign', $client);

            if ( ! $client || ! $user )
                return redirect()->back()->with('message', ['danger', 'Could not find the user or client.']);

            $clientMembership->addUserToClient($user, $client);

            return redirect()->back()->with('message', ['success', 'User added to client.']);
        }

        public function detachClient(Request $request, ClientMembershipRepository $clientMembership, $id)
        {
            $clientId = $request->get('client_id');
            $client = Client::find($clientId);
            $user = User::find($id);

            $this->authorize('assign', $client);

            if ( ! $client || ! $user )
                return redirect()->back()->with('message', ['danger', 'Could not find the user or client.']);

            $clientMembership->removeUserFromClient($user, $client);

            return redirect()->back()->with('message', ['success', 'User removed from client.']);
        }

        public function attachRole(Request $request, RoleAssignmentService $roleAssignment, $id)
        {
            $roleId = $request->get('role_id');
            $role = Role::find($roleId);
            $user = User::find($id);

            $this->authorize('assign', $role);

            if ( ! $role || ! $user )
                return redirect()->back()->with('message', ['danger', 'Could not find the user or role.']);

            $roleAssignment->attachRoleToUser($user, $role);

            return redirect()->back()->with('message', ['success', 'User added to role.']);
        }

        public function detachRole(Request $request, RoleAssignmentService $roleAssignment, $id)
        {
            $roleId = $request->get('role_id');
            $role = Role::find($roleId);
            $user = User::find($id);

            $this->authorize('assign', $role);

            if ( ! $role || ! $user )
                return redirect()->back()->with('message', ['danger', 'Could not find the user or role.']);

            $roleAssignment->detachRoleFromUser($user, $role);

            return redirect()->back()->with('message', ['success', 'User removed from role.']);
        }*/

}