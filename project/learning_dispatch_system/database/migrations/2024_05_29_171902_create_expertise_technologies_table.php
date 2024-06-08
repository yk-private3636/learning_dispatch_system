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
        Schema::create('expertise_technologies', function (Blueprint $table) {
            $table->id();
            $table->string('user_id', 18)->comment('ユーザーID');
            $table->string('name', 50)->collation('utf8mb4_unicode_ci')->comment('技術名');
            $table->timestamps();

            $table->foreign('user_id')
                ->references('user_id')
                ->on(app()->make(GeneralUsersRepository::class)->tableName())
                ->cascadeOnUpdate()
                ->cascadeOnDelete();

            $table->unique(['user_id', 'name']);
            $table->index('user_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('expertise_technologies');
    }
};
