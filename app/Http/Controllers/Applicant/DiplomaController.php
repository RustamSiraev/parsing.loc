<?php

namespace App\Http\Controllers\Applicant;

use App\Http\Controllers\AdminController;
use App\Models\Applicant;
use App\Models\Diploma;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class DiplomaController extends AdminController
{
    private $diploma;

    public function __construct(
        Diploma $diploma,
    )
    {
        parent::__construct();
        $this->diploma = $diploma;
    }

    public function edit(): View|Factory|Application
    {
        $diploma = Applicant::findOrFail(auth()->user()->applicant_id)->getDiploma();
        $grades = $diploma ? json_decode($diploma->data, true) : $this->diploma->default();

        return view('applicant.diploma.index', compact('grades', 'diploma'));
    }

    public function update(Request $request): RedirectResponse
    {
        foreach ($request->grade_name as $key => $item) {
            $data[$key]['name'] = $item;
            $data[$key]['score'] = $request->grade_score[$key];
            $data[$key]['text'] = $request->grade_text[$key];
        }

        $diploma = Diploma::firstOrNew(
            ['applicant_id' => auth()->user()->applicant_id],
        );
        $diploma->applicant_id = auth()->user()->applicant_id;
        $diploma->doc_type = $request->doc_type;
        $diploma->doc_series = $request->doc_series;
        $diploma->doc_number = $request->doc_number;
        $diploma->doc_issued = $request->doc_issued;
        $diploma->doc_date = $request->doc_date;
        $diploma->average = $request->average;
        $diploma->data = json_encode(array_values($data));
        $diploma->save();

        return redirect()
            ->route('diploma.edit')
            ->with('success', 'Аттестат успешно сохранен');
    }

    public function addSubject(Request $request): JsonResponse
    {
        $index = $request->index + 1;
        if ($request->text) {
            $text = '<h5 class="grade-text"><input type="text" class="additional-text"
                                    data-index="' . $index . '" value="' . $request->text . '"></h5>';
        } else {
            $text = '';
        }
        $data = '<div class="row subject_item">
                    <div class="col-md-10 subject_name">
                        <div class="subject_grade grade-name">
                            <h5>' . $request->name . '</h5>
                                ' . $text . '
                        </div>
                    </div>
                    <div class="col-md-1">
                        <div class="form-group">
                            <input type="hidden" name="grade_name[' . $index . ']" value="' . $request->name . '">
                            <input type="hidden" name="grade_text[' . $index . ']" value="' . $request->text . '"
                                   id="text-' . $index . '">
                            <input class="form-control grade-score" type="number"
                                   name="grade_score[' . $index . ']" value="0"
                                   id="grade-score[' . $index . ']" min="0" max="5">
                        </div>
                    </div>
                    <div class="col-md-1" style="position:relative;padding-bottom:0;">
                        <span class="text-frame subject-delete"
                              title="Вы можете удалить предмет из списка, если он отсутствует в Вашем аттестате">
                              <i class="bi bi-trash-fill"></i></span>
                    </div>
                </div>';

        return response()->json($data);
    }
}
