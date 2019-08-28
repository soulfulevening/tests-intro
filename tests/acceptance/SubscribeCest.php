<?php

use Tokenly\TokenGenerator\TokenGenerator;

class SubscribeCest
{
    public function _before(AcceptanceTester $I)
    {
        $I->amOnPage('/');
    }

    public function emptyEmail(AcceptanceTester $I)
    {
        $I->click('[name=\'subscribe_form\']');

        $I->seeInField('[name=\'email\']', '');
        $I->see('Email must be specified!', '.warning');

        $I->dontSeeElement('.error');
        $I->dontSeeElement('.success');
    }

    public function validEmail(AcceptanceTester $I)
    {
        $I->fillField('[name=\'email\']', $this->genRandomEmail());

        $I->click('[name=\'subscribe_form\']');

        $I->seeInField('[name=\'email\']', '');
        $I->see('Email successfully subscribed!', '.success');

        $I->dontSeeElement('.error');
        $I->dontSeeElement('.warning');
    }

    public function uniqueEmail(AcceptanceTester $I)
    {
        $email = $this->genRandomEmail();

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

    public function inValidEmail(AcceptanceTester $I)
    {
        $I->fillField('[name=\'email\']', 'abc');

        $I->click('[name=\'subscribe_form\']');

        $I->seeInField('[name=\'email\']', '');
        $I->seeInCurrentUrl('/');

        $I->see('Email is invalid', '.error');
        $I->dontSeeElement('.success');
        $I->dontSeeElement('.warning');
    }

    private function genRandomEmail()
    {
        $generator = new TokenGenerator();

        return $generator->generateToken(10, 'QA-TEST-')
            . '@' . $generator->generateToken(5, 'Q')
            . '.' . $generator->generateToken(5, 'A');
    }
}
