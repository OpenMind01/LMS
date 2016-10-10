<?php
/**
 * Created by Justin McCombs.
 * Date: 11/4/15
 * Time: 9:30 AM
 */

namespace Pi\Http\Controllers\Client\Management\Buildings;


use Illuminate\Http\Request;
use Pi\Clients\Client;
use Pi\Clients\Locations\Buildings\Building;
use Pi\Http\Controllers\Controller;

class BuildingsController extends Controller
{
    public function index($clientSlug)
    {
        $client = Client::whereSlug($clientSlug)->first();
        $this->authorize('manage', $client);
        $this->authorize('manage', (new Building), $client);
        $buildings = $client->buildings()->with('rooms.roomAttributes')->get();

        return view('pages.clients.manage.buildings.index', compact('client', 'buildings'));
    }

    public function create($clientSlug)
    {
        $client = Client::whereSlug($clientSlug)->first();
        $this->authorize('manage', $client);
        $this->authorize('manage', [(new Building), $client]);
        return view('pages.clients.manage.buildings.create', compact('client'));
    }

    public function store(Request $request, $clientSlug)
    {
        $client = Client::whereSlug($clientSlug)->first();
        $this->authorize('manage', $client);
        $this->authorize('manage', [(new Building)]);
        $this->validate($request, Building::rules());
        $building = Building::create($request->all());
        return redirect()->route('clients.manage.buildings.index', ['clientSlug' => $clientSlug])->with('message', ['success', 'Successfully created a new building: '. $building->name.'.']);
    }

    public function edit($clientSlug, $buildingId)
    {
        $client = Client::whereSlug($clientSlug)->first();
        $this->authorize('manage', $client);
        $building = $client->buildings()->whereId($buildingId)->with('rooms.users')->first();
        $this->authorize('manage', $building);

        if ( ! $building )
            return redirect()->back()->with('message', ['danger', 'Could not find the building.']);

        return view('pages.clients.manage.buildings.edit', compact('building', 'client'));
    }

    /**
     * Updates a Building
     * @param Request $request
     * @param $clientSlug
     * @param $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request, $clientSlug, $id)
    {
        $client = Client::whereSlug($clientSlug)->first();
        $this->authorize('manage', $client);
        $building = $client->buildings()->whereId($id)->first();
        if ( ! $building )
            return redirect()->back()->with('message', ['danger', 'Could not find the building.']);
        $this->authorize('manage', $building);
        $this->validate($request, Building::rules());
        $building->update($request->all());
        return redirect()->route('clients.manage.buildings.index', ['clientSlug' => $clientSlug])->with('message', ['success', 'Successfully updated the building '.$building->name.'.']);
    }

    public function destroy($clientSlug, $id)
    {
        $client = Client::whereSlug($clientSlug)->first();
        $this->authorize('manage', $client);
        $building = $client->buildings()->whereId($id)->first();
        $this->authorize('manage', [$building, $client]);
        if ( ! $building )
            return redirect()->back()->with('message', ['danger', 'Could not find the building.']);
        $building->delete();
        return redirect()->back()->with('message', ['warning', 'Building was removed.']);
    }

    public function postModuleOrder(Request $request, $clientSlug, $id)
    {
        $client = Client::whereSlug($clientSlug)->first();
        $this->authorize('manage', $client);
        $building = Building::find($id);
        $this->authorize('manage', [$building, $client]);
        if ( ! $building )
            return response()->json(['success' => false]);

        $order = $request->get('order');
        $returnOrder = [];
        foreach($order as $i => $moduleId)
        {
            $building->modules()->whereId($moduleId)->update(['number' => $i+1]);
            $returnOrder[$i+1] = $moduleId;
        }

        return response()->json(['success' => true, 'order' => $returnOrder]);
    }
}