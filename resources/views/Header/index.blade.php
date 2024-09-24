<div id="nav-bar">
    <input type="checkbox" id="nav-toggle" checked>
    <div id="nav-header">
        <a id="nav-title" target="_blank">
            <img src="{{ asset('images/logo.png') }}" alt="Logo MyCorte" width="120px">
        </a>
        <label for="nav-toggle"><span id="nav-toggle-burger"></span></label>
        <hr/>
    </div>
    <div id="nav-content">
        <div class="nav-button {{ Request::routeIs('home') ? 'active-module' : '' }}">
            <i class="fas fa-home" data-url="{{ route('home') }}"></i>
            <span>
                <a href="{{ route('home') }}">Início</a>
            </span>
        </div>
      {{--  <div class="nav-button {{ Request::routeIs('dashboard') ? 'active-module' : '' }}">
            <i class="fas fa-solid fa-chart-pie" data-url="{{ route('dashboard', ['tokenCompany' => $tokenCompany]) }}"></i>
            <span><a href="{{ route('dashboard', ['tokenCompany' => $tokenCompany]) }}">Dashboard</a></span>
        </div>

        <div class="nav-button">
            <i class="fas fa-solid fa-users-viewfinder" data-url="#"></i>
            <span>
                <a href="#">Painel de Serviços</a>
            </span>
        </div>

        <div class="nav-button {{ Request::routeIs('promotioncollaborator') ? 'active-module' : '' }}">
            <i class="fas fa-fire" data-url="{{ route('promotioncollaborator', ['tokenCompany' => $tokenCompany]) }}"></i>
            <span>
                <a href="{{ route('promotioncollaborator', ['tokenCompany' => $tokenCompany]) }}">
                    Promoções
                </a>
            </span>
        </div>

        <div class="nav-button {{ Request::routeIs('config.*') ? 'active-module' : '' }}">
            <i class="fas fa-solid fa-gear" data-url="{{ route('config.index', ['tokenCompany' => $tokenCompany]) }}"></i>
            <span>
                <a href="{{ route('config.index', ['tokenCompany' => $tokenCompany]) }}">
                    Configurações
                </a>
            </span>
        </div>

        <hr/>

        @if($collaboratorRole === 'ADMIN')
            <div class="nav-button {{ Request::routeIs('servicescollaborator') ? 'active-module' : '' }}">
                <i class="fas fa-solid fa-scissors" data-url="{{ route('servicescollaborator', ['tokenCompany' => $tokenCompany]) }}"></i>
                <span><a href="{{ route('servicescollaborator', ['tokenCompany' => $tokenCompany]) }}">Serviços</a></span>
            </div>
            <div class="nav-button">
                <i class="fas fa-solid fa-print" data-url="#"></i>
                <span>Relatórios</span>
            </div>
            <div class="nav-button">
                <i class="fas fa-solid fa-users-gear" data-url="#"></i>
                <span>Gerenciar</span>
            </div>
        @elseif($collaboratorRole === 'COLLABORATOR')
            <div class="nav-button {{ Request::routeIs('report.*') ? 'active-module' : '' }}">
                <i class="fas fa-solid fa-print" data-url="{{ route('report.index', ['tokenCompany' => $tokenCompany]) }}"></i>
                <span>
                    <a href="{{ route('report.index', ['tokenCompany' => $tokenCompany]) }}">
                        Relatórios
                    </a>
                </span>
            </div>

            <div class="nav-button {{ Request::routeIs('servicescollaborator') ? 'active-module' : '' }}">
                <i class="fas fa-solid fa-scissors" data-url="{{ route('servicescollaborator', ['tokenCompany' => $tokenCompany]) }}"></i>
                <span><a href="{{ route('servicescollaborator', ['tokenCompany' => $tokenCompany]) }}">Serviços</a></span>
            </div>
        @endif
        <hr/> --}}
        <div id="nav-content-highlight"></div>
    </div>
    <input id="nav-footer-toggle" type="checkbox"/>
    <div id="nav-footer">
        <div id="nav-footer-heading">
            <div id="nav-footer-avatar">
                <img src="#" alt="Logo Colaborador"/>
            </div>
            <div id="nav-footer-titlebox">
                <a id="nav-footer-title" href="https://codepen.io/uahnbu/pens/public" target="_blank"></a>
                <span id="nav-footer-subtitle"></span>
            </div>
            <label for="nav-footer-toggle"><i class="fas fa-caret-up"></i></label>
        </div>
        <div id="nav-footer-content">
            <div class="nav-footer-button">
                <i class="fas fa-user" data-url="#"></i>
                <span><a href="#">Perfil</a></span>
            </div>
            <div class="nav-footer-button">
                <i class="fas fa-cog" data-url="#"></i>
                <span><a href="#">Configurações</a></span>
            </div>
            <div class="nav-footer-button">
                <i class="fas fa-question-circle" data-url="#"></i>
                <span><a href="#">Ajuda</a></span>
            </div>
            <div class="nav-footer-button" id="logout-button">
                <i class="fas fa-sign-out-alt" data-url="#"></i>
                <span><a href="#">Sair</a></span>
            </div>
        </div>
        <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
            @csrf
        </form>
    </div>
</div>

<script>
    document.querySelectorAll('.nav-button i').forEach(icon => {
        icon.addEventListener('click', function() {
            window.location.href = this.getAttribute('data-url');
        });
    });

    document.getElementById('logout-button').addEventListener('click', function (event) {
        event.preventDefault();
        Swal.fire({
            title: 'Você realmente deseja sair?',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Sim, sair',
            cancelButtonText: 'Cancelar'
        }).then((result) => {
            if (result.isConfirmed) {
                document.getElementById('logout-form').submit();
            }
        });
    });
</script>
