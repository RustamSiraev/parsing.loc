<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\AdminController;
use App\Http\Requests\AddressRequest;
use App\Http\Requests\UserRequest;
use App\Models\House;
use App\Models\Street;
use Hash;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Yajra\DataTables\DataTables;

class AddressController extends AdminController
{
    private $street;
    private $house;

    public function __construct(
        House $house,
        Street $street,
    )
    {
        parent::__construct();
        $this->house = $house;
        $this->street = $street;
    }

    public function index(): View|Factory|Application
    {
        return view('admin.address.index');
    }

    public function getAddress(Request $request)
    {
        if ($request->ajax()) {
            $data = $this->street->all()->each(function ($item, $key) {
                $item->houses = $item->getHouses();
            });
            return Datatables::of($data)
                ->addIndexColumn()
                ->addColumn('action', function ($row) {
                    $actionBtn = '<p class="text-frame">' . $row->houses . '</p>';
                    return $actionBtn;
                })
                ->rawColumns(['action'])
                ->make(true);
        }
    }

    public function create(): Factory|View|Application
    {
        return view('admin.address.create');
    }

    public function store(AddressRequest $request): RedirectResponse
    {
        $request->request->add([
            'guid' => $request->street_id,
            'title' => $request->city_street
        ]);
        $this->street->make($request->all());

        return redirect()
            ->route('address.index')
            ->with('success', 'Адрес успешно добавлен');
    }
}
