<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redis;
use Exception;
use JWTAuth;



class HomeController extends Controller
{
    public function view()
    {
        try {

            return response()->json(['success' => 'Authenticate']);
        } catch (Exception $e) {
            return response()->json(['exception' => $e]);
        }
    }
}
