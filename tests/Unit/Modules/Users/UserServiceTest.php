<?php

namespace Tests\Unit\Modules\Users;

use App\Models\User;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;
use Src\Modules\Users\DTO\UserData;
use Src\Modules\Users\Repositories\UserRepositoryInterface;
use Src\Modules\Users\Services\UserService;

class UserServiceTest extends TestCase
{
    private UserRepositoryInterface&MockObject $repository;

    private UserService $service;

    protected function setUp(): void
    {
        parent::setUp();

        $this->repository = $this->createMock(UserRepositoryInterface::class);
        $this->service = new UserService($this->repository);
    }

    public function test_create_passes_user_data_to_repository(): void
    {
        $data = new UserData(
            name: 'Alice',
            email: 'alice@example.com',
            password: 'secret-password',
        );
        $createdUser = new User();

        $this->repository
            ->expects($this->once())
            ->method('create')
            ->with([
                'name' => 'Alice',
                'email' => 'alice@example.com',
                'password' => 'secret-password',
            ])
            ->willReturn($createdUser);

        $this->assertSame($createdUser, $this->service->create($data));
    }

    public function test_paginate_delegates_database_query_to_repository(): void
    {
        $paginator = $this->createMock(LengthAwarePaginator::class);

        $this->repository
            ->expects($this->once())
            ->method('paginate')
            ->with(15)
            ->willReturn($paginator);

        $this->assertSame($paginator, $this->service->paginate(15));
    }

    public function test_update_does_not_overwrite_password_when_it_is_missing(): void
    {
        $user = new User();
        $data = new UserData(
            name: 'Updated Alice',
            email: 'alice@example.com',
            password: null,
        );

        $this->repository
            ->expects($this->once())
            ->method('update')
            ->with(
                $this->identicalTo($user),
                [
                    'name' => 'Updated Alice',
                    'email' => 'alice@example.com',
                ],
            )
            ->willReturn($user);

        $this->assertSame($user, $this->service->update($user, $data));
    }
}
