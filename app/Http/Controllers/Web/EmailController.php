<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use Auth;
use App\Model\User;
use Illuminate\Http\Request;

/**
 * Class EmailController
 * @package App\Http\Controllers\Web
 */
class EmailController extends Controller
{
    /**
     * @param $token
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function verify($token)
    {
        $user = User::where('confirmation_token', $token)->first();

        if ( is_null($user) ) {
            flash('邮箱验证失败', 'danger');

            return redirect('/');
        }

        $user->is_active = 1;
        $user->confirmation_token = str_random(40);
        $user->save();
        Auth::login($user);
        flash('邮箱验证成功！', 'success');

        return redirect('/home');
    }
}
