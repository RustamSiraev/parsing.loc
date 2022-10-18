<?php

namespace Database\Seeders;

use App\Models\House;
use App\Models\SchoolAddress;
use App\Models\Street;
use Illuminate\Database\Seeder;

class HousesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $streets = Street::all();
        foreach ($streets as $item) {
            for ($i = 1; $i < 100; $i++) {
                $letters = [
                    ['tittle' => '', 'trans' => ''],
                    ['tittle' => 'А', 'trans' => 'a'],
                    ['tittle' => 'Б', 'trans' => 'b'],
                ];
                foreach ($letters as $letter) {
                    $house = new House();
                    $house->house_num = $i.$letter['tittle'];
                    $house->street_id = $item->id;
                    $house->guid = $item->guid.'-'.$i.$letter['tittle'];
                    $house->save();
                }
            }
        }
    }
}
