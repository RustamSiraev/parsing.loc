<?php

namespace App\Http\Controllers\Applicant;

use App\Http\Controllers\AdminController;
use App\Http\Requests\FileRequest;
use App\Models\Diploma;
use App\Models\File;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Storage;

class DocumentController extends AdminController
{
    private $diploma;
    private $document;

    public function __construct(
        Diploma $diploma,
        File $document,
    )
    {
        parent::__construct();
        $this->diploma = $diploma;
        $this->document = $document;
    }

    public function edit(): View|Factory|Application
    {
        for ($i=1;$i<14;$i++) {
            $documents[] = auth()->user()->applicant->documents($i);
        }

        return view('applicant.document.index', compact('documents'));
    }

    public function store(FileRequest $request): JsonResponse
    {
        try {
            if($request->hasfile('file')) {

                $item = $request->file('file');
                $name= $item->getClientOriginalName();
                $file = $item->store('/public/uploads/applicant/'.auth()->user()->applicant_id);

                $oldFile = File::where('type', 1)->where('applicant_id', auth()->user()->applicant_id)->first();

                if ($oldFile && $request->type == 1) {
                    Storage::delete($oldFile->file);
                    $document = $oldFile;
                } else {
                    $document = new File();
                    $document->applicant_id = auth()->user()->applicant_id;
                    $document->type = $request->type;
                }
                $document->name = $name;
                $document->file = $file;
                $document->save();

                $response = [
                    'photo' => $document->type == 1,
                    'uploaded' => true,
                    'id' => $document->id,
                    'name' => $name,
                    'url' => Storage::disk('')->url($file),
                ];

                return response()->json($response, 200);
            }
        } catch (\Exception $e) {
            return response()->json('Unable to sent request.');
        }
    }

    public function destroy(Request $request): JsonResponse
    {
        $file = File::where('id', $request->id)->where('applicant_id', auth()->user()->applicant_id)->firstOrFail();
        Storage::delete($file->file);
        $file->delete();
        return response()->json('Deleted', 200);
    }
}
