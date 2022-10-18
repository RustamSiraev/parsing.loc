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
                    <li class="nav-item dropdown @if(Request::is('college/edit')){{ 'active' }}@endif">
                        <a class="nav-link " href="{{ route('college.edit') }}">
                            Данные учреждения
                        </a>
                    </li>
                    <li class="nav-item dropdown @if(Request::is('college/users*')){{ 'active' }}@endif">
                        <a class="nav-link" href="{{ route('college.users.index') }}">
                            Пользователи
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link @if(Request::is('college/applicants*')){{ 'active' }}@endif"
                           href="{{ route('college.applicants') }}">
                            Абитуриенты
                        </a>
                    </li>
                    <li class="nav-item dropdown @if(Request::is('college/specialities*')){{ 'active' }}@endif">
                        <a class="nav-link" href="{{ route('college.specialities') }}">
                            Специальности
                        </a>
                    </li>
                    <li class="nav-item dropdown @if(Request::is('college/statements*')){{ 'active' }}@endif">
                        <a class="nav-link" href="{{ route('college.statements') }}">
                            Заявления
                        </a>
                    </li>
                    <li class="nav-item dropdown @if(Request::is('college/results*')){{ 'active' }}@endif">
                        <a class="nav-link" href="{{ route('college.results') }}">
                            Результаты испытаний
                        </a>
                    </li>
                    <li class="nav-item dropdown @if(Request::is('college/statistic*')){{ 'active' }}@endif">
                        <a class="nav-link" href="{{ route('college.statistic.index') }}">
                            Статистика
                        </a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>
</div>
