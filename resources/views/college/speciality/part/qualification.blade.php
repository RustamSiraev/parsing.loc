<div class="page-title title-secondary">
    <h1>Квалификации</h1>
    <a class="qualification btn btn-primary btn-add-user" href="#" title="Добавить квалификацию" data-bs-toggle="modal"
       data-bs-target="#dataQualificationModal" data-text="Добавление квалификации"
       data-route="qualification-add"><i class="bi bi-plus-lg"></i>Добавить квалификацию</a>
</div>
<div class="">
    <input type="hidden" value="{{ request('speciality') }}" id="speciality-id">
    <table class="table table-secondary table-bordered college-qualification-datatable table-striped"
           style="width:100%">
        <thead>
        <tr>
            <th>Наименование квалификации</th>
            <th>Статус</th>
            <th>Операции</th>
        </tr>
        </thead>
        <tbody>
        </tbody>
    </table>
</div>
@include('college.speciality.part.confirm')
