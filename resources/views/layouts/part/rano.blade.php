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
                    <li class="nav-item dropdown @if(Request::is('rano/statements*')){{ 'active' }}@endif">
                        <a class="nav-link " href="{{ route('rano.statements') }}">
                            Все заявления
                        </a>
                    </li>

                    <li class="nav-item dropdown @if(Request::is('rano/schools*')){{ 'active' }}@endif">
                        <a class="nav-link" href="{{ route('rano.schools') }}">
                            Ведомственные школы
                        </a>
                    </li>

                    <li class="nav-item dropdown @if(Request::is('rano/edit')){{ 'active' }}@endif">
                        <a class="nav-link" href="{{ route('rano.schools') }}">
                            Отчёты
                        </a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>
</div>
