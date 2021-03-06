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

        if(!$store->is_online) { // ๐ ๆ็ตใขใฏใปในใ15ๅใใๅใฎๅ ดๅ

            UserAccessed::dispatch(); // ๐ ใใใงใคใใณใใๅฎ่กใใฆใใพใ

        }

        $store->last_accessed_at = now(); // ๐ ใขใฏใปในๆฅๆใๆดๆฐ
        $store->save();
    }
}
