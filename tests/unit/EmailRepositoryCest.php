<?php


use Subscription\Exceptions\EmailAlreadyExistsException;
use Tokenly\TokenGenerator\TokenGenerator;

class EmailRepositoryCest
{

    const TEST_FILE_PATH = __DIR__ . '/../_output/test_subscription_list.txt';

    /**
     * @var \Subscription\EmailRepository
     */
    private $storage;

    public function _before(UnitTester $I)
    {
        file_put_contents(self::TEST_FILE_PATH, '', FILE_TEXT);
        $this->storage = new \Subscription\EmailRepository(self::TEST_FILE_PATH);
    }

    // tests
    public function testNotExists(UnitTester $I)
    {
        $I->assertFalse($this->storage->exists('some@test.email'));
    }

    // run unit \EmailRepositoryCest::testAdd --debug
    public function testAdd(UnitTester $I)
    {
        $email = $I->generateRandomEmail();

        $this->storage->persist($email);
        $this->storage->flush();

        $I->assertTrue($this->storage->exists($email));

        $I->expectException(EmailAlreadyExistsException::class, function () use ($email) {
            $this->storage->persist($email);
        });
    }
}