<?php

namespace Pi\Http\Controllers\Registration;

use Illuminate\Contracts\Auth\Guard;
use Pi\Auth\UsersService;
use Pi\Http\Controllers\Controller;
use Pi\Http\Requests\Users\UserActivationRequest;

class UserRegistrationController extends Controller
{
    public function getIndex(Guard $auth)
    {
        return view('pages.registration.user.index', ['user' => $auth->user()]);
    }

    public function postIndex(Guard $auth, UsersService $service, UserActivationRequest $request)
    {
        $user = $auth->user();
        $service->activate($user, $request);

        return redirect()->route('clients.show', $user->client->slug);
    }
}