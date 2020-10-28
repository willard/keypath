<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Set;
use App\Models\Question;
use App\Models\Qsession;
use App\Models\Category;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;

class QuizController extends Controller
{
    public function index()
    {
        $qsession = Qsession::create(
            [
                'user_id'=>1,
                'set_id'=>1,
                'session'=>Str::random(16)
            ]
        );

        $set = Set::find(1);
        $question = Question::find($set->firstQuestion()->id);
        return Inertia::render(
            'Quiz/Index',
            [
                'question' => [
                    'id' => $question->id,
                    'category'  => $question->category,
                    'text'   => $question->text,
                    'type' => $question->type,
                    'choices' => $question->choices,
                ],
                'qsession_id' => $qsession->id
            ]
        );
    }

    public function next($prev_question, $qsession)
    {
        $set = Set::find(1);
        if ($set->nextQuestion($prev_question)) {
            $question = Question::find($set->nextQuestion($prev_question));
            return Inertia::render(
                'Quiz/Index',
                [
                    'question' => [
                        'id' => $question->id,
                        'category'  => $question->category,
                        'text'   => $question->text,
                        'type' => $question->type,
                        'choices' => $question->choices
                    ],
                    'qsession_id' => $qsession
                ]
            );
        }

        return redirect()->route(
            'result'
        );
    }

    function result()
    {
        $set = Set::find(1);
        $questions = $set->questions;
        $answers = Auth::user()->answers;

        $categories = $questions->map(
            function ($item, $key) {
                return $item->category->id;
            }
        );

         $unique_catgeories = $categories->unique();

        $c = [];
        foreach ($unique_catgeories->values()->all() as $category ) {
            $set = Set::find(1);
            $questions = $set->questions;
            $q = $questions->map(
                function ($question, $key) {
                    return [
                        'id' => $question->id,
                        'category_id' => $question->category->id
                    ];
                }
            );

            $c[$category] = $q->where('category_id', $category)->values()->all();
        }

        // $results = [];
        // foreach ($c as $key=>$val) {
        //     $category = Category::find($key);
        //     $i = [];
        //     foreach ($val as $item) {
        //         $i = $item['id'];
        //     }
        //     $results[] = [
        //         $category->title,
        //         $i
        //     ];
        // }

        // $question_by_categories = $unique_catgeories->map(
        //     function ($item, $key) {
        //         $set = Set::find(1);
        //         $questions = $set->questions;
        //         $q = $questions->map(
        //             function ($question, $key) {
        //                 return [
        //                     'id' => $question->id,
        //                     'category_id' => $question->category->id
        //                 ];
        //             }
        //         );
        //         $return = $q->where('category_id', $item[0]);
        //         return  $return->values()->all();

        //     }
        // );

        // return $results;

        //$categories = Category::all();
        [
            '1' => [
                1,2
            ],
            '2' => [
                3,4,5
            ],
            '3' => [
                6,7
            ]
        ];




        $categories = [
            [
                'name' => 'history',
                'score' => 80
            ],
            [
                'name' => 'sport',
                'score' => 70
            ],
            [
                'name' => 'culture',
                'score' => 90
            ]
        ];

        return Inertia::render(
            'Quiz/Result',
            [
                'categories' => $categories,
                'q' => $unique_catgeories->values()->all()
            ]
        );
    }
}
