<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\College;
use App\Models\Parents;
use App\Models\Speciality;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use MoveMoveIo\DaData\Facades\DaDataAddress;
use MoveMoveIo\DaData\Enums\Language;

class Select2SearchController extends Controller
{
    private $speciality;
    private $college;

    public function __construct(
        Speciality $speciality,
        College    $college,
    )
    {
        $this->speciality = $speciality;
        $this->college = $college;
    }

    public function index()
    {
        return view('home');
    }

    public function parentSearch(Request $request): JsonResponse
    {
        $parents = Parents::all();

        if ($request->has('q')) {
            $search = $request->q;
            $parents = Parents::select('id', 'f_name', 'l_name', 'm_name')
                ->orWhere('f_name', 'LIKE', "%$search%")
                ->orWhere('l_name', 'LIKE', "%$search%")
                ->orWhere('m_name', 'LIKE', "%$search%")
                ->get();
        }
        return response()->json($parents);
    }

    public function collegeSearch(Request $request): JsonResponse
    {
        $colleges = (new \App\Models\College)->getAllActive();

        if ($request->has('q')) {
            $search = $request->q;
            $colleges = College::select('id', 'title', 'full_title')
                ->orWhere('title', 'LIKE', "%$search%")
                ->orWhere('full_title', 'LIKE', "%$search%")
                ->get();
        }
        return response()->json($colleges);
    }

    public function addressSearch(Request $request): JsonResponse
    {
        if ($request->has('q')) {
            $address = DaDataAddress::prompt(
                $request->q,
                20,
                Language::RU,
                [],
                [],
                [],
                ["value" => "country"],
                ["value" => "street"]
            );

            if (count($address['suggestions']) < 1) {
                $address = [
                    'error' =>  'no_result',
                    'suggestions' => [
                        [
                            'data' => [
                                'fias_id' => rand(1000, 9999).'-'.rand(1000, 9999).'-'.rand(1000, 9999).'-'.rand(1000, 9999),
                            ],
                            'unrestricted_value' => $request->q,
                            'value' => $request->q,
                        ],
                    ],
                ];
            }
        }
        return response()->json($address);
    }

    public function houseSearch(Request $request): JsonResponse
    {
        $arr = DaDataAddress::id($request->id, 1, Language::RU)['suggestions'];
        $address = [];

        if (isset($arr[0])) {
            $data = $arr[0]['data'];

            if ($request->has('q')) {
                $address = DaDataAddress::prompt(
                    $request->q ?? '',
                    20,
                    Language::RU,
                    [
                        "region" => $data['region'],
                        "area" => $data['area'],
                        "city" => $data['city'],
                        "settlement" => $data['settlement'],
                        "street" => $data['street']
                    ],
                    [],
                    [],
                    ["value" => "house"],
                    ["value" => "house"]
                );

                if (count($address['suggestions']) < 1) {
                    $address = [
                        'suggestions' => [
                            [
                                'data' => [
                                    'street_fias_id' => $data['street'],
                                    'house' => $request->q,
                                ],
                                'unrestricted_value' => $request->q,
                                'value' => $request->q,
                            ],
                        ],
                    ];
                }
            }
        } else {
            $address = [
                'suggestions' => [
                    [
                        'data' => [
                            'street_fias_id' => $request->id,
                            'house' => $request->q,
                        ],
                        'unrestricted_value' => $request->q,
                        'value' => $request->q,
                    ],
                ],
            ];
        }

        return response()->json($address);
    }


    public function jurAddressSearch(Request $request): JsonResponse
    {
        if ($request->has('q')) {
            $address = DaDataAddress::prompt(
                $request->q,
                20,
                Language::RU,
                [],
                [],
                [],
                ["value" => "country"],
                []
            );
        }
        return response()->json($address);
    }

    public function specialitySearch(Request $request): JsonResponse
    {
        $ids = $this->college->findOrFail(auth()->user()->college_id)->results()->pluck('speciality_id')->toArray();

        $specialities = $this->speciality->where('college_id', auth()->user()->college_id)
            ->whereNotIn('id', $ids)
            ->where('status', 1)
            ->get();

        if ($request->has('q')) {
            $search = $request->q;
            $specialities = $this->speciality->where('college_id', auth()->user()->college_id)
                ->whereNotIn('id', $ids)
                ->where('status', 1)
                ->orWhere('name', 'LIKE', "%$search%")
                ->get();
        }
        return response()->json($specialities);
    }
}
