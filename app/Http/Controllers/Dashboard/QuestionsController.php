<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\BackEndController;
use App\Http\Requests\QuestionsRequest;
use App\Models\Question;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class QuestionsController extends BackEndController
{
    public function __construct(Question $model)
    {
        $columns = ['id'];
        parent::__construct($model, $columns);
    } // End of Construct Method

    public function store(QuestionsRequest $request)
    {
        DB::beginTransaction();
        $row = Question::create($request->all());
        $this->count += 1;
        $view = view('dashboard.questions.row', compact('row'))->render();
        DB::commit();
        return response()->json(['view' => $view, 'message' => __('alerts.record_created'), 'title' => __('alerts.created'), 'id' => $row->id]);
    } // End of Store Exam

    public function update(QuestionsRequest $request, Question $exam)
    {
        try {
            DB::beginTransaction();
            $exam->update($request->all());
            $view = view('dashboard.questions.row', ['row' => $exam])->render();
            DB::commit();
            return response()->json([
                'view'      => $view,
                'message'   => __('alerts.record_updated'),
                'title'     => __('alerts.updated'),
                'type'      => 'update',
            ]);
        } catch (\Exception $e) {
            return response()->json($e->getMessage(), 404);
        }
    } // End of Update User

    public function destroy(Request $request)
    {
        try {
            $questions = Question::whereIn('id', (array)$request['id'])->get();
            if ($questions) {
                DB::beginTransaction();
                foreach ($questions as $question) {
                    $question->delete();
                    $this->count -= 1;
                }
                DB::commit();
                return response()->json(['message' => __('alerts.destroyed_successfully'), 'title' => __('alerts.destroy')]);
            }
        } catch (\Exception $e) {
            return response()->json($e->getMessage(), 500);
        }
    } // End of Soft Delete Users [ Single & Multi ]
}
