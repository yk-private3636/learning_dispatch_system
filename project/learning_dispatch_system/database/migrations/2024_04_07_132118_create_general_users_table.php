<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('general_users', function (Blueprint $table) {
            $table->string('user_id', 8)->comment('ユーザーID');
            $table->string('email')->comment('メールアドレス');
            $table->string('password')->comment('パスワード');
            $table->unsignedTinyInteger('usage_status')->default(1)->comment('利用ステータス');
            $table->timestamps();
            $table->softDeletes()->comment('削除日時');

            $table->primary('user_id');
            $table->unique('email');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('general_users');
    }
};
