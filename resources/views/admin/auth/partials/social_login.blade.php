<div class="social-auth-links text-center">
    <a href="{{ url('/auth/google') }}" class="btn btn-block btn-success btn-flat">{{ trans('adminlte_lang::message.signGoogle+') }} <br> {{ Config::get('config.domain')}}</a>
    @if ($message = Session::get('error'))
        <p class="text-danger" style="padding-top: 25px">{{ $message }}</p>
    @endif
</div><!-- /.social-auth-links -->
