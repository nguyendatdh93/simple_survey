<!-- Left side column. contains the logo and sidebar -->
<aside class="main-sidebar">

    <!-- sidebar: style can be found in sidebar.less -->
    <section class="sidebar">

        <!-- Sidebar user panel (optional) -->
        @if (! Auth::guest())
            <div class="user-panel">
                <div class="pull-left image">
                    <img src="{{ Gravatar::get($user->email) }}" class="img-circle" alt="User Image" />
                </div>
                <div class="pull-left info">
                    <p>{{ Auth::user()->name }}</p>
                    <!-- Status -->
                    <a href="#"><i class="fa fa-circle text-success"></i> {{ trans('adminlte_lang::message.online') }}</a>
                </div>
            </div>
        @endif

        <!-- search form (Optional) -->
        {{--<form action="#" method="get" class="sidebar-form">--}}
            {{--<div class="input-group">--}}
                {{--<input type="text" name="q" class="form-control" placeholder="{{ trans('adminlte_lang::message.search') }}..."/>--}}
              {{--<span class="input-group-btn">--}}
                {{--<button type='submit' name='search' id='search-btn' class="btn btn-flat"><i class="fa fa-search"></i></button>--}}
              {{--</span>--}}
            {{--</div>--}}
        {{--</form>--}}
        <!-- /.search form -->

        <!-- Sidebar Menu -->
        <ul class="sidebar-menu">
            @if(isset($menus['header']))
                <li class="header">{{ $menus['header'] }}</li>
                <?php unset($menus['header']) ?>
            @endif
            @if($menus)
                @foreach($menus as $menu)
                    @if(!isset($menu['child']))
                        <li class="@if(isset($menu['active'])) active @endif"><a href="{{ $menu['url'] }}"><i class='{{ $menu['icon'] }}'></i> <span>{{ $menu['text'] }}</span></a></li>
                    @else
                        <li class="treeview @if(isset($menu['active'])) active @endif">
                            <a href="{{ $menu['url'] }}"><i class='{{ $menu['icon'] }}'></i> <span>{{ $menu['text'] }}</span> <i class="fa fa-angle-left pull-right"></i></a>
                            <ul class="treeview-menu">
                                @foreach($menu['child'] as $child)
                                    <li><a href="{{ $child['url'] }}">{{ $child['text'] }}</a></li>
                                @endforeach
                            </ul>
                        </li>
                    @endif

                @endforeach
            @endif
        </ul><!-- /.sidebar-menu -->
    </section>
    <!-- /.sidebar -->
</aside>
