<?php
/**
 * Created by Justin McCombs.
 * Date: 9/29/15
 * Time: 9:07 AM
 */

namespace Pi\Http\ViewComposers;


use Illuminate\Cache\Repository as Cache;
use Illuminate\Contracts\Auth\Guard;
use Illuminate\View\View;
use Pi\Clients\Client;

class NavigationViewComposer
{

    /**
     * @var Guard
     */
    private $auth;
    /**
     * @var Cache
     */
    private $cache;

    public function __construct(Guard $auth, Cache $cache)
    {
        $this->auth = $auth;
        $this->cache = $cache;
    }

    public function compose(View $view)
    {
        $currentClient = Client::find(1);
        //$this->cache->remember('sidebar-current-client', 60*24*30 ,function() {
        //    return Client::find(1);
        //});

        $view->with('currentClient', $currentClient);
    }

}