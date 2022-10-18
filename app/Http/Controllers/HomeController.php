<?php

namespace App\Http\Controllers;

use App\Models\News;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Storage;

class HomeController extends Controller
{
    private $news;

    public function __construct(
        News $news,
    )
    {
        $this->news = $news;
    }
    public function index(): Factory|View|Application
    {
        $news = $this->news->getHome();

        return view('home', compact('news'));
    }

    public function news(): Factory|View|Application
    {
        $news = $this->news->getAll();

        return view('news', compact('news'));
    }

    public function show(int $id): Factory|View|Application
    {
        $item = News::findOrFail($id);

        return view('news', compact('item'));
    }

    public function download($input)
    {
        $fileName = str_replace('.pdf', '', $input);

        if (in_array($fileName, [1,2,3])) {

            $file = Storage::disk('public')->get('/instruction/' . $input);

            switch (auth()->user()->role_id) {
                case 1:
                    return (new Response($file, 200))
                        ->header('Content-Type', 'application/pdf');
                case 2:
                case 3:
                    if ($fileName > 1) {
                        return (new Response($file, 200))
                            ->header('Content-Type', 'application/pdf');
                    } else {
                        return redirect(auth()->user()->home());
                    }
                case 4:
                    if ($fileName == 3) {
                        return (new Response($file, 200))
                            ->header('Content-Type', 'application/pdf');
                    }else {
                        return redirect(auth()->user()->home());
                    }
            }
        } else {
            return redirect(auth()->user()->home());
        }
    }
}
