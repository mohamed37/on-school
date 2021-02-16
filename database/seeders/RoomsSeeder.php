<?php

namespace Database\Seeders;

use App\Models\Room;
use App\Models\Row;
use Illuminate\Database\Seeder;

class RoomsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $rows  = Row::select('id')->inRandomOrder()->limit(6)->get();
        $rooms = ['A', 'B', 'C'];
        foreach ($rows as $row) {
            Room::create([
                'row_id'     => $row->id,
                'name'       => $rooms[rand(0, 2)],
            ]);
        }
    }
}
