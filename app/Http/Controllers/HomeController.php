<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Parsing\ParsingController;
use App\Models\Parsing;
use Exception;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
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

    public function test(): Factory|View|Application
    {
        return view('test');
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
                'user_id' => auth()->user()->id,
            ]);

            return response()->json($parsing->id);
        }
        return response()->json(['error' => __('This webpage is not available.')]);
    }

    public function parsing(Request $request)
    {
        $parsing = $this->parsing->findOrFail($request->all()['id']);

        if ($parsing->isMy())
            return $this->runParser($parsing);

        return response()->json(['error' => __("The government won't let us show you what's behind these doors")]);
    }

    /**
     *
     * @param Request $request
     * @return void
     * @throws Exception
     */
    public function getParsings(Request $request)
    {
        if ($request->ajax())
        {
            $data = $this->parsing->getAll();

            if ($request->all()['id']) {
                $data = $this->parsing->getAll($request->all()['id']);
            }

            $data->each(function ($item)
            {
                $item->date = date('d.m.Y H:i:s', strtotime($item->created_at));
                $item->time = sprintf('%02d:%02d:%02d', ($item->time() / 3600), ($item->time() / 60 % 60), $item->time() % 60);
                $item->email = $item->user->email;
            });
            return Datatables::of($data)
                ->addIndexColumn()
                ->addColumn('action', function ($row)
                {
                    return '<a href="/parsing/' . $row->id . '/show" target="_blank"><i class="bi bi-eye"></i></a>
                            <a href="#" data-id="' . $row->id . '" class="button-trash"><i class="bi bi-trash" data-id="' . $row->id . '"></i></a>';
                })
                ->rawColumns(['action'])
                ->make(true);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param Parsing $parsing
     * @return Factory|View|Application
     */
    public function show(Parsing $parsing): Factory|View|Application
    {
        if ($parsing->isMy())
            return view('parsing.show', compact('parsing'));

        return abort(404);
    }

    /**
     *
     * @param Request $request
     * @return void
     * @throws Exception
     */
    public function getResults(Request $request)
    {
        if ($request->ajax())
        {
            $parsing = $this->parsing->findOrFail($request->all()['id']);

            $data = $parsing->results();
            return Datatables::of($data)
                ->addIndexColumn()
                ->addColumn('url', function ($row)
                {
                    return '<a href="' . $row->parent . '" target="_blank">url</a>';
                })
                ->addColumn('link', function ($row)
                {
                    return '<a href="' . $row->href . '" target="_blank">' . $row->href . '</a>';
                })
                ->rawColumns(['action', 'url', 'link'])
                ->make(true);
        }
    }

    /**
     *
     * @param Request $request
     * @return bool|JsonResponse|null
     */
    public function delete(Request $request)
    {
        $parsing = $this->parsing->findOrFail($request->all()['id']);

        if ($parsing->isMy())
            return $parsing->delete();

        return response()->json(['error' => __("The government won't let us show you what's behind these doors")]);
    }

    /**
     *
     * @param Request $request
     * @return bool
     */
    public function kill(Request $request)
    {
        $parsing = $this->parsing->findOrFail($request->all()['id']);

        return $parsing->update(['end' => true]);
    }
}
