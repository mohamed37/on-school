<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run()
    {
        foreach (glob(public_path('uploads/images/*/*.*')) as $file)
            unlink($file);

        $this->call(LaratrustSeeder::class);
        $this->call(UserSeeder::class);
        $this->call(AbsenceSeeder::class);
        $this->call(SalarySeeder::class);
        $this->call(RowsSeeder::class);
        $this->call(RoomsSeeder::class);
        $this->call(SubjectsSeeder::class);
    } // end of run

} // end of seeder
