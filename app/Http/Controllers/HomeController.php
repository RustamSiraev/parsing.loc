<?php

namespace App\Http\Controllers;

use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Storage;

class HomeController extends Controller
{
    public function index(): Factory|View|Application
    {
        return view('home');
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
