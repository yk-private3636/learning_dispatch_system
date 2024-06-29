<?php

namespace Tests\Traits;

use App\Repositories\AdminUsersRepository;
use App\Repositories\GeneralUsersRepository;

trait Auth
{
    protected function Authenticating(): void
    {
        $identifier = explode('\\', static::class)[2];

        match ($identifier) {
            'Admin'   => $this->AdminAuthenticating(),
            'General' => $this->GeneralAuthenticating(),
        };
    }

    private function AdminAuthenticating(): void
    {
       $app = app()->make(AdminUsersRepository::class);

       $user = $app->factories(1)->first();

       $this->actingAs($user, \UserEnum::ADMIN->guardName());
    }

    private function GeneralAuthenticating(): void
    {
       $app = app()->make(GeneralUsersRepository::class);

       $user = $app->factories(1)->first();

       $this->actingAs($user, \UserEnum::GENERAL->guardName());
    }
}