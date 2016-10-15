<!-- Left side column. contains the logo and sidebar -->
<aside class="main-sidebar">

    <!-- sidebar: style can be found in sidebar.less -->
    <section class="sidebar">

        <!-- Sidebar staff panel (optional) -->
        <div class="staff-panel">
            @if (Auth::check())
                <div class="pull-left image">
                    <img src="{{ Gravatar::get(Auth::user()->email , 'small') }}" class="img-circle" alt="Staff Image" />
                </div>
                <div class="pull-left info">
                    <p>{{ Auth::user()->full_name }}</p>
                    <!-- Status -->
                    <a href="#"><i class="fa fa-circle text-success"></i> Online</a>
                </div>
            @endif
        </div>

        <!-- search form (Optional) -->
        <form action="#" method="get" class="sidebar-form">
            <div class="input-group">
                <input type="text" name="q" class="form-control" placeholder="Search..."/>
              <span class="input-group-btn">
                <button type='submit' name='search' id='search-btn' class="btn btn-flat"><i class="fa fa-search"></i></button>
              </span>
            </div>
        </form>
        <!-- /.search form -->

        {!! MenuBuilder::renderMenu('home')  !!}

        {!! MenuBuilder::renderMenu('admin', true)  !!}
    </section>
    <!-- /.sidebar -->
</aside>
