<?php


class FileEmailsProviderCest
{
    const TEST_FILE_PATH = __DIR__ . '/../_output/test_subscription_list.txt';


    public function testFetchAll(UnitTester $I)
    {
        file_put_contents(self::TEST_FILE_PATH, 'test@qa.mail' . PHP_EOL . 'test_2@qa'  . PHP_EOL, FILE_TEXT);
        $provider = new \Subscription\FileEmailsProvider(self::TEST_FILE_PATH);

        $I->assertSame(['test@qa.mail', 'test_2@qa'], $provider->fetchAll());
    }

    public function testAppendMany(UnitTester $I)
    {
        file_put_contents(self::TEST_FILE_PATH, 'test@qa.mail' . PHP_EOL . 'test_2@qa' . PHP_EOL, FILE_TEXT);
        $provider = new \Subscription\FileEmailsProvider(self::TEST_FILE_PATH);

        $provider->appendMany(['test3@qa.mail', 'test4@qa.mail']);

        $I->assertSame(['test@qa.mail', 'test_2@qa', 'test3@qa.mail', 'test4@qa.mail'], $provider->fetchAll());
    }
}