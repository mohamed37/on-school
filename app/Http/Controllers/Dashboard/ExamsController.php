<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\BackEndController;
use App\Http\Requests\ExamsRequest;
use App\Models\Exam;
use App\Models\Subject;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ExamsController extends BackEndController
{
    public function __construct(Exam $model)
    {
        $columns = ['id'];
        parent::__construct($model, $columns);
    } // End of Construct Method

    protected function append()
    {
        return ['subjects' => Subject::whereDoesntHave('exams')->where('user_id', auth()->user()->id)->get()];
    }

    public function store(ExamsRequest $request)
    {
        DB::beginTransaction();
        $row = Exam::create($request->all());
        $this->count += 1;
        $view = view('dashboard.exams.row', compact('row'))->render();
        DB::commit();
        return response()->json(['view' => $view, 'message' => __('alerts.record_created'), 'title' => __('alerts.created'), 'id' => $row->id]);
    } // End of Store Exam

    public function update(ExamsRequest $request, Exam $exam)
    {
        try {
            DB::beginTransaction();
            $exam->update($request->all());
            $view = view('dashboard.exams.row', ['row' => $exam])->render();
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
            $exams = Exam::whereIn('id', (array)$request['id'])->get();
            if ($exams) {
                DB::beginTransaction();
                foreach ($exams as $exam) {
                    $exam->delete();
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
