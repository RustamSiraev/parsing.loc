<?php

namespace Database\Seeders;

use App\Models\StatementStatus;
use Illuminate\Database\Seeder;

class StatementStatusesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     * поступило, рассмотрено, принято, отклонено
     * @return void
     */
    public function run()
    {
        $statuses = [
            ['name' => 'На рассмотрении'],
            ['name' => 'Принято'],
            ['name' => 'Зачислен'],
            ['name' => 'Отклонено'],
            ['name' => 'Отказ в зачислении'],
        ];
        foreach ($statuses as $item) {
            $status = new StatementStatus();
            $status->name = $item['name'];
            $status->save();
        }
    }
}
