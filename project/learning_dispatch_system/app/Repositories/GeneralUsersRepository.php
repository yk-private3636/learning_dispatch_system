<?php

namespace App\Repositories;

use App\Models\GeneralUser;
use App\Repositories\AbstractRepository;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Query\Builder as QueryBuilder;

class GeneralUsersRepository extends AbstractRepository
{
    public function getModelClass(): string
    {
        return GeneralUser::class;
    }

    /**
     * 一般ユーザーをユニークキーで絞込み
     * 
     * @param string $email メールアドレス
     * @return null|\App\Models\GeneralUser 実行結果
     */
    public function first(string $email): ?GeneralUser
    {
        return $this->model->where('email', $email)
                ->first();
    }

    public function create(array $createData): GeneralUser
    {
        return $this->model->create($createData);
    }

    public function insert(array $insertData): bool
    {
        return $this->model->insert($insertData);
    }

     /**
     * 更新処理
     * 
     * @param \App\Models\GeneralUser $target 更新対象ユーザー
     * @param array $updData 更新パラメータ
     * @return \App\Models\GeneralUser $target 更新対象ユーザー
     */
    public function update(GeneralUser|Builder $target, array $updData): GeneralUser|Builder
    {
        return tap($target)->update($updData);
    }

    public function delete(GeneralUser|Builder $target, array $updData): int
    {
        return $target->delete();
    }

    public function firstOriginToken(string $token): ?GeneralUser
    {
        $query = $this->model->where('email', function(QueryBuilder $subQuery) use($token) {
            $tableName = app()->make(ResetPasswordTokenRepository::class)->tableName();
            $subQuery->select([
                'email'
            ])
            ->from($tableName)
            ->where('token', $token);
        });

        return $query->first();
    }

    public function getOAuthUser(string $userId): ?GeneralUser
    {
        return $this->model->where('user_id', $userId)
                ->whereNull('password')
                ->first();
    }

    public function waitinigForUserDeletion(): void
    {
        DB::table($this->tableName())
                ->whereNotNull('deleted_at')
                ->whereDate('deleted_at', '<=', now()->subWeek())
                ->delete();
    }

    public function getRandomUserId(): GeneralUser
    {
        return $this->model->select([
            'user_id'
        ])
        ->inRandomOrder()
        ->limit(1)
        ->first();
    }
}