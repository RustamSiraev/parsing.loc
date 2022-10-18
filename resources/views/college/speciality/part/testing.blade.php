<div class="page-title title-secondary">
    <h1>Испытания</h1>
    <a class="testing btn btn-primary btn-add-user" href="#" title="Добавить испытание" data-bs-toggle="modal"
       data-bs-target="#dataTestingModal" data-text="Добавление испытания"
       data-route="testing-add"><i class="bi bi-plus-lg"></i>Добавить испытание</a>
</div>
<div class="">
    <input type="hidden" value="{{ request('speciality') }}" id="speciality-id">
    <table class="table table-secondary table-bordered college-testing-datatable table-striped"
           style="width:100%">
        <thead>
        <tr>
            <th>Наименование</th>
            <th>Результат</th>
            <th>Статус</th>
            <th>Управление</th>
        </tr>
        </thead>
        <tbody>
        </tbody>
    </table>
</div>
