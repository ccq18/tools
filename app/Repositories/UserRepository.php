<?php

namespace App\Repositories;

use App\Model\Account\Account;
use App\Model\Account\AccountTransfer;
use App\Model\Account\SystemAccount;
use App\Model\SystemUser;
use App\Model\User;

/**
 * Class UserRepository
 * @package App\Repositories
 */
class UserRepository extends BaseRepository
{
    protected $bindClass = User::class;

    /**
     * @param $id
     * @return User
     */
    public function byId($id)
    {
        $user = User::find($id);

        return $user;
    }

    /**
     * @param $userName
     * @return User
     */
    public function byUserNameOrFail($userName)
    {
        return User::whereName($userName)->where('type',User::USER_NORMAL)->firstOrFail();

    }

    protected function initAccountIfNotExist(User $user)
    {
        if ($user->type == User::USER_NORMAL &&
            (empty($user->account_id) || empty($user->frozen_account_id))
        ) {
            if (empty($user->account_id)) {
                $account = resolve(AccountRepository::class)->create($user->id, Account::ACCOUNT_AMOUNT, '资金账户');
                $user->account_id = $account->id;
            }
            if (empty($user->frozen_account_id)) {
                $account = resolve(AccountRepository::class)->create($user->id, Account::ACCOUNT_AMOUNT, '冻结金额账户');
                $user->frozen_account_id = $account->id;
            }
            $user->save();
        }


    }

    public function createSimple($email,$pwd='123456')
    {
       return $this->create(
            new User(['name' =>  $email,
                      'email' => $email,
                      'avatar' => '/images/avatars/default.png',
                      'password' => bcrypt($pwd),
                      'api_token' => str_random(60),
                      'settings' => ['city' => ''],
            ])
        );
    }
    public function create(User $user, $type = User::USER_NORMAL)
    {
        if (!$this->checkInConst('USER', $type)) {
            return false;
        }
        $user->is_active = 1;
        $user->type = $type;
        $user->confirmation_token = str_random(40);
        $user->save();
        if ($user->type == User::USER_NORMAL) {
            $this->initAccountIfNotExist($user);
        } else {
            if ($user->type == User::USER_SYSTEM) {
                $this->initSystemAccount($user);
            }
        }
    }

    public function initSystemAccount(User $user)
    {
        $account = resolve(AccountRepository::class)->create($user->id, Account::ACCOUNT_SYSTEM, '系统充值账户');
        $systemAccount = new SystemAccount();
        $systemAccount->account_id = $account->id;
        $systemAccount->uid = $user->id;
        $systemAccount->type = SystemAccount::TYPE_RECHARGE;
        $systemAccount->save();
    }

    /**
     * @return Account
     */
    public function getSystemRechargeAccount()
    {
        $accounts = SystemUser::whereId( SystemUser::SYSTEM_UID)->first()->accounts;
        return collect($accounts)->random(1)->first();
    }
}