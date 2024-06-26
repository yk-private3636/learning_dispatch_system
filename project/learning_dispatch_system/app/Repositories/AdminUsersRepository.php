<?php

namespace App\Repositories;

use App\Models\AdminUser;
use App\Repositories\AbstractRepository;
use App\Repositories\ResetPasswordTokenRepository;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Query\Builder as QueryBuilder;

class AdminUsersRepository extends AbstractRepository
{
    /**
     * リポジトリに紐づかせたいModelの完全修飾子の指定
     * 
     * @return string Modelの完全修飾子
     */
    public function getModelClass(): string
    {
        return AdminUser::class;
    }

    /**
     * 登録処理(バルクインサート可)
     * 
     * @param array $insertData 登録パラメータ
     * @return bool 登録処理が成功したか否か
     */
    public function insert(array $insertData): bool
    {
        return $this->model->insert($insertData);
    }

    /**
     * 更新処理
     * 
     * @param \App\Models\AdminUser $target 更新対象ユーザー
     * @param array $updData 更新パラメータ
     * @return \App\Models\AdminUser $target 更新対象ユーザー
     */
    public function update(AdminUser|Builder $target, array $updData): AdminUser|Builder
    {
        return tap($target)->update($updData);
    }

    /**
     * 更新処理後、最新化する
     * 
     * @param \App\Models\AdminUser $adminUser 更新対象ユーザー
     * @param array $updData 更新パラメータ
     * @return \App\Models\AdminUser $adminUser 更新後のユーザー
     */
    public function updateThenRefresh(AdminUser $adminUser, array $updData): AdminUser
    {
        return tap($adminUser)->update($updData)->refresh();
    }

    /**
     * 管理者ユーザーをユニークキーで絞込み
     * 
     * @param string $email メールアドレス
     * @return null|\App\Models\AdminUser 実行結果
     */
    public function first(string $email): ?AdminUser
    {
        return $this->model->where('email', $email)
                ->first();
    }

    /**
     * 管理者ユーザーをユニークキーで絞込み+利用ステータス(悲観的ロック:共用ロック)
     * 
     * @param string $email メールアドレス
     * @param int $usageStatus 利用ステータス
     * @return null|\App\Models\AdminUser 実行結果
     */
    public function whereStatusUniqueSharedLock(string $email, int $usageStatus): ?AdminUser
    {
        return $this->model->where('email', $email)
                ->where('usage_status', $usageStatus)
                ->sharedLock()
                ->first();
    }

    /**
     * 管理者ユーザーをユニークキーで絞込み+利用ステータス(悲観的ロック:共用ロック)
     * 
     * @param string $email メールアドレス
     * @param int[] $usageStatuies 複数利用ステータスの指定
     * @return null|\App\Models\AdminUser 実行結果
     */
    public function whereStatuiesUniqueSharedLock(string $email, array $usageStatuies): ?AdminUser
    {
        return $this->model->where('email', $email)
                ->whereIn('usage_status', $usageStatuies)
                ->sharedLock()
                ->first();
    }

    public function firstOriginToken(string $token): ?AdminUser
    {
        $query = $this->model->where('email', function(QueryBuilder $subQuery) use($token) {
            $tableName = app()->make(ResetPasswordTokenRepository::class)->tableName();
            $subQuery->select([
                'email'
            ])
            ->from($tableName)
            ->where('token', $token)
            ->where('user_division', \UserEnum::ADMIN->division());
        });

        return $query->first();
    }

    public function waitinigForUserDeletion(): void
    {
        DB::table($this->tableName())
                ->whereNotNull('deleted_at')
                ->whereDate('deleted_at', '<=', now()->subWeek())
                ->delete();
    }
}