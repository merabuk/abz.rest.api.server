<?php

namespace Database\Seeders;

use App\Models\Position;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PositionsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $positionsNames = ['Security', 'Designer', 'Content manager', 'Lawyer'];

        foreach ($positionsNames as $name)
        {
            $position = new Position();
            $position->name = $name;
            $position->save();
        }
    }
}
