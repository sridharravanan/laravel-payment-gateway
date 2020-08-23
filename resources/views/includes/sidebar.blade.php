<!-- Left Panel -->
<aside id="left-panel" class="left-panel">
    <nav class="navbar navbar-expand-sm navbar-default">

        <div class="navbar-header">
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#main-menu" aria-controls="main-menu" aria-expanded="false" aria-label="Toggle navigation">
                <i class="fa fa-bars"></i>
            </button>
            <a class="navbar-brand" href="./"><img src="{{asset('image/logo.jpg')}}" alt="Logo"></a>
            <a class="navbar-brand hidden" href="./"><img src="{{asset('image/logo.jpg')}}" alt="Logo"></a>
        </div>

        <div id="main-menu" class="main-menu collapse navbar-collapse">
            <ul class="nav navbar-nav">
                <li>
                    <a href="/dashboard"> <i class="menu-icon fa fa-dashboard"></i>Dashboard </a>
                </li>
                @role('tutor')
                <li>
                    <a href="/post"> <i class="menu-icon fa fa-book"></i>Post </a>
                </li>
                @endrole
                @role('admin')
                <li>
                    <a href="/tutor"> <i class="menu-icon fa fa-group"></i>Tutor </a>
                </li>
                @endrole
            </ul>
        </div>
    </nav>
</aside>
<!-- Left Panel -->
