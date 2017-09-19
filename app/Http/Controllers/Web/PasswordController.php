<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use Hash;
use App\Http\Requests\ChangePasswordRequest;
use Illuminate\Http\Request;

/**
 * Class PasswordController
 * @package App\Http\Controllers\Web
 */
class PasswordController extends Controller
{
    public function password()
    {
        return view('users.password');
    }

    public function update(ChangePasswordRequest $request)
    {
        if(Hash::check($request->get('old_password'),user()->password)) {
            user()->password = bcrypt($request->get('password'));
            user()->save();
            flash('密码修改成功','success');

            return back();
        }
        flash('密码修改失败','danger');
        return back();
    }
}
