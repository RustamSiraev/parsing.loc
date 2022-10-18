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
                    <li class="nav-item">
                        <a class="nav-link @if(Request::is('admin/users*')){{ 'active' }}@endif"
                           href="{{ route('users.index') }}">
                            Пользователи
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link @if(Request::is('admin/specialities*')){{ 'active' }}@endif"
                           href="{{ route('specialities.index') }}">
                            Специальности
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link @if(Request::is('admin/colleges*')){{ 'active' }}@endif"
                           href="{{ route('colleges.index') }}">
                            СПО
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link @if(Request::is('admin/applicants*')){{ 'active' }}@endif"
                           href="{{ route('applicants.index') }}">
                            Абитуриенты
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link @if(Request::is('admin/statements*')){{ 'active' }}@endif"
                           href="{{ route('statements.index') }}">
                            Заявления
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link @if(Request::is('admin/statistic*')){{ 'active' }}@endif"
                           href="{{ route('statistic.index') }}">
                            Статистика
                        </a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>
</div>
