<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\User;
class SyncUserActiveAt extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'larabbs:sync-user-active-at';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = '将用户最后登录时间从 Redis 同步到数据库中';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle(User $user)
    {
        //执行活跃时间同步
        $user->syncUserActiveAt();
        $this->info("用户活跃数据同步成功！");    }
}
