<!-- Left side column. contains the logo and sidebar -->
<aside class="main-sidebar">

    <!-- sidebar: style can be found in sidebar.less -->
    <section class="sidebar">

        <!-- Sidebar user panel (optional) -->
        <div class="user-panel">
            <div class="pull-left image">
                <img src="/dist/img/user2-160x160.jpg" class="img-circle" alt="User Image">
            </div>
            <div class="pull-left info">
                <p>{{$name}}</p>
                <!-- Status -->
                <a href="#"><i class="fa fa-circle text-success"></i> Online</a>
            </div>
        </div>

        <!-- search form (Optional) -->
        <form action="/search" method="post" class="sidebar-form">
            <input type="hidden" name="_token" value="{{ csrf_token() }}">
            <div class="input-group">
                @if(session('searchName'))
                    <input type="text" name="name" class="form-control" value="{{session('searchName')}}"
                           placeholder="Search...">
                @else
                    <input type="text" name="name" class="form-control" placeholder="Search...">
                @endif
                <span class="input-group-btn">
              <button type="submit" name="search" id="search-btn" class="btn btn-flat"><i class="fa fa-search"></i>
              </button>
            </span>
            </div>
        </form>
        <!-- /.search form -->

        <!-- Sidebar Menu -->
        <ul class="sidebar-menu" data-widget="tree">
            <li class="header">HEADER</li>
            <!-- Optionally, you can add icons to the links -->
            @section('active')
                <li class="active"><a href="/"><i class="fa fa-link"></i> <span>用户表</span></a></li>
                <li><a href="/user/add"><i class="fa fa-link"></i> <span>添加用户</span></a></li>
            @show
        </ul>
        <!-- /.sidebar-menu -->
    </section>
    <!-- /.sidebar -->
</aside>
