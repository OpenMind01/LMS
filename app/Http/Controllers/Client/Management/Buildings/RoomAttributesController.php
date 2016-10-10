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

class RoomAttributesController extends Controller
{
    public function create($clientSlug, $buildingId, $roomId)
    {
        $client = Client::whereSlug($clientSlug)->first();
        $this->authorize('manage', $client);
        $building = $client->buildings()->whereId($buildingId)->first();
        $this->authorize('manage', $building);
        $room = $building->rooms()->whereId($roomId)->with('users')->first();
        $this->authorize('manage', $room);
        $roomAttributes = $client->roomAttributes->getTree();
        return view('pages.clients.manage.buildings.rooms.attributes.create', compact('client', 'building', 'room', 'roomAttributes'));
    }

    public function store(Request $request, $clientSlug, $buildingId, $roomId)
    {
        $client = Client::whereSlug($clientSlug)->first();
        $this->authorize('manage', $client);
        $building = $client->buildings()->whereId($buildingId)->first();
        $this->authorize('manage', $building);
        $room = $building->rooms()->whereId($roomId)->with('users')->first();
        $this->authorize('manage', $room);

        $roomAttribute = $client->roomAttributes()->whereId($request->get('pivot')['room_attribute_id'])->first();

        if ( ! $roomAttribute )
            return redirect()->back()->with('message', ['danger', 'Could not find the room attribute']);

        $v = \Validator::make($request->get('pivot'), RoomAttribute::$pivotRules);
        if ($v->fails())
            return redirect()->back()->withErrors($v->errors())->withInput($request->all());

        $room->roomAttributes()->attach($request->get('pivot')['room_attribute_id'], [
            'value' => $request->get('pivot')['value'],
            'client_id' => $request->get('pivot')['client_id']
        ]);
        return redirect()->route('clients.manage.buildings.rooms.edit', ['clientSlug' => $clientSlug, $building->id, $room->id])->with('message', ['success', 'Successfully added a new room attribute: '. $roomAttribute->name.'.']);
    }

    public function edit($clientSlug, $buildingId, $roomId, $roomAttributeId)
    {
        $client = Client::whereSlug($clientSlug)->first();
        $this->authorize('manage', $client);
        $building = $client->buildings()->whereId($buildingId)->first();
        $this->authorize('manage', $building);
        $room = $building->rooms()->whereId($roomId)->with('users')->first();
        $this->authorize('manage', $room);
        $roomAttribute = $room->roomAttributes()->whereRoomAttributeId($roomAttributeId)->first();

        $roomAttributes = $client->roomAttributes->getTree();
        if ( ! $roomAttribute )
            return redirect()->back()->with('message', ['danger', 'Could not find the room attribute.']);

        return view('pages.clients.manage.buildings.rooms.attributes.edit', compact('roomAttribute', 'building', 'room', 'roomAttributes', 'client'));
    }

    /**
     * Updates a Room
     * @param Request $request
     * @param $clientSlug
     * @param $buildingId
     * @param $roomId
     * @param $roomAttributeId
     * @return \Illuminate\Http\RedirectResponse
     * @internal param $id
     */
    public function update(Request $request, $clientSlug, $buildingId, $roomId, $roomAttributeId)
    {
        $client = Client::whereSlug($clientSlug)->first();
        $this->authorize('manage', $client);
        $building = $client->buildings()->whereId($buildingId)->first();
        $this->authorize('manage', $building);
        /** @var Room $room */
        $room = $building->rooms()->whereId($roomId)->with('users')->first();
        $this->authorize('manage', $room);
        $roomAttribute = $room->roomAttributes()->whereRoomAttributeId($roomAttributeId)->first();

        if ( ! $roomAttribute )
            return redirect()->back()->with('message', ['danger', 'Could not find the room attribute.']);
        $v = \Validator::make($request->get('pivot'), RoomAttribute::$pivotRules);
        if ($v->fails())
            return redirect()->back()->withErrors($v->errors())->withInput($request->all());
        $room->roomAttributes()->updateExistingPivot($roomAttribute->id, [
            'value' => $request->get('pivot')['value']
        ]);
        return redirect()->route('clients.manage.buildings.rooms.edit', ['clientSlug' => $clientSlug, $building->id, $room->id])->with('message', ['success', 'Successfully updated the room attribute '.$roomAttribute->name.'.']);
    }

    public function destroy($clientSlug, $buildingId, $roomId, $roomAttributeId)
    {
        $client = Client::whereSlug($clientSlug)->first();
        $this->authorize('manage', $client);
        $building = $client->buildings()->whereId($buildingId)->first();
        $this->authorize('manage', $building);
        /** @var Room $room */
        $room = $building->rooms()->whereId($roomId)->with('users')->first();
        $this->authorize('manage', $room);
        $roomAttribute = $room->roomAttributes()->whereRoomAttributeId($roomAttributeId)->first();

        if ( ! $roomAttribute )
            return redirect()->back()->with('message', ['danger', 'Could not find the room attribute.']);

        $room->roomAttributes()->detach($roomAttribute->id);
        return redirect()->back()->with('message', ['warning', 'Room Attribute was removed.']);
    }

}