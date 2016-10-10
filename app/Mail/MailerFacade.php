<?php
/**
 * Created by Justin McCombs.
 * Date: 11/30/15
 * Time: 12:09 PM
 */

namespace Pi\Mail;


use Illuminate\Support\Facades\Facade;

class MailerFacade extends Facade
{

    protected static function getFacadeAccessor()
    {
        return 'p4mailer';
    }

}