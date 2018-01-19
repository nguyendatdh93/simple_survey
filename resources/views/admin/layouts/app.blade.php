<!DOCTYPE html>
<!--
This is a starter template page. Use this page to start your new project from
scratch. This page gets rid of all links and provides the needed markup only.
-->
<html lang="en">

@section('htmlheader')
    @include('admin::layouts.partials.htmlheader')
@show

<!--
BODY TAG OPTIONS:
=================
Apply one or more of the following classes to get the
desired effect
|---------------------------------------------------------|
| SKINS         | skin-blue                               |
|               | skin-black                              |
|               | skin-purple                             |
|               | skin-yellow                             |
|               | skin-red                                |
|               | skin-green                              |
|---------------------------------------------------------|
|LAYOUT OPTIONS | fixed                                   |
|               | layout-boxed                            |
|               | layout-top-nav                          |
|               | sidebar-collapse                        |
|               | sidebar-mini                            |
|---------------------------------------------------------|
-->
<body class="skin-blue sidebar-mini" style="background: #222e32;">
<div id="app" v-html>
    {!! \App\BaseWidget\Menu::setLogo(new \App\BaseWidget\Menu()) !!}

    {!! \App\BaseWidget\Menu::setLeftMenu(new \App\BaseWidget\Menu()) !!}
    <div class="wrapper">
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">

        @include('admin::layouts.partials.contentheader')

        <!-- Main content -->
        <section class="content">
            <!-- Your Page Content Here -->
            @yield('main-content-form')
        </section><!-- /.content -->
    </div><!-- /.content-wrapper -->

    @include('admin::layouts.partials.controlsidebar')

    @include('admin::layouts.partials.footer')

</div><!-- ./wrapper -->
</div>
@section('scripts')
    @include('admin::layouts.partials.scripts')
@show

@section('datatable')

@show

</body>
</html>
