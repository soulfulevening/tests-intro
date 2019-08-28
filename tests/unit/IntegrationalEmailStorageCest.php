<?php

use Subscription\EmailStorage;
use Subscription\Exceptions\EmailAlreadyExistsException;
use Tokenly\TokenGenerator\TokenGenerator;

class IntegrationalEmailStorageCest
{
    const TEST_FILE_PATH = __DIR__ . '/../_output/test_subscription_list.txt';

    /**
     * @var EmailStorage
     */
    private $storage;

    public function _before(UnitTester $I)
    {
        file_put_contents(self::TEST_FILE_PATH, '', FILE_TEXT);
        $this->storage = new EmailStorage(self::TEST_FILE_PATH);
    }

    // tests
    public function testNotExists(UnitTester $I)
    {
        $I->assertFalse($this->storage->exists('some@test.email'));
    }

    public function testAdd(UnitTester $I)
    {
        $email = $this->genRandomEmail();

        $this->storage->persist($email);
        $this->storage->flush();

        $I->assertTrue($this->storage->exists($email));

        $I->expectException(EmailAlreadyExistsException::class, function () use ($email) {
            $this->storage->persist($email);
        });
    }

    private function genRandomEmail()
    {
        $generator = new TokenGenerator();

        return $generator->generateToken(10, 'QA-TEST-')
            . '@' . $generator->generateToken(5, 'Q')
            . '.' . $generator->generateToken(5, 'A');
    }
}
