<?php

namespace App\Http\Controllers\Dashboard;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Exports\UsersExport;
use App\Http\Controllers\BackEndController;
use App\Http\Requests\ImportRequest;
use App\Http\Requests\UsersRequest;
use App\Imports\UsersImport;
use Maatwebsite\Excel\Facades\Excel;

class UsersController extends BackEndController
{
    public function __construct(User $model)
    {
        $columns = ['id', 'username', 'email'];
        parent::__construct($model, $columns);
    } // End of Construct Method

    public function store(UsersRequest $request)
    {
        DB::beginTransaction();
        $row = User::create($request->except(['role']))->attachRole($request['role']);
        $this->count += 1;
        $view = view('dashboard.users.row', compact('row'))->render();
        DB::commit();
        return response()->json(['view' => $view, 'message' => __('alerts.record_created'), 'title' => __('alerts.created'), 'id' => $row->id]);
    } // End of Store User

    public function update(UsersRequest $request, User $user)
    {
        try {
            DB::beginTransaction();
            $oldImage = $user->image;
            $user->update($request->all());
            $user->syncRoles([$request['role']]);
            if ($request->has('image')) {
                removeImage($oldImage, 'users');
            }
            $view = view('dashboard.users.row', ['row' => $user])->render();
            DB::commit();
            return response()->json([
                'view'      => $view,
                'message'   => __('alerts.record_updated'),
                'title'     => __('alerts.updated'),
                'id'        => $user->id,
                'type'      => 'update',
                'count'     => User::count()
            ]);
        } catch (\Exception $e) {
            return response()->json($e->getMessage(), 404);
        }
    } // End of Update User

    public function destroy(Request $request)
    {
        try {
            $users = User::whereIn('id', (array)$request['id'])->get();
            if ($users) {
                DB::beginTransaction();
                foreach ($users as $user) {
                    $user->delete();
                    $this->count -= 1;
                }
                DB::commit();
                return response()->json(['message' => __('alerts.destroyed_successfully'), 'title' => __('alerts.destroy')]);
            }
        } catch (\Exception $e) {
            return response()->json($e->getMessage(), 500);
        }
    } // End of Soft Delete Users [ Single & Multi ]

    public function export($file)
    {
        if ($file === 'excel')
            return Excel::download(new UsersExport, 'users.xlsx');

        if ($file === 'csv')
            return Excel::download(new UsersExport, 'users.csv');
    } // End of Export Files

    public function import(ImportRequest $request)
    {
        Excel::queueImport(new UsersImport, $request->file('file'));
        return response()->json(['message' => __('alerts.importing_message'), 'title' => __('alerts.importing')]);
    } // End of Import Files

    public function card(User $user)
    {
        return response()->json(view('dashboard.users._card', compact('user'))->render());
    } // End of View User Card

} // END OF USERS CONTROLLER
