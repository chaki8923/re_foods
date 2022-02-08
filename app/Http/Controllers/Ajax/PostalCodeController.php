<?php

namespace App\Http\Controllers\Ajax;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\PostalCode;
use Illuminate\Support\Facades\Log;

class PostalCodeController extends Controller
{
    public function search(Request $request) {

     
        return PostalCode::whereSearch($request->first_code, $request->last_code)->first();

    }
}
