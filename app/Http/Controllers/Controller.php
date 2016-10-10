<?php

namespace Pi\Http\Controllers;

use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Pi\Helpers\BreadcrumbsHelper;
use Pi\Services\BreadcrumbsService;

abstract class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    /**
     * @var BreadcrumbsHelper
     */
    protected $breadcrumbsHelper;

    public function callAction($method, $parameters)
    {
        $this->breadcrumbsHelper = new BreadcrumbsHelper(new BreadcrumbsService());

        return parent::callAction($method, $parameters);
    }
}