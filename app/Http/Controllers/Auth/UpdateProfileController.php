<?php

namespace Pi\Http\Controllers\Auth;

use Illuminate\Contracts\Auth\Guard;
use Pi\Auth\User;
use Pi\Http\Controllers\Controller;
use Illuminate\Http\Request;

class UpdateProfileController extends Controller
{
    public function getIndex(Guard $auth)
    {
        $this->breadcrumbsHelper->addTitle('Update Profile');

        $user = User::findOrFail($auth->user()->id);
        return view('auth.update_profile', compact('user'));
    }

    public function postIndex(Guard $auth, Request $request)
    {
        $user = User::findOrFail($auth->user()->id);

        if (($request->input('show_tutorial')) !== null) {
            $user->show_tutorial = $request->input('show_tutorial');
            $user->save();
        }

        $this->validate($request, User::rules($user->id));

        $user->fill($request->all());
        $user->save();

        return redirect()->back()->with('message', ['success', 'Successfully updated the profile.']);
    }
}