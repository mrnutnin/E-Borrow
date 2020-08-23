<nav class="navbar-default navbar-static-side" role="navigation">
    <div class="sidebar-collapse">
        <ul class="nav metismenu" id="side-menu">
            <li class="nav-header">
                <div class="dropdown profile-element">
                    <span>
                        <img alt="image" style=" width: 30%; height: auto;" class="img-circle" src="/img/avatar.png" />
                    </span>
                    <span data-toggle="dropdown" class="dropdown-toggle" href="#">
                        <span class="clear">
                            <span class="block m-t-xs">
                                <strong class="font-bold">{{ Auth::user()->name }}</strong>
                            </span>
                        </span>
                    </span>
                    <ul class="dropdown-menu animated fadeInRight m-t-xs">
                        <li>
                            <a href="{{ route('logout') }}"
                            onclick="event.preventDefault();
                            document.getElementById('logout-form').submit();">Logout
                            </a>
                        </li>
                    </ul>
                </div>
                <div class="logo-element">
                    BR+
                </div>
            </li>
            <li class="">
                <a href="{{ url('/home') }}"><i class="fa fa-th-large"></i> <span class="nav-label">Main Page</span> </a>
            </li>
            <li class="">
                <a href="{{ url('/manage-items') }}"><i class="fa fa-th-large"></i> <span class="nav-label">จัดการครุภัณฑ์</span></a>
            </li>
            <li class="">
                <a href="{{ url('/minor') }}"><i class="fa fa-th-large"></i> <span class="nav-label">Minor view</span> </a>
            </li>
        </ul>

    </div>
</nav>
