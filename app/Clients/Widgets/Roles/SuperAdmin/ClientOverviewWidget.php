<?php
/**
 * Created by Justin McCombs.
 * Date: 1/5/16
 * Time: 6:18 PM
 */

namespace Pi\Clients\Widgets\Roles\SuperAdmin;


use Pi\Clients\Client;
use Pi\Clients\Widgets\BaseWidget;
use Pi\Clients\Widgets\Interfaces\WidgetInterface;

class ClientOverviewWidget extends BaseWidget implements WidgetInterface
{

    protected $title = 'Client Overview';

    protected $description = 'An overview of a client in the system';

    protected $key = 'client-overview';

    protected $requiredKeys = [
        'client' => Client::class,
    ];

    /**
     * ClientOverviewWidget gets the following:
     *
     * @return array
     */
    public function getData()
    {
        parent::getData();

    }

}