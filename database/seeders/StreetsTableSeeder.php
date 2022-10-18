<?php

namespace Database\Seeders;

use App\Models\Rano;
use App\Models\Street;
use Illuminate\Database\Seeder;

class StreetsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $streets = [
            ['title' => 'г Уфа, ул Менделеева', 'guid' => '6000c900-2cbe-420f-95bc-73c56096b93e'],
            ['title' => 'г Уфа, пр-кт Октября', 'guid' => '8dade0a4-ac2a-4884-a854-762ab0abbdca'],
            ['title' => 'г Уфа, ул Цюрупы', 'guid' => 'def833a0-226c-4891-8359-d9fd6c075f0e'],
        ];
        foreach ($streets as $item) {
            $street = new Street();
            $street->title = $item['title'];
            $street->guid = $item['guid'];
            $street->save();
        }
    }
}
