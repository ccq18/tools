<?php

namespace Tests\Feature;


use App\Model\Account\Account;
use App\Model\Account\AccountTransfer;
use App\Model\User;
use App\Repositories\AccountRepository;
use App\Repositories\UserRepository;
use App\Spl\LinkListHelper;
use DeepCopy\TypeFilter\Spl\SplDoublyLinkedList;
use Tests\TestCase;

class AccountTest extends TestCase
{
    public function testTransfer()
    {
        $sysRechargeAccount = resolve(UserRepository::class)->getSystemRechargeAccount();
        $user = User::first();
        // $fromAccount = Account::whereId(3)->first();
        $transfer = resolve(AccountRepository::class)->transfer($sysRechargeAccount, $user->frozenAccount, 10, uniqid(),
            AccountTransfer::STATUS_SUCCESS, '充值');
        dump($transfer);
    }


    public function testPush()
    {
        $data = range(1,7000);
        $linkHelper = new LinkListHelper();
        $doubly = $linkHelper->getByPad(count($data)*6,$data);
        foreach ($data as $k=> $id){
            $doubly->add($k+4,$id);
            $doubly->add($k+16,$id);
            $doubly->add($k+64,$id);
            $doubly->add($k+256,$id);
            $doubly->add($k+1024,$id);

        }
        dump(count($linkHelper->getArrAndNotNull($doubly)));
        dump(strlen(json_encode($linkHelper->getArrAndNotNull($doubly))));
        // $this->assertEquals([1, 1, 2,  3,2, 3], );

    }

    public function testPush2(){
        $data = range(1,3);
        $linkHelper = new LinkListHelper();
        $doubly = $linkHelper->getByPad(100,$data);
        $doubly->add(1,1);
        $doubly->add(2,2);
        $doubly->add(3,3);
        $this->assertEquals([1, 1, 2,  3,2, 3], $linkHelper->getArrAndNotNull($doubly));
    }
    public function testRecharge()
    {
        $user = User::first();
        $transfer = resolve(AccountRepository::class)->recharge($user->frozenAccount, 10, uniqid(),
            AccountTransfer::STATUS_SUCCESS, '充值');
        dump($transfer);
    }
}