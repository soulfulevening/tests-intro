<?php

class FunctionalSubscribeCest
{
    public function _before(FunctionalTester $I)
    {
        $I->amOnPage('/');
    }

    public function emptyEmail(FunctionalTester $I)
    {
        $I->click('[name=\'subscribe_form\']');

        $I->seeInField('[name=\'email\']', '');
        $I->see('Email must be specified!', '.warning');

        $I->seeResponseCodeIs(200);

        $I->dontSeeElement('.error');
        $I->dontSeeElement('.success');
    }

    public function validEmail(FunctionalTester $I)
    {
        $I->fillField('[name=\'email\']', $I->generateRandomEmail());

        $I->click('[name=\'subscribe_form\']');

        $I->seeInField('[name=\'email\']', '');
        $I->see('Email successfully subscribed!', '.success');

        $I->dontSeeElement('.error');
        $I->dontSeeElement('.warning');
    }

    public function uniqueEmail(FunctionalTester $I)
    {
        $email = $I->generateRandomEmail();

        $I->fillField('[name=\'email\']', $email);

        $I->click('[name=\'subscribe_form\']');

        $I->seeInField('[name=\'email\']', '');
        $I->see('Email successfully subscribed!', '.success');

        $I->dontSeeElement('.error');
        $I->dontSeeElement('.warning');

        // Subscribe again

        $I->fillField('[name=\'email\']', $email);

        $I->click('[name=\'subscribe_form\']');

        $I->seeInField('[name=\'email\']', '');
        $I->see('This email is already subscribed!', '.warning');

        $I->dontSeeElement('.error');
        $I->dontSeeElement('.success');
    }

    public function invalidEmail(FunctionalTester $I)
    {
        $I->fillField('[name=\'email\']', 'abc');

        $I->click('[name=\'subscribe_form\']');

        $I->seeInField('[name=\'email\']', '');
        $I->seeInCurrentUrl('/');

        $I->see('Email is invalid', '.error');
        $I->dontSeeElement('.success');
        $I->dontSeeElement('.warning');
    }
}
