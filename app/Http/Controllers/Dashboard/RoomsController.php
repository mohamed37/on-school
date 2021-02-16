<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\BackEndController;
use App\Http\Requests\RoomsRequest;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use App\Models\Room;
use App\Models\Row;

class RoomsController extends BackEndController
{
    public function __construct(Room $model)
    {
        $columns =  ['name'];
        parent::__construct($model, $columns);
    } // End of Construct Method

    public function append()
    {
        return ['classes' => Row::get()];
    } // End of append Method

    public function store(RoomsRequest $request)
    {
        try {
            if ($this->is_exists($request['name'], $request['row_id']) > 0)
                return  response()->json(['errors' => ['name' => [__('rooms.exists')]]], 422);

            DB::BeginTransaction();
            $row = Room::create($request->all());
            $view = view('dashboard.rooms.row', compact('row'))->render();
            DB::Commit();
            return response()->json([
                'view' => $view, 'message' => __('alerts.record_created'),
                'title' => __('alerts.created')
            ]);
        } catch (\Exception $e) {
            return response()->json($e->getMessage(), 404);
        }
    }

    public function update(RoomsRequest $request, Room $room)
    {
        try {
            DB::beginTransaction();
            if ($this->is_exists($request['name'], $request['row_id'], $room->id) > 0)
                return  response()->json(['errors' => ['name' => [__('rooms.exists')]]], 422);

            $room->update($request->all());

            $view = view('dashboard.rooms.row', ['row' => $room])->render();
            DB::commit();
            return response()->json([
                'view'      => $view,
                'message'   => __('alerts.record_updated'),
                'title'     => __('alerts.updated'),
                'id'        => $room->id,
                'type'      => 'update',
                'count'     => Room::count(),
            ]);
        } catch (\Exception $e) {
            return response()->json($e->getMessage(), 404);
        }
    } // End of Update Row

    public function destroy(Request $request)
    {
        try {
            $rows = Room::whereIn('id', (array)$request['id'])->get();
            if ($rows) {
                DB::beginTransaction();
                foreach ($rows as $row) {
                    $row->delete();
                    $this->count -= 1;
                }
                DB::commit();
                return response()->json(['message' => __('alerts.destroyed_successfully'), 'title' => __('alerts.destroy')]);
            }
        } catch (\Exception $e) {
            return response()->json($e->getMessage(), 500);
        }
    } // End of Delete Row [ Single & Multi ]

    protected function is_exists($name, $row_id, $id = null)
    {
        return Room::where('name', $name)->where('row_id', $row_id)->where('id', '<>', $id)->count();
    } // Return The Count Of Roles They Have This [ $name ]
}
