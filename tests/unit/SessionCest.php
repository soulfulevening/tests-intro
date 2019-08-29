<?php


class SessionCest
{

    public function _before(UnitTester $I)
    {
        session_abort();
        session_start();
        require_once __DIR__ . '/../../public/_inc/_session.php';
        unset($_SESSION['flashBag']);
        $I->assertArrayNotHasKey('flashBag', $_SESSION);
    }

    public function testWarnings(UnitTester $I)
    {
        addWarning('test warning');

        $I->assertArrayHasKey('warnings', $_SESSION['flashBag']);
        $I->assertTrue(in_array('test warning', $_SESSION['flashBag']['warnings']));
    }

    public function testError(UnitTester $I)
    {
        addError('test error');

        $I->assertArrayHasKey('errors', $_SESSION['flashBag']);
        $I->assertTrue(in_array('test error', $_SESSION['flashBag']['errors']));
    }

    public function testSuccess(UnitTester $I)
    {
        addSuccess('test success');

        $I->assertArrayHasKey('success', $_SESSION['flashBag']);
        $I->assertTrue(in_array('test success', $_SESSION['flashBag']['success']));
    }
}