<?php

namespace App\Providers\Auth;

use App\Models\GeneralUser;
use Illuminate\Auth\EloquentUserProvider;
use Illuminate\Contracts\Auth\Authenticatable as UserContract;
use Illuminate\Contracts\Auth\UserProvider;
use Illuminate\Contracts\Auth\Authenticatable;

class UserAuthProvider extends EloquentUserProvider implements UserProvider
{
    /**
     * retrieveByCredentials をオーバーライドし、$credentialsから認証対象のEloquentモデルを取得する処理をカスタマイズする。
     * Retrieve a user by the given credentials.
     * @see \Illuminate\Auth\EloquentUserProvider::retrieveByCredentials()
     * @see \Illuminate\Auth\SessionGuard::attempt()
     * @see \Illuminate\Auth\SessionGuard::validate()
     * @param  array  $credentials
     * @return Authenticatable|null
     */
    // public function retrieveByCredentials(array $credentials)
    // {
    //     return parent::retrieveByCredentials($credentials);
    // }

    /**
     * validateCredentials をオーバーライドして、$credentials に対する検査内容をカスタマイズする。
     *
     * @see \Illuminate\Auth\EloquentUserProvider::validateCredentials()
     * @see \Illuminate\Auth\SessionGuard::attempt()
     * @see \Illuminate\Auth\SessionGuard::validate()
     * @param UserContract $user
     * @param array $credentials
     * @return bool
     */
    // public function validateCredentials(UserContract $user, array $credentials)
    // {
    //     //Do anything
    //     //retrieveByCredentials() により得られたModelに対するパスワードの突合などをカスタマイズする場合はココ
    // }
}


