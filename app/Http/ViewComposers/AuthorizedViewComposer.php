<?php
/**
 * Created by Justin McCombs.
 * Date: 9/29/15
 * Time: 9:07 AM
 */

namespace Pi\Http\ViewComposers;


use Illuminate\Contracts\Auth\Guard;
use Illuminate\Support\Collection;
use Illuminate\View\View;
use Pi\Auth\Impersonation\Impersonate;
use Pi\Auth\User;
use Pi\Clients\Client;
use Pi\Snippets\SnippetService;

class AuthorizedViewComposer
{

    /**
     * @var Guard
     */
    private $auth;
    /**
     * @var Impersonate
     */
    private $impersonate;
    /**
     * @var SnippetService
     */
    private $snippetService;

    public function __construct(Guard $auth, Impersonate $impersonate, SnippetService $snippetService)
    {
        $this->auth = $auth;
        $this->impersonate = $impersonate;
        $this->snippetService = $snippetService;
    }

    public function compose(View $view)
    {

        $view->with('currentUser', \Auth::user());
        $view->with('viewData', $view->getData());
        $currentClient = new Client();
        foreach($view->getData() as $dataItem) {
            if (is_object($dataItem) && get_class($dataItem) == Client::class) {
                $currentClient = $dataItem;
            }
        }
        $view->with('currentClient', $currentClient);

    }

}