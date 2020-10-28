<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Answer;
use Illuminate\Support\Facades\Auth;

class AnswerController extends Controller
{
    public function store(Request $request)
    {
        // validation

        $answers = request()->answers;
        $question_id = request()->question_id;
        $qsession_id = request()->qsession_id;
        if (is_array($answers)) {
            foreach ($answers as $answer) {
                Answer::create(
                    [
                        'question_id' => $question_id,
                        'choice_id' => $answer,
                        'user_id' => Auth::id(),
                        'qsession_id' => $qsession_id
                    ]
                );
            }
        } else {
            Answer::create(
                [
                    'question_id' => $question_id,
                    'choice_id' => $answers,
                    'user_id' => Auth::id(),
                    'qsession_id' => $qsession_id
                ]
            );
        }

        return redirect()->route(
            'next',
            [
                'question' => $question_id,
                'qsession' => $qsession_id
            ]
        );
    }
}
