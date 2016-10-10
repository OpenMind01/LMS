<?php
/**
 * Created by Justin McCombs.
 * Date: 10/14/15
 * Time: 2:42 PM
 */

namespace Pi\Snippets;


use Illuminate\Support\Facades\Facade;

class SnippetFacade extends Facade
{

    protected static function getFacadeAccessor() { return 'Pi\Snippets\SnippetService'; }

}
