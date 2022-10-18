<?php

namespace Database\Seeders;

use App\Models\College;
use Illuminate\Database\Seeder;

class CollegesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $schools = [
            [
                'title' => 'ГБПОУ НПК',
                'full_title' => 'Государственное бюджетное профессиональное общеобразовательное учреждение Назрановский политехнический колледж',
                'kpp' => '060601001',
                'director_id' => 3,
                'jur_address' => '386101, Республика Ингушетия, г. Назрань, тер. Центральный округ, пр-кт И.Базоркина, д.68',
                'phone' => '+7 (8732) 22-62-24',
                'inn' => '0602000921',
                'ogrn' => '1030600280105',
            ],
            [
                'title' => 'ГБПОУ НАТ',
                'full_title' => 'Государственное бюджетное профессиональное общеобразовательное учреждение Назрановский аграрный техникум',
                'kpp' => '060601001',
                'director_id' => 4,
                'jur_address' => '386132, Республика Ингушетия, г. Назрань, тер. Гамурзиевский округ, ул. Магистральная, д. 35',
                'phone' => '+7 (8732) 22-82-07',
                'inn' => '0606005374',
                'ogrn' => '1020600986273',
            ],
            [
                'title' => 'ГБПОУ ИПК им. Ю.И. АРАПИЕВА',
                'full_title' => 'Государственное бюджетное профессиональное общеобразовательное учреждение Ингушский политехнический колледж имени Ю. И. Арапиева',
                'kpp' => '060801001',
                'director_id' => 5,
                'jur_address' => '386140, Республика Ингушетия, г. Назрань, тер. Насыр-Кортский округ, ул. Южная, д. 5',
                'phone' => '+7 (8732) 22-55-13',
                'inn' => '0602000914',
                'ogrn' => '1030600280094',
            ],
            [
                'title' => 'ГБПОУ Колледж сервиса и быта',
                'full_title' => 'Государственное бюджетное профессиональное образовательное учреждение Колледж сервиса и быта',
                'kpp' => '060801001',
                'director_id' => 6,
                'jur_address' => '386101, Республика Ингушетия, г. Назрань, тер. Центральный округ, ул. Д.Картоева, д. 98',
                'phone' => '+7 (8732) 22-82-07',
                'inn' => '0608016607',
                'ogrn' => '1100608002076',
            ]
        ];
        foreach ($schools as $item) {
            $school = new College();
            $school->title = $item['title'];
            $school->inn = $item['inn'];
            $school->full_title = $item['full_title'];
            $school->kpp = $item['kpp'] ?? null;
            $school->ogrn = '4444444444444';
            $school->director_id = $item['director_id'] ?? null;
            $school->jur_address = $item['jur_address'] ?? null;
            $school->post_address = $item['jur_address'] ?? null;
            $school->phone = $item['phone'] ?? null;
            $school->email = 'email@email.ru';
            $school->bank_name = 'OOO Bank';
            $school->bank_bik = '777777777';
            $school->okpo = '8888888888';
            $school->c_acc = '22222222222222222222';
            $school->save();
        }
    }
}
