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
        Schema::create('admin_users', function (Blueprint $table) {
            $table->id();
            $table->string('email')->comment('メールアドレス');
            $table->string('password')->comment('パスワード');
            $table->string('family_name', 30)->comment('名字');
            $table->string('name', 30)->comment('名前');
            $table->unsignedTinyInteger('usage_status')->default(0)->comment('利用ステータス');
            $table->unsignedTinyInteger('mistake_num')->default(0)->comment('パスワード入力間違え回数');
            $table->dateTime('lock_duration')->nullable()->comment('ロック期間');
            $table->timestamps();
            $table->softDeletes()->comment('削除日時');

            $table->unique('email');
        });

        // $tableName = app()->make(AdminUsersRepository::class)->tableName();
        // DB::statement("ALTER TABLE {$tableName} MODIFY id INT(5) ZEROFILL AUTO_INCREMENT");
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('admin_users');
    }
};
