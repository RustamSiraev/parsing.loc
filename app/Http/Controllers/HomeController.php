<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Parsing\ParsingController;
use App\Models\Parsing;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Storage;
use Yajra\DataTables\DataTables;

set_time_limit(0);

class HomeController extends ParsingController
{
    private Parsing $parsing;

    public function __construct(
        Parsing $parsing,
    )
    {
        $this->parsing = $parsing;
    }

    public function index(): Factory|View|Application
    {
        return view('home');
    }

    public function start(Request $request): JsonResponse
    {
        $site = $this->getData($request->all()['site']);

        if ($site['data'] && empty($site['error']))
        {
            $parsing = $this->parsing->create([
                'href' => $site['url'],
                'start' => now(),
            ]);

            return response()->json($parsing->id);
        }
    }

    public function parsing(Request $request)
    {
        $parsing = $this->parsing->findOrFail($request->all()['id']);
        return $this->runParser($parsing);
    }

    public function getParsings(Request $request)
    {
        if ($request->ajax())
        {
            $data = $this->parsing->getAll()->each(function ($item)
            {
                $item->date = date('d.m.Y H:i:s', strtotime($item->created_at));
                $item->time = sprintf('%02d:%02d:%02d', ($item->time() / 3600), ($item->time() / 60 % 60), $item->time() % 60);
            });
            return Datatables::of($data)
                ->addIndexColumn()
                ->addColumn('action', function ($row)
                {
                    return '<a href="/report/index.php?id=' . $row->id . '" target="_blank"><i class="bi bi-eye"></i></a>
                            <a href="#" data-id="' . $row->id . '" class="button-trash"><i class="bi bi-trash" data-id="' . $row->id . '"></i></a>';
                })
                ->rawColumns(['action'])
                ->make(true);
        }
    }

    public function getResults(Request $request)
    {
        if ($request->ajax())
        {
            $parsing = $this->parsing->findOrFail($request->all()['id']);

            $data = $parsing->results() ?? [];
            return Datatables::of($data)
                ->addIndexColumn()
                ->make(true);
        }
    }


    public function download(string $input)
    {
        $fileName = str_replace('.pdf', '', $input);

        if (in_array($fileName, [1, 2, 3]))
        {
            $file = Storage::disk('public')->get('/instruction/' . $input);

            switch (auth()->user()->role_id)
            {
                case 1:
                    return (new Response($file, 200))
                        ->header('Content-Type', 'application/pdf');
                case 2:
                case 3:
                    if ($fileName > 1)
                    {
                        return (new Response($file, 200))
                            ->header('Content-Type', 'application/pdf');
                    }
                    else
                    {
                        return redirect(auth()->user()->home());
                    }
                case 4:
                    if ($fileName == 3)
                    {
                        return (new Response($file, 200))
                            ->header('Content-Type', 'application/pdf');
                    }
                    else
                    {
                        return redirect(auth()->user()->home());
                    }
            }
        }
        else
        {
            return redirect(auth()->user()->home());
        }
    }
}
