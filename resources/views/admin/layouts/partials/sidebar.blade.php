<!-- Left side column. contains the logo and sidebar -->
<aside class="main-sidebar">

    <!-- sidebar: style can be found in sidebar.less -->
    <section class="sidebar">
        <!-- Sidebar Menu -->
        <ul class="sidebar-menu">
            @if(isset($menus['header']))
                <li class="header">{{ $menus['header'] }}</li>
                <?php unset($menus['header']) ?>
            @endif
            @if($menus)
                @foreach($menus as $menu)
                    @if(!isset($menu['child']))
                        <li class="@if(strpos(trim($menu['url']),Request::path()) != false) active @endif" @if(isset($menu['hidden'])) hidden @endif><a href="{{ $menu['url'] }}"><i class='{{ $menu['icon'] }}'></i> <span>{{ $menu['text'] }}</span></a></li>
                    @else
                        <li class="treeview @if(strpos(trim($menu['url']),Request::path()) != false) active @endif" @if(isset($menu['hidden'])) hidden @endif>
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
