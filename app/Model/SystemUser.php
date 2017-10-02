<?php

namespace App\Model;


use App\Model\Account\Account;

/**
 * Class SystemUser
 * @package App\Model
 * @property-read \App\Model\Account\Account[] $accounts
 */
class SystemUser extends User
{
    public function accounts()
    {
        return $this->hasMany(Account::class, 'uid', 'id');
    }

}