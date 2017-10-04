<?php

namespace App\Repositories;


use App\Model\Account\Account;
use App\Model\Account\AccountLog;
use App\Model\Account\AccountTransfer;

class AccountRepository extends BaseRepository
{
    /**
     * @var UserRepository
     */
    protected $user;
    protected $bindClass = Account::class;

    public function __construct(UserRepository $user)
    {
        $this->user = $user;

    }

    public function create($uid, $type, $title)
    {
        if (!$this->checkInConst('ACCOUNT', $type)) {
            return false;
        }
        $account = new Account();
        $account->uid = $uid;
        $account->amount = 0;
        $account->type = $type;
        $account->title = $title;
        $account->save();
        $this->addLog($account, '账户创建');

        return $account;
    }


    public function addLog($account, $title, AccountTransfer $transfer = null)
    {
        $accountLog = new AccountLog();
        $accountLog->account_id = $account->id;
        $accountLog->title = $title;
        $accountLog->amount = 0;
        $accountLog->transfer_id = null;
        if (!is_null($transfer)) {
            $accountLog->amount = $transfer->amount;
            $accountLog->transfer_id = $transfer->id;
        }
        $accountLog->save();

        return $accountLog;
    }

    public function transfer(Account $fromAcccount, Account $toAccount, $amount, $bizId, $bizType, $title)
    {

        $fromAcccount->decrement('amount', $amount);
        $fromAcccount->save();
        $toAccount->increment('amount', $amount);
        $toAccount->save();
        $transfer = new AccountTransfer();
        $transfer->amount = $amount;
        $transfer->from_uid = $fromAcccount->uid;
        $transfer->to_uid = $toAccount->uid;
        $transfer->from_account_id = $fromAcccount->id;
        $transfer->to_account_id = $toAccount->id;
        $transfer->biz_id = $bizId;
        $transfer->biz_type = $bizType;
        $transfer->title = $title;
        $transfer->status = AccountTransfer::STATUS_SUCCESS;
        $transfer->save();
        $this->addLog($fromAcccount, '转出', $transfer);
        $this->addLog($toAccount, '转入', $transfer);

        return $transfer;
    }


    public function recharge($toAccount, $amount, $bizId, $bizType, $title)
    {
        $sysRechargeAccount = $this->user->getSystemRechargeAccount();

        return $this->transfer($sysRechargeAccount, $toAccount, $amount, $bizId, $bizType, $title);
    }
}