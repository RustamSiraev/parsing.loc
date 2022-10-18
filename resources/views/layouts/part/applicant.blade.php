<div class="card ">
    <nav class="navbar navbar-expand-md navbar-light bg-white shadow-sm">
        <div class="container home-menu">

            <button class="navbar-toggler" type="button" data-bs-toggle="collapse"
                    data-bs-target="#menuSupportedContent" aria-controls="menuSupportedContent"
                    aria-expanded="false">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="menuSupportedContent">
                <ul class="navbar-nav me-auto">
                    <li class="nav-item dropdown @if(Request::is('applicant/info*')){{ 'active' }}@endif">
                        <a class="nav-link " href="{{ route('applicant.edit') }}">
                            Мои данные
                        </a>
                    </li>
                    <li class="nav-item dropdown @if(Request::is('applicant/diploma*')){{ 'active' }}@endif">
                        <a class="nav-link " href="{{ route('diploma.edit') }}">
                            Аттестат
                        </a>
                    </li>
                    <li class="nav-item dropdown @if(Request::is('applicant/documents*')){{ 'active' }}@endif">
                        <a class="nav-link " href="{{ route('document.edit') }}">
                            Документы
                        </a>
                    </li>
                    <li class="nav-item dropdown @if(Request::is('applicant/statement*')){{ 'active' }}@endif">
                        <a class="nav-link " href="{{ route('applicant.statement.index') }}">
                            Заявления
                        </a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>
</div>
