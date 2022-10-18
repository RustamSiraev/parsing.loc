<?php

namespace Database\Seeders;

use App\Models\Applicant;
use App\Models\College;
use App\Models\Statement;
use Illuminate\Database\Seeder;

class StatementsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        foreach (Applicant::all() as $item) {
            $colleges = College::all();
            foreach ($colleges as $college) {
                foreach ($college->specialities as $speciality) {
                    $statement = new Statement();
                    $statement->user_id = $item->getUser()->id;
                    $statement->applicant_id = $item->id;
                    $statement->speciality_id = $speciality->id;
                    $statement->save();
                }
            }
        }
    }
}
