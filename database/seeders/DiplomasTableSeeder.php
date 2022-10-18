<?php

namespace Database\Seeders;

use App\Models\Diploma;
use Illuminate\Database\Seeder;

class DiplomasTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $data = '[{"name":"Биология","score":"0","text":"0"},{"name":"Иностранный язык","score":"0","text":"английский"},{"name":"Второй иностранный язык","score":"0","text":"немецкий"},{"name":"География","score":"0","text":"0"},{"name":"Изобразительное искусство","score":"0","text":"0"},{"name":"Информатика","score":"0","text":"0"},{"name":"История","score":"0","text":"0"},{"name":"Литература","score":"0","text":"0"},{"name":"Математика","score":"0","text":"0"},{"name":"Музыка","score":"0","text":"0"},{"name":"Основы безопасности жизнедеятельности","score":"0","text":"0"},{"name":"Основы духовно-нравственной культуры народов России","score":"0","text":"0"},{"name":"Обществознание","score":"0","text":"0"},{"name":"Родная литература","score":"0","text":"русский"},{"name":"Родной язык","score":"0","text":"русский"},{"name":"Русский язык","score":"0","text":"0"},{"name":"Технология","score":"0","text":"0"},{"name":"Химия","score":"0","text":"0"},{"name":"Физика", "score":"0","text":"0"},{"name":"Физическая культура","score":"0","text":"0"}]';

        $diploma = new Diploma();
        $diploma->data = $data;
        $diploma->applicant_id = 0;
        $diploma->save();
    }
}
