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

    /**
     * リポジトリに紐づかせたテーブル名の取得
     * 
     * @return string テーブル名
     */
    public function tableName(): string
    {
        return $this->model->getTable();
    }

    public function first(string $token, bool $exeJudge = true): null|ResetPasswordToken|Builder
    {
        $query = $this->model->where('token', $token);

        return $exeJudge ? $query->first() : $query;
    }

    public function exists(string $token): bool
    {
        return $this->first($token, false)->exists();
    }

    public function activateTokenExists(string $token, int $userDivision): bool
    {
        return $this->first($token, false)
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
        return $this->first($token, false)
            ->with('generalUser')
            ->first();
    }

    public function tokenLinkAdminUser(string $token): ?ResetPasswordToken
    {
        return $this->first($token, false)
            ->with('adminUser')
            ->first();
    }

}