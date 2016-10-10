<?php
/**
 * Created by Justin McCombs.
 * Date: 11/30/15
 * Time: 1:43 PM
 */

namespace Pi\Http\Controllers;


use Illuminate\Http\Request;
use Pi\Mail\Incoming\IncomingMailService;

class EmailParsingController extends Controller
{

    public function parse(Request $request, IncomingMailService $incomingMailService)
    {

        $subject = $request->get('Subject');
        $from = $request->get('Sender');
        $bodyHtml = $request->get('body-html');
        $bodyPlain = $request->get('body-plain');

        \Log::info('Proccessed email from: ' . $from . ' - ' . $subject);

        return $incomingMailService->handle($subject, $from, $bodyHtml, $bodyPlain);


    }


}