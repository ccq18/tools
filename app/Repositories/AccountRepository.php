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
        $sysRechargeAccount = $this->user->getSystemRechargeAccount();
        $sysRechargeAccount->increment('amount', $amount);
        $transfer = new AccountTransfer();
        $transfer->amount = $amount;
        $transfer->to_uid = $fromAcccount->uid;
        $transfer->to_uid = $fromAcccount->uid;
        $transfer->from_account_id = $fromAcccount->id;
        $transfer->to_account_id = $toAccount->id;
        $transfer->biz_id = $bizId;
        $transfer->biz_type = $bizType;
        $transfer->title = $title;
        $transfer->save();

    }

    public function addTransfer($fromAcccount, $toAccount, $amount, $bizId, $bizType, $title)
    {

        //     * @property int $id
        // * @property int $from_uid 转出人
        // * @property int $to_uid 转入人
        // * @property int $from_account_id 转出账户
        // * @property int $to_account_id 转入账户
        // * @property string $biz_id 业务订单号
        // * @property int $biz_type 业务类型
        // * @property string $title
        // * @property int $status 1 成功 2 失败 3 撤回
        // * @property float $amount

    }

    public function recharge($amount, $bizId, $bizType, $toAccount)
    {
        // $this->account->transfer($amount,uniqid(),Account::TYPE_TRANSFER,Auth::user()->account,$toUser->account) ;

    }
}