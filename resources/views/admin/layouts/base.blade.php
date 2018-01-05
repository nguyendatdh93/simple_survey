<!DOCTYPE html>
<html lang="en">

@section('htmlheader')
    @include('admin::layouts.partials.htmlheader')
@show

<body class="skin-blue sidebar-mini">
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

</body>
</html>
