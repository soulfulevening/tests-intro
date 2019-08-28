<?php

use Tokenly\TokenGenerator\TokenGenerator;

class IntegrationalEmailStorageCest
{
    public function _before(UnitTester $I)
    {
        require_once __DIR__ . '/../../public/_inc/_email_storage.php';
    }

    // tests
    public function testIsExists(UnitTester $I)
    {
        $I->assertFalse(isExists('some@test.email'));
    }

    public function testAdd(UnitTester $I)
    {
        $email = $this->genRandomEmail();

        $I->assertEquals(add($email), strlen($email . PHP_EOL));
        $I->assertTrue(isExists($email), 'email exists in list after insert');
    }

    private function genRandomEmail()
    {
        $generator = new TokenGenerator();

        return $generator->generateToken(10, 'QA-TEST-')
            . '@' . $generator->generateToken(5, 'Q')
            . '.' . $generator->generateToken(5, 'A');
    }
}
