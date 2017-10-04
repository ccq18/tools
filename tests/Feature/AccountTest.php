<?php

namespace Tests\Feature;


use App\Model\Account\Account;
use App\Model\Account\AccountTransfer;
use App\Model\User;
use App\Repositories\AccountRepository;
use App\Repositories\UserRepository;
use Tests\TestCase;

class AccountTest extends TestCase
{
    public function testTransfer()
    {
        $sysRechargeAccount =resolve(UserRepository::class)->getSystemRechargeAccount();
        $user = User::first();
        // $fromAccount = Account::whereId(3)->first();
        $transfer = resolve(AccountRepository::class)->transfer($sysRechargeAccount,$user->frozenAccount,10,uniqid(),AccountTransfer::STATUS_SUCCESS,'充值');
        dump($transfer);
    }

    public function testRecharge()
    {
        $user = User::first();
        $transfer = resolve(AccountRepository::class)->recharge($user->frozenAccount,10,uniqid(),AccountTransfer::STATUS_SUCCESS,'充值');
        dump($transfer);
    }
}