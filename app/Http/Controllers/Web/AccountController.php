<?php

namespace App\Http\Controllers\Web;

use App\Model\Account\Account;
use App\Repositories\AccountRepository;
use App\Repositories\UserRepository;
use Auth;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class AccountController extends Controller
{
    /**
     * @var AccountRepository
     */
    protected $account;
    /**
     * @var UserRepository
     */
    protected $user;

    /**
     * FollowersController constructor.
     * @param $user
     */
    public function __construct(UserRepository $user, AccountRepository $account)
    {
        $this->user = $user;
        $this->account = $account;

    }

    //
    public function index()
    {
        $user = $this->user->byId(Auth::user()->id);

        return view('accounts.index', [
            'account'   => $user->account,
            'frozenAccount'    => $user->frozenAccount,
            'transfers' => $user->transfers()
        ]);
    }

    public function recharge(Request $request)
    {
        $toUser =  $this->user->byUserNameOrFail($request->get('to_account'));
        $amount = $request->get('amount');
        $this->account->recharge($amount,uniqid(),Account::TYPE_RECHARGE,$toUser->account) ;
        ;

    }
    public function transfer(Request $request)
    {

        $toUser =  $this->user->byUserNameOrFail($request->get('to_account'));
        $amount = $request->get('amount');
       $this->account->transfer($amount,uniqid(),Account::TYPE_TRANSFER,Auth::user()->account,$toUser->account) ;
        ;


    }
}
