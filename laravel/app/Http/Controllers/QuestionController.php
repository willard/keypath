<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Question;
use App\Models\Set;
use Inertia\Inertia;

class QuestionController extends Controller
{
    public function index()
    {
        $set = Set::find(1);
        $data = $set->data;
        return $data;
    }

    public function show($id)
    {
        $set = Set::find(1);
        $question = Question::find($set->firstQuestion());

        return Inertia::render(
            'Question/Index',
            [
                'question' => [
                    'id' => $question->id,
                    'category'  => $question->category,
                    'text'   => $question->text,
                    'type' => $question->type,
                    'choices' => $question->choices
                ],
            ]
        );
    }


    public function store(Request $request)
    {
        $validator = Validator::make(
            $request->all(),
            [
                'name' => 'required|max:255',
                'street_id' => 'required|exists:streets,id',
            ]
        );

        if ($validator->fails()) {
            return  response()->json($validator->messages(), 200);
        }

        return Question::create($request->all());


    }

    public function update(Request $request, $id)
    {
        $validator = Validator::make(
            $request->all(),
            [
                'name' => 'sometimes|required|max:255',
                'street_id' => 'sometimes|exists:streets,id',
            ]
        );

        if ($validator->fails()) {
            return  response()->json($validator->messages(), 200);
        }

        $question= Question::findOrFail($id);
        $question->update($request->all());
        return $question;
    }

    public function delete(Request $request, $id)
    {
        $question= Question::findOrFail($id);
        $question->delete();

        return 204;
    }
}
