<?php

namespace App\Console\Commands;

use App\Models\User;
use Illuminate\Console\Command;

class GenerateToken extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'larabbs:generate-token {userId : 用户id}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = '快速为用户生成token';

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
    public function handle()
    {
        if (count($this->arguments()) === 0) {
            $this->error('请输入userId');
        }
        $user = User::find($this->argument('userId'));
        if (!$user) {
            return $this->error('用户不存在');
        }
        $ttl = 365 * 24 * 60;
        $this->info(\Auth::guard('api')->setTTL($ttl)->fromUser($user));
    }
}
