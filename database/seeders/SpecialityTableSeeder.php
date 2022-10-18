<?php

namespace Database\Seeders;

use App\Models\Qualification;
use App\Models\Speciality;
use App\Models\Testing;
use Illuminate\Database\Seeder;

class SpecialityTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $specialities = [
            [
                'code' => '00.00.01',
                'name' => 'Электромонтер по техническому обслуживанию электростанций и сетей',
                'qualifications' => [
                    'Электромонтер по обслуживанию подстанции',
                    'Электромонтер по обслуживанию электрооборудования электростанции',
                ],
                'testings' => [
                        'Математика',
                        'Физика',
                        'Русский язык',
                ],
            ],
            [
                'code' => '00.00.02',
                'name' => 'Слесарь по ремонту оборудования электростанций',
                'qualifications' => [
                    'Слесарь по ремонту оборудования тепловых сетей',
                    'Слесарь по ремонту парогазотурбинного оборудования',
                ],
                'testings' => [
                    'Математика',
                    'Физика',
                    'Русский язык',
                ],
            ],
            [
                'code' => '00.00.03',
                'name' => 'Мастер общестроительных работ',
                'qualifications' => [
                    'Арматурщик',
                    'Бетонщик',
                    'Каменщик',
                    'Монтажник по монтажу стальных и железобетонных конструкций',
                    'Печник',
                ],
                'testings' => [
                    'Математика',
                    'Физика',
                    'Русский язык',
                ],
            ],
            [
                'code' => '00.00.04',
                'name' => 'Мастер столярноплотничных и паркетных работ',
                'qualifications' => [
                    'Паркетчик',
                    'Плотник',
                    'Стекольщик',
                    'Столяр строительный',
                ],
                'testings' => [
                    'Математика',
                    'Физика',
                    'Русский язык',
                ],
            ],
            [
                'code' => '00.00.05',
                'name' => 'Автомеханик',
                'qualifications' => [
                    'Слесарь по ремонту автомобилей',
                    'Водитель автомобиля',
                ],
                'testings' => [
                    'Математика',
                    'Физика',
                    'Русский язык',
                ],
            ],
            [
                'code' => '00.00.06',
                'name' => 'Продавец, контролер-кассир',
                'qualifications' => [
                    'Кассир торгового зала',
                    'Контролер-кассир',
                    'Продавец непродовольственных товаров',
                    'Продавец продовольственных товаров',
                ],
                'testings' => [
                    'Математика',
                    'Физика',
                    'Русский язык',
                ],
            ],
            [
                'code' => '00.00.07',
                'name' => 'Мастер сельскохозяйственного производства',
                'qualifications' => [
                    'Слесарь по ремонту сельскохозяйственных машин и оборудования',
                    'Тракторист-машинист сельскохозяйственных машин',
                ],
                'testings' => [
                    'Математика',
                    'Физика',
                    'Русский язык',
                ],
            ],
            [
                'code' => '00.00.08',
                'name' => 'Аппаратчик-оператор экологических установок',
                'qualifications' => [
                    'Аппаратчик газоразделения',
                    'Аппаратчик нейтрализации',
                    'Аппаратчик обессоливания воды',
                ],
                'testings' => [
                    'Математика',
                    'Физика',
                    'Русский язык',
                ],
            ],
            [
                'code' => '00.00.09',
                'name' => 'Аппаратчик установок',
            ],
        ];
        foreach ($specialities as $item) {
            $speciality = new Speciality();
            $speciality->code = $item['code'];
            $speciality->name = $item['name'];
            $speciality->college_id = random_int(1,2);
            $speciality->education_level = random_int(1,2);
            $speciality->education_form = random_int(1,2);
            $speciality->budgetary = random_int(15,20);
            $speciality->commercial = random_int(15,20);
            $speciality->education_cost = random_int(15000,20000);
            $speciality->education_time = random_int(12,36);
            $speciality->save();
            foreach ($item['qualifications'] ?? [] as $elem) {
                $qualification = new Qualification();
                $qualification->speciality_id = $speciality->id;
                $qualification->name = $elem;
                $qualification->save();
            }
            foreach ($item['testings'] ?? [] as $test) {
                $testing = new Testing();
                $testing->speciality_id = $speciality->id;
                $testing->name = $test;
                $testing->grade = random_int(1,4);
                $testing->save();
            }
        }
    }
}
