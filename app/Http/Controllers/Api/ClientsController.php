<?php
/**
 * Created by Justin McCombs.
 * Date: 10/14/15
 * Time: 4:54 PM
 */

namespace Pi\Http\Controllers\Api;


use Illuminate\Http\Request;
use Pi\Clients\Client;
use Pi\Http\Controllers\Controller;

class ClientsController extends ApiController
{
    /**
     * @description return json object representing all courses related to a specified client
     */
    public function courses($id = null)
    {
        //Is the user an admin
        //@todo something special
        //@todo verify that security is correct for this route. I cant wrap my head around a 500+ line routes file

        if(!isset($id)) $id = \Auth::user()->client->id;

        $client = Client::where('id','=',$id)->firstOrFail();
        $courses = $client->courses;
        return $courses;
    }




    public function show($id)
    {
        $client = Client::whereId($id)->with(['users' => function($q) {
            $q->orderBy('last_name')->orderBy('first_name');
        }])->first();
        $this->authorize('show', $client);
        return $this->responseSuccess($client);
    }


    public function inlineUpdate(Request $request, $id)
    {

        $client = Client::find($id);

        if ( ! $client )
            return response()->json(['success' => false]);

        $this->authorize('manage', $client);

        foreach(json_decode($request->get('raptor-content')) as $field => $value)
        {
            $client->$field = $value;
        }

        $client->save();

        return response()->json([
            'success' => true,
        ]);
    }

    /**
    * Updates client widget settings
    *
    * @param Request $request
    * @param mixed $id
    * @return \Illuminate\Http\JsonResponse
    */
    public function updateSettings(Request $request, $id)
    {

        $client = Client::find($id);

        if ( ! $client )
            return response()->json(['success' => false]);

        $this->authorize('manage', $client);

        $settings = $client->settings()->first();

        if (!$settings)
        {
            $settings = new \Pi\Clients\Settings\ClientSetting();
            $settings->client_id = $id;
        }

        $settings->widget_settings = $request->get('client_settings')['widget_settings'];

        $settings->save();

        return response()->json($request->all());
    }
}