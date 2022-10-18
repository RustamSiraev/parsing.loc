<?php

namespace App\Models;

use Haruncpi\LaravelUserActivity\Traits\Loggable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Diploma extends Model
{
    use HasFactory, Loggable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'data',
        'applicant_id',
        'doc_type',
        'doc_series',
        'doc_number',
        'doc_date',
        'doc_issued',
        'average',
    ];

    public function default()
    {
       return json_decode(self::findOrFail(1)->data, true);
    }

    public function applicant(): BelongsTo
    {
        return $this->belongsTo(Applicant::class)->withDefault();
    }

    public function type(): string
    {
        $array = [
            1 => 'Аттестат об основном общем образовании РФ выданный до 2014',
            2 => 'Аттестат об основном общем образовании РФ выданный с 2014',
            3 => 'Аттестат о полном общем образовании РФ выданный до 2014',
            4 => 'Аттестат о полном общем образовании РФ выданный с 2014',
            5 => 'Аттестат иностранного государства',
        ];

        return $array[$this->doc_type];
    }
}
