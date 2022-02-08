<?php


namespace app\common;

use Illuminate\Support\Facades\DB;

class getPushClass{
  public static function getPush(){

            $pertner = DB::table('stores')
            ->join('messages', 'stores.id', '=', 'messages.from_store')
            ->select('*')
            ->where('new_flg', true)
            ->where('to_store', session()->get('id'))
            ->where('from_store', '<>', session()->get('id'))
            ->groupBy('store_name')
            ->get();

            return $pertner;

        
  }
}