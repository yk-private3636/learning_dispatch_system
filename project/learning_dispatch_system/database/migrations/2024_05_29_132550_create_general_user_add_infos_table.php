<?php

use App\Repositories\GeneralUsersRepository;
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
        Schema::create('general_user_add_infos', function (Blueprint $table) {
            $table->id();
            $table->string('user_id', 18)->comment('ユーザーID');
            $table->string('profile_picture_pass')->nullable()->comment('プロフィール画像パス');
            $table->string('introduction', 160)->nullable()->comment('自己紹介文');
            $table->string('github_link', 200)->nullable()->comment('GitHubリンク');
            $table->timestamps();

            $table->foreign('user_id')
                    ->references('user_id')
                    ->on(app()->make(GeneralUsersRepository::class)->tableName())
                    ->cascadeOnUpdate()
                    ->cascadeOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('general_user_add_infos');
    }
};
