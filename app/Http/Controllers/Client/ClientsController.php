<?php
/**
 * Created by Justin McCombs.
 * Date: 10/2/15
 * Time: 2:42 PM
 */

namespace Pi\Http\Controllers\Client;


use Illuminate\Contracts\Auth\Guard;
use Pi\Clients\Client;
use Pi\Http\Controllers\Controller;

class ClientsController extends Controller
{

    public function show($slug, Guard $auth)
    {
        /**
         * @var Client $client
         */
        $client = Client::whereSlug($slug)
            ->with('courses.modules.articles', 'usergroups')
            ->first();

        if ( ! $client )
            return redirect()->back()->with('message', ['warning', 'Could not find the client ' . $slug . '.']);

        $this->authorize('member', $client);

        if(!$client->active)
        {
            if($this->authorize('activate', $client)) {
                return redirect()->action('Client\ActivationController@getIndex', $client->slug);
            } else {
                abort(404); // @todo error page here?
            }
        }

        return view('pages.clients.show', compact('client'));
    }

}
