<?php
// $I = new AcceptanceTester($scenario);
// $I->wantTo('perform actions and see result');
$I = new AcceptanceTester($scenario);
$I->wantTo('ensure that frontpage works');
$I->amOnPage('/');
$I->see('123');
