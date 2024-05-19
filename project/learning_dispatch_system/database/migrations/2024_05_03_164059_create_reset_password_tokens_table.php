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
        Schema::create('reset_password_tokens', function (Blueprint $table) {
            $table->id();
            $table->string('email')->comment('メールアドレス');
            $table->string('token', 60)->comment('識別トークン');
            $table->unsignedTinyInteger('user_division')->comment('ユーザー区分');
            $table->timestamp('sended_at')->useCurrent()->comment('送信日時');
            $table->timestamp('updated_at')->comment('更新日時');

            $table->unique('token');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('reset_password_tokens');
    }
};
