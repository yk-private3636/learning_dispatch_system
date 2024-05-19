<?php

namespace App\Repositories;

use App\Models\GeneralUser;
use App\Repositories\AbstractRepository;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Query\Builder as QueryBuilder;

class GeneralUsersRepository extends AbstractRepository
{
    public function getModelClass(): string
    {
        return GeneralUser::class;
    }

    public function tableName(): string
    {
        return $this->model->getTable();
    }

    public function find(string $userId): ?GeneralUser
    {
        return $this->model->find($userId);
    }

    /**
     * 一般ユーザーをユニークキーで絞込み
     * 
     * @param string $email メールアドレス
     * @param bool $exeJudge 実行するか否か
     * @return null|\App\Models\AdminUser|\Illuminate\Database\Eloquent\Builder 実行結果
     */
    public function first(string $email, bool $exeJudge = true): null|GeneralUser|Builder
    {
        $query = $this->model->where('email', $email);

        return $exeJudge ? $query->first() : $query;
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

    public function firstOriginToken(string $token, bool $exeJudge = true): null|GeneralUser|Builder
    {
        $query = $this->model->where('email', function(QueryBuilder $subQuery) use($token) {
            $tableName = app()->make(ResetPasswordTokenRepository::class)->tableName();
            $subQuery->select([
                'email'
            ])
            ->from($tableName)
            ->where('token', $token);
        });

        return $exeJudge ? $query->first() : $query;
    }

    public function getOAuthUser(string $userId): ?GeneralUser
    {
        return $this->model->where('user_id', $userId)
                ->whereNull('password')
                ->first();
    }
}