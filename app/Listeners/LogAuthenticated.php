<?php

namespace App\Listeners;

use App\Events\UserAccessed; 
use Illuminate\Auth\Events\Authenticated;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class LogAuthenticated
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
     * @param  Authenticated  $event
     * @return void
     */
    public function handle(Authenticated $event)
    {
        $store = $event->store;

        if(!$store->is_online) { // 👈 最終アクセスが15分より前の場合

            UserAccessed::dispatch(); // 👈 ここでイベントを実行しています

        }

        $store->last_accessed_at = now(); // 👈 アクセス日時を更新
        $store->save();
    }
}
