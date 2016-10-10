<?php

namespace Pi\Http\Controllers\Auth;

use Illuminate\Contracts\Auth\Guard;
use Pi\Auth\User;
use Pi\Http\Controllers\Controller;
use Pi\Http\Requests\Auth\ChangePasswordRequest;

class ChangePasswordController extends Controller
{
    public function getIndex()
    {
        $this->breadcrumbsHelper->addTitle('Change password');

        return view('auth.change_password');
    }

    public function postIndex(Guard $auth, ChangePasswordRequest $request)
    {
        /**
         * @var User $user
         */
        $user = User::findOrFail($auth->user()->id);

        if(!\Hash::check($request->getCurrentPassword(), $user->password))
        {
            return redirect()->back()->with('error', 'Wrong current password');
        }

        $user->password = bcrypt($request->getNewPassword());
        $user->save();

        return redirect()->route('dashboard')->with('message', ['success', 'Password changed']);
    }
}