<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class Set extends Model
{
    use HasFactory;
    protected $guarded = [];

    function questions()
    {
        return $this->belongsToMany(Question::class, 'question_set', 'set_id', 'question_id')->withPivot(['depend_on', 'condition']);
    }

    function firstQuestion()
    {
        return $this->questions()->first();
    }

    function nextQuestion($question_id)
    {
        $question = Question::find($question_id);
        $type = $question->type;
        $user_id = Auth::id();
        $is_correct = false;
        $ids = [];

        foreach ($question->correctAnswers as $correct_answer) {
            $ids[] = $correct_answer->id;
        }

        if ($type == 'radio') {
            $answer = Answer::where(
                [
                    ['question_id', '=', $question_id],
                    ['user_id', '=', $user_id]
                ]
            )->first();
            if (in_array($answer->choice->id, $ids)) {
                $is_correct = true;
            }
        } else {
            $answers = Answer::where(
                [
                    ['question_id', '=', $question_id],
                    ['user_id', '=', $user_id]
                ]
            )->get();
            $answer_ids = [];
            foreach ($answers as $a) {
                $answer_ids[] = $a->choice_id;
            }
            sort($ids);
            sort($answer_ids);
            if ($ids == $answer_ids) {
                $is_correct = true;
            }
        }


        if ($is_correct) {
            $next = DB::table('question_set')
                ->where('depend_on', $question_id)
                ->where('condition', 'correct')
                ->first();
        } else {
            $next = DB::table('question_set')
                ->where('depend_on', $question_id)
                ->where('condition', 'incorrect')
                ->first();
        }

        if ($next != null) {
            return $next->question_id;
        }

        $next = DB::table('question_set')
            ->where('depend_on', null)
            ->where('question_id', '>', $question_id)
            ->first();
        if ($next != null) {
            return $next->question_id;
        }

        return false;
    }

}
