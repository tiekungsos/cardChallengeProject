<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Score;
use Illuminate\Support\Facades\Auth;

class ScoreController extends Controller
{
    public function getScoreUser()
    {
        $score = Score::select('score')->orderBy('score', 'asc')->where('user_id', Auth::user()->id)->first();
        $gobalScore = Score::select('score')->orderBy('score', 'asc')->first();

        // $user = Score::find(Auth::user()->id);
        return response()->json([
            'status' => 'success',
            'data' => $score,
            'bestScore' => $gobalScore
        ]);
    }

    public function saveScoreUser(Request $request)
    {

        $score = $request->score;
        $status = '';
        $message = '';
        try {
            if(isset($score) && $score > 0) {
                $ScoreModel = new Score;
                $ScoreModel->score = $score;
                $ScoreModel->user_id = Auth::user()->id;
                $ScoreModel->save();
                $status = 200;
                $message = 'success save score';

            }
        } catch (\Throwable $th) {
            //throw $th;
            $status = 401;
            $message = $th->getMessage();
        }
      
    
        return response()->json([
            'status' => $status,
            'message' => $message
        ], $status);

    }


    
}
