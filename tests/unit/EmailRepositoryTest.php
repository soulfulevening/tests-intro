<?php


class EmailRepositoryTest extends \PHPUnit\Framework\TestCase
{

    use RandomEmailTrait;

    public function testEmailsRenewOnConstruct()
    {
        $providerMock = $this->getEmailProviderStub();
        $providerMock
            ->expects($this->once())
            ->method('fetchAll')
            ->willReturn([
                'a@a.a',
                'b@b.b'
            ]);

        $repository = new \Subscription\EmailRepository(
            $providerMock
        );

        $this->assertTrue($repository->exists('a@a.a'));
        $this->assertTrue($repository->exists('b@b.b'));
        $this->assertFalse($repository->exists('c@c.c'));
    }

    public function testPersistExisted()
    {
        $providerMock = $this->getEmailProviderStub();
        $providerMock
            ->expects($this->once())
            ->method('fetchAll')
            ->willReturn([
                'a@a.a'
            ]);

        $repository = new \Subscription\EmailRepository(
            $providerMock
        );

        $this->expectException(\Subscription\Exceptions\EmailAlreadyExistsException::class);
        $repository->persist('a@a.a');
    }

    public function testPersistNotExisted()
    {
        $providerMock = $this->getEmailProviderStub();
        $providerMock
            ->expects($this->once())
            ->method('appendMany')
            ->with(['a@a.a']);

        $repository = new \Subscription\EmailRepository(
            $providerMock
        );

        $repository->persist('a@a.a');
        $repository->flush();
    }

    public function testFlushWithError()
    {
        $providerMock = $this->getEmailProviderStub();
        $providerMock
            ->expects($this->once())
            ->method('appendMany')
            ->willThrowException(new Exception());

        $repository = new \Subscription\EmailRepository(
            $providerMock
        );

        $this->expectException(\Subscription\Exceptions\EmailStorageException::class);
        $repository->flush();
    }

    public function testFlush()
    {
        $providerMock = $this->getEmailProviderStub();

        $providerMock
            ->expects($this->exactly(2))
            ->method('appendMany');

        $providerMock
            ->expects($this->at(1))
            ->method('appendMany')
            ->with(['a@a.a']);

        $providerMock
            ->expects($this->at(3))
            ->method('appendMany')
            ->with([]);

        $repository = new \Subscription\EmailRepository(
            $providerMock
        );

        $repository->persist('a@a.a');
        $repository->flush();
        $repository->flush();
    }


    private function getEmailProviderStub()
    {
        $stub = $this->createMock(\Subscription\EmailsProviderInterface::class);

        return $stub;
    }
}