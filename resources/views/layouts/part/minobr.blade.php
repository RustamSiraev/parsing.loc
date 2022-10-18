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
                    <li class="nav-item dropdown @if(Request::is('minobr/statements*')){{ 'active' }}@endif">
                        <a class="nav-link " href="{{ route('minobr.statements') }}">
                            Все заявления
                        </a>
                    </li>

                    <li class="nav-item dropdown @if(Request::is('minobr/schools*')){{ 'active' }}@endif">
                        <a class="nav-link" href="{{ route('minobr.schools') }}">
                            Ведомственные школы
                        </a>
                    </li>

                    <li class="nav-item dropdown @if(Request::is('minobr/ranos*')){{ 'active' }}@endif">
                        <a class="nav-link" href="{{ route('minobr.ranos') }}">
                            РОО
                        </a>
                    </li>

                    <li class="nav-item dropdown @if(Request::is('*news*')){{ 'active' }}@endif">
                        <a class="nav-link" href="{{ route('minobr.news') }}">
                            Новости
                        </a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>
</div>
