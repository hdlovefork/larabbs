<?php

namespace App\Listeners;

use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Facades\Log;

class QueryListener
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  object  $event
     * @return void
     */
    public function handle($event)
    {
        // 记录查询的SQL语句
        if(env('APP_DEBUG') && $event->sql){
            $sql = str_replace("?", "'%s'", $event->sql);
            foreach ($event->bindings as $k=>$v){
                if($v instanceof \DateTime){
                    $event->bindings[$k]=$v->format('Y-m-d H:i:s');
                }
            }
            $log = vsprintf($sql, $event->bindings);
            Log::info($log);
        }
    }
}
