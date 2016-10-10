<?php
namespace Pi\Http\Controllers\Api;

use Carbon\Carbon;
use Illuminate\Contracts\Auth\Guard;
use Illuminate\Http\Request;
use Pi\Domain\Calendar\CalendarService;
use Pi\Http\Controllers\Controller;

class CalendarController extends Controller
{
    public function getIndex(Request $request, Guard $auth, CalendarService $service)
    {
        return $service->getCalendarEventsForUser($auth->user()
            ,Carbon::createFromFormat('Y-m-d', $request->get('start'))
            ,Carbon::createFromFormat('Y-m-d', $request->get('end')));
    }
}