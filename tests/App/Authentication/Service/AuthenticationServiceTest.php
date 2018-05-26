<?php

namespace AppTest\App\Authentication\Service;

use App\Authentication\Repository\UserRepositoryInterface;
use App\Authentication\Service\AuthenticationService;
use App\Authentication\User;
use PHPUnit\Framework\TestCase;

class AuthenticationServiceTest extends TestCase
{
	public function testShouldReturnsAnonymousToken()
	{
		$login = "test";
        /** @var UserRepositoryInterface|\PHPUnit_Framework_MockObject_MockObject $repository */
		$repository = $this->createMock(UserRepositoryInterface::class);
		$repository
			->expects($this->any()) // replace with $this->once()
			->method('findByLogin')
			->with($login)
			->willReturn(null);

		$service = new AuthenticationService($repository);
		$userToken = $service->authenticate("test 1234");
		$this->assertTrue($userToken->isAnonymous());
	}

    public function testShouldReturnsAnonymousToken2()
    {
        $user = new User(1, 'test', '12345');
        $login = "test";
        /** @var UserRepositoryInterface|\PHPUnit_Framework_MockObject_MockObject $repository */
        $repository = $this->createMock(UserRepositoryInterface::class);
        $repository
            ->expects($this->any()) // replace with $this->once()
            ->method('findByLogin')
            ->with($login)
            ->willReturn($user);

        $service = new AuthenticationService($repository);
        $userToken = $service->authenticate("test 1234");
        $this->assertTrue($userToken->isAnonymous());
    }

    public function testShouldReturnsAnonymousToken3()
    {
        $user = new User(1, 'test', 'test');
        $login = "test";
        /** @var UserRepositoryInterface|\PHPUnit_Framework_MockObject_MockObject $repository */
        $repository = $this->createMock(UserRepositoryInterface::class);
        $repository
            ->expects($this->any()) // replace with $this->once()
            ->method('findByLogin')
            ->with($login)
            ->willReturn($user);

        $service = new AuthenticationService($repository);
        $userToken = $service->authenticate("test test");
        $this->assertFalse($userToken->isAnonymous());
    }
}