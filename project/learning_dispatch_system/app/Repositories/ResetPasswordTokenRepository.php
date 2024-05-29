<?php

namespace App\Repositories;

use App\Repositories\AbstractRepository;
use App\Models\ResetPasswordToken;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;

class ResetPasswordTokenRepository extends AbstractRepository
{
    public function getModelClass(): string
    {
        return ResetPasswordToken::class;
    }

    public function first(string $token): ?ResetPasswordToken
    {
        return $this->model->where('token', $token)
                ->first();
    }

    public function exists(string $token): bool
    {
        return $this->model->where('token', $token)
                ->exists();
    }

    public function activateTokenExists(string $token, int $userDivision): bool
    {
        return $this->model->where('token', $token)
            ->where('user_division', $userDivision)
            ->whereRaw("NOW() < sended_at + INTERVAL 1 DAY")
            ->exists();
    }

    public function create(array $insertData): ResetPasswordToken
    {
        return $this->model->create($insertData);
    }

    public function loads(ResetPasswordToken $resetPasswordToken, array $loads): ResetPasswordToken
    {
        return $resetPasswordToken->load($loads);   
    }

    public function delete(ResetPasswordToken|Builder $target): int
    {
        return $target->delete();
    }

    public function expireToken(bool $exeJudge = true): Builder|Collection
    {
        $query = $this->model->whereRaw("NOW() >= sended_at + INTERVAL 1 DAY");

        return $exeJudge ? $query->get() : $query;
    }

    public function expireTokenDelete(): int
    {
        return $this->expireToken(false)->delete();
    }

    public function tokenLinkGeneralUser(string $token): ?ResetPasswordToken
    {
        return $this->model->where('token', $token)
            ->with('generalUser')
            ->first();
    }

    public function tokenLinkAdminUser(string $token): ?ResetPasswordToken
    {
        return $this->model->where('token', $token)
            ->with('adminUser')
            ->first();
    }

}