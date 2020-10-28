<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Question;
use App\Models\Choice;
use Illuminate\Support\Facades\DB;
use Inertia\Inertia;

class AdminController extends Controller
{
    public function showQuestion()
    {
        $questions = Question::all();
        $question_set = DB::table('question_set')->get();
        return Inertia::render(
            'Admin/Questions',
            [
                'questions' => $questions,
                'question_set' => $question_set
            ]
        );
    }

    public function storeQuestion(Request $request)
    {
        // validation

        $question = request()->question;
        $type = request()->type;
        $choices = request()->choices;
        $category = request()->category;

        $q = Question::create(
            [
                'text' => $question,
                'type' => $type,
                'quiz_id' => 1,
                'category_id' => $category
            ]
        );

        if ($q->id && request()->question_set) {
            DB::table('question_set')->insert(
                [
                    'set_id' => 1,
                    'question_id' => $q->id,
                    'depend_on' => request()->depend_on,
                    'condition' => request()->condition
                ]
            );
        }

        if ($q->id) {
            foreach ($choices as $item) {
                Choice::create(
                    [
                        'question_id' => $q->id,
                        'text' => $item['text'],
                        'correct_answer' => $item['is_correct']
                    ]
                );
            }
        }

        $questions = Question::all();
        $question_set = DB::table('question_set')->get();

        return redirect()->route(
            'admin.questions',
            [
                'questions' => $questions,
                'question_set' => $question_set
            ]
        );
    }

    public function deleteQuestion($id)
    {
        $question= Question::findOrFail($id);
        $question->delete();

        DB::table('question_set')
            ->where('question_id', $id)
            ->delete();

        $questions = Question::all();
        $question_set = DB::table('question_set')->get();

        return redirect()->route(
            'admin.questions',
            [
                'questions' => $questions,
                'question_set' => $question_set
            ]
        );
    }
}
