<?php


class EmailRepositoryTest extends \PHPUnit\Framework\TestCase
{

    use RandomEmailTrait;

    public function testNotExists()
    {
        $repository = new \Subscription\EmailRepository(
            $this->getEmailProviderStub()
        );

        $this->assertFalse($repository->exists('some@test.email'));
    }

    public function testAdd()
    {
        $email = $this->generateRandomEmail();

        $emailProviderMock = $this->getEmailProviderStub();
        $emailProviderMock
            ->expects($this->once())
            ->method('appendMany')
            ->with([$email]);

        $emailProviderMock
            ->expects($this->at(1))
            ->method('fetchAll')
            ->willReturn([]);

        $emailProviderMock
            ->expects($this->at(2))
            ->method('fetchAll')
            ->willReturn([$email]);

        $repository = new \Subscription\EmailRepository($emailProviderMock);

        $repository->persist($email);
        $repository->flush();

        $this->assertTrue($repository->exists($email));

        $this->expectException(\Subscription\Exceptions\EmailAlreadyExistsException::class);
        $repository->persist($email);
    }

    private function getEmailProviderStub()
    {
        $stub = $this->createMock(\Subscription\EmailsProviderInterface::class);

        return $stub;
    }
}