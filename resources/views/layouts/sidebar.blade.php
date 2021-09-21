<!-- ========== Left Sidebar Start ========== -->
<div class="vertical-menu">

    <div data-simplebar class="h-100">

        <!--- Sidemenu -->
        <div id="sidebar-menu">
            <!-- Left Menu Start -->
            <ul class="metismenu list-unstyled" id="side-menu">
                <li class="menu-title">Основное меню</li>

                <li class="mm-active">
                    <a href="{{ route('branches') }}" class="waves-effect {{ Request::url() == route('branches') ? "active": "" }}">
                        <span><i class="mdi mdi-account-supervisor-outline"> Филиалы</i></span>
                    </a>
                </li>

                <li class="mm-active">
                    <a href="{{ route('groups') }}" class="waves-effect {{ Request::url() == route('groups') ? "active": "" }}">
                        <span><i class="mdi mdi-account-supervisor-outline"> Группы</i></span>
                    </a>
                </li>

                <li class="mm-active">
                    <a href="{{ route('children') }}" class="waves-effect {{ Request::url() == route('children') ? "active": "" }}">
                        <span><i class="mdi mdi-human-child"> Дети</i></span>
                    </a>
                </li>

                <li class="mm-active">
                    <a href="{{ route('staffs') }}" class="waves-effect {{ Request::url() == route('staffs') ? "active": "" }}">
                        <span><i class="mdi mdi-human-handsup"> Персонал</i></span>
                    </a>
                </li>

                <li class="mm-active">
                    <a href="{{ route('card.children') }}" class="waves-effect {{ Request::url() == route('card.children') ? "active": "" }}">
                        <span><i class="mdi mdi-clipboard-list-outline"> Табеля детей общие</i></span>
                    </a>
                </li>

                <li class="mm-active">
                    <a href="{{ route('card.staffs') }}" class="waves-effect {{ Request::url() == route('card.staffs') ? "active": "" }}">
                        <span><i class="mdi mdi-clipboard-list-outline"> Табеля персонала общие</i></span>
                    </a>
                </li>

                <li class="mm-active">
                    <a href="{{ route('journal.staffs') }}" class="waves-effect {{ Request::url() == route('journal.staffs') ? "active": "" }}">

                        <span><i class="mdi mdi-card-bulleted-outline"> Табель сотрудников</i></span>
                    </a>
                </li>

                <li class="mm-active">
                    <a href="{{ route('income') }}" class="waves-effect {{ Request::url() == route('income') ? "active": "" }}">

                        <span><i class="mdi mdi-cash-multiple"> Доходы и расходы</i></span>
                    </a>
                </li>

            </ul>

            <ul class="metismenu list-unstyled" id="side-menu">
                <li class="menu-title">Меню преподавателя</li>

                <li class="mm-active">
                    <a href="{{ route('journal.children') }}" class="waves-effect {{ Request::url() == route('journal.children') ? "active": "" }}">

                        <span><i class="mdi mdi-card-bulleted-outline"> Табель детей</i></span>
                    </a>
                </li>
            </ul>
        </div>
        <!-- Sidebar -->
    </div>
</div>
<!-- Left Sidebar End -->
