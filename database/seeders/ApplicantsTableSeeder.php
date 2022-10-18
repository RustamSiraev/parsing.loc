<?php

namespace Database\Seeders;

use App\Models\Applicant;
use App\Models\House;
use App\Models\User;
use Illuminate\Database\Seeder;

class ApplicantsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        foreach (User::where('role_id', 4)->get() as $user) {
            $data = explode(' ', $user->name);
            $applicant = new Applicant();
            $applicant->f_name = $data[0];
            $applicant->m_name = $data[1];
            $applicant->l_name = $data[2];
            $applicant->status = 1;
            $applicant->doc_type = rand(1, 6);
            $applicant->doc_seria = rand(1000, 9999);
            $applicant->doc_number = rand(100000, 999999);
            $applicant->born_at = '01.02.2004';
            $applicant->doc_date = '01.02.2014';
            $applicant->citizenship = 1;
            $applicant->gender = rand(1, 2);
            $applicant->flat = rand(1, 99);
            $applicant->house_id = rand(1, House::all()->count());
            $applicant->save();

            $user->applicant_id	= $applicant->id;
            $user->save();
        }
    }
}
