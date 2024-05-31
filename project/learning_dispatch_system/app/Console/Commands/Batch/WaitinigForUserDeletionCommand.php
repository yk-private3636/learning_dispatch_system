<?php

namespace App\Console\Commands\Batch;

use App\Repositories\GeneralUsersRepository;
use App\Repositories\AdminUsersRepository;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class WaitinigForUserDeletionCommand extends Command
{
    public function __construct(
        private GeneralUsersRepository $generalUser,
        private AdminUsersRepository $adminUser
    ){
        parent::__construct();
    }

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'batch:waitinig-for-user-deletion';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = '削除待機中のユーザーを完全削除';

    /**
     * Execute the console command.
     */
    public function handle(): int
    {
        DB::beginTransaction();
        try {
            $this->generalUser->waitinigForUserDeletion();
            $this->adminUser->waitinigForUserDeletion();
            DB::commit();
        } catch (\Exception $e) {
            DB::rollback();
            $this->error(__('text.break'));
            $this->error($this->signature);
            $this->error($e);
            $this->error(__('text.break'));
            return Command::INVALID;
        }

        return Command::SUCCESS;
    }
}
