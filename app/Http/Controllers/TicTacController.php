<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redis;


class TicTacController extends Controller
{
    /**
     * @param Request $request
     */
    public function publish(Request $request)
    {
        $from = $request->get('from');
        $token = 'token:'.$request->get('token') ?? '';
        $reason = $request->get('reason');
        if (isset($from) && isset($token) && isset($reason)) {
            if ($from === 2 && $reason === 'start') {
                $st = Redis::get($token);
                if (!$st) {
                    return response()->json(['error' => 'Invalid Request'], 400);
                }
            }

            Redis::publish('channel', json_encode($request->all()));

            return response()->json(['data'=> 'Success'], 200);
        }

        return response()->json(['error' => 'Invalid Request'], 400);
    }

    public function store(Request $request){
        $token = 'token:'.$request->get('token') ?? '';
        if (isset($token)) {
            Redis::set($token, 1);
            return response()->json(['data'=> 'Success'], 200);
        }
        return response()->json(['error' => 'Invalid Request'], 400);
    }
}
