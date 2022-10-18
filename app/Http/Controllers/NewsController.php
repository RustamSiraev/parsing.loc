<?php

namespace App\Http\Controllers;

use App\Http\Controllers\AdminController;
use App\Http\Requests\NewsRequest;
use App\Http\Requests\PasswordRequest;
use App\Http\Requests\UserRequest;
use App\Models\Guno;
use App\Models\News;
use App\Models\Parents;
use App\Models\Rano;
use App\Models\Role;
use App\Models\School;
use App\Models\User;
use Auth;
use Hash;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Yajra\DataTables\DataTables;

class NewsController extends AdminController
{
    private $news;

    public function __construct(
        News $news,
    )
    {
        parent::__construct();
        $this->news = $news;
    }

    public function index(): View|Factory|Application
    {
        return view('news.index');
    }

    public function getNews(Request $request)
    {
        if ($request->ajax()) {
            $data = $this->news->all()->each(function ($item, $key) {
                $item->newsDate = date('d.m.Y', strtotime($item->created_at));
            });
            return Datatables::of($data)
                ->addIndexColumn()
                ->addColumn('action', function ($row) {
                    $actionBtn = '
                                <a class="text-frame" href="/minobr/news/' . $row->id . '/edit" title="Редактировать"><i class="bi bi-pencil"></i></a>
                                <a class="text-frame confirm-id" href="#" title="Удалить" data-bs-toggle="modal" data-bs-target="#dataConfirmModal" data-id="' . $row->id . '"><i class="bi bi-trash"></i></a>';
                    return $actionBtn;
                })
                ->rawColumns(['action'])
                ->make(true);
        }
    }

    public function create(): Factory|View|Application
    {
        return view('news.create');
    }

    public function edit(int $id): Factory|View|Application
    {
        $news = $this->news->findOrFail($id);

        return view('news.edit', compact('news'));
    }

    public function store(NewsRequest $request): RedirectResponse
    {
        $this->news->create([
            'title' => trim($request->title),
            'body' => trim($request->body),
        ]);

        return redirect(auth()->user()->home() . '/' . 'news')
            ->with('success', 'Новость успешно добавлена');
    }

    public function update(NewsRequest $request, News $news): RedirectResponse
    {
        $news->update([
            'title' => trim($request->title),
            'body' => trim($request->body),
        ]);

        return redirect(auth()->user()->home() . '/' . 'news')
            ->with('success', 'Новость успешно изменена');
    }

    public function deleteNews(Request $request): JsonResponse|RedirectResponse
    {
        $this->news->findOrFail($request->id)->delete();

        return response()->json(['success' => 'Successfully.']);
    }
}
