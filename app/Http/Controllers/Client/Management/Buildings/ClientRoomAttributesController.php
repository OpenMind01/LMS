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
use Pi\Clients\Locations\Rooms\RoomAttribute;
use Pi\Http\Controllers\Controller;

class ClientRoomAttributesController extends Controller
{

    public function index($clientSlug) {
        /** @var Client $client */
        $client = Client::whereSlug($clientSlug)->first();
        $this->authorize('manage', $client);
        $roomAttributes = $client->roomAttributes;
        return view('pages.clients.manage.buildings.room-attributes.index', compact('client', 'roomAttributes'));
    }

    public function create($clientSlug)
    {
        $client = Client::whereSlug($clientSlug)->first();
        $this->authorize('manage', $client);
        $roomAttributes = $client->roomAttributes->getTree();
        return view('pages.clients.manage.buildings.room-attributes.create', compact('client', 'building', 'roomAttributes'));
    }

    public function store(Request $request, $clientSlug)
    {
        $client = Client::whereSlug($clientSlug)->first();
        $this->authorize('manage', $client);
        $this->validate($request, RoomAttribute::rules());
        $attribute = $client->roomAttributes()->create($request->all());
        return redirect()->route('clients.manage.buildings.room-attributes.index', ['clientSlug' => $clientSlug])->with('message', ['success', 'Successfully created a new room attribute: '. $attribute->name.'.']);
    }

    public function edit($clientSlug, $roomAttributeId)
    {
        $client = Client::whereSlug($clientSlug)->first();
        $this->authorize('manage', $client);
        $roomAttribute = $client->roomAttributes()->whereId($roomAttributeId)->first();
        $roomAttributes = $client->roomAttributes->getTree();
        if ( ! $roomAttribute )
            return redirect()->back()->with('message', ['danger', 'Could not find the room attribute.']);

        return view('pages.clients.manage.buildings.room-attributes.edit', compact('roomAttribute', 'roomAttributes', 'client'));
    }

    /**
     * Updates a Room
     * @param Request $request
     * @param $clientSlug
     * @param $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request, $clientSlug, $roomAttributeId)
    {
        $client = Client::whereSlug($clientSlug)->first();
        $this->authorize('manage', $client);
        $roomAttribute = $client->roomAttributes()->whereId($roomAttributeId)->first();
        if ( ! $roomAttribute )
            return redirect()->back()->with('message', ['danger', 'Could not find the room attribute.']);
        $this->validate($request, RoomAttribute::rules($roomAttributeId));
        $roomAttribute->update($request->all());
        return redirect()->route('clients.manage.buildings.room-attributes.index', ['clientSlug' => $clientSlug])->with('message', ['success', 'Successfully updated the room '.$roomAttribute->name.'.']);
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

    public function getGrid($clientSlug) {
        /** @var Client $client */
        $client = Client::whereSlug($clientSlug)->first();
        $this->authorize('manage', $client);
        $buildings = $client->buildings()->with('rooms.roomAttributes')->get();
        $roomAttributes = $client->roomAttributes;
        return view('pages.clients.manage.buildings.room-attributes.grid', compact('client', 'buildings', 'roomAttributes'));
    }
}