<div class="social-auth-links text-center">
    <a href="{{ url('/auth/employee') }}" class="btn btn-block btn-success btn-flat">
        {{ Config::get('config.domain')}} {{ trans('adminlte_lang::survey.signGoogle') }}
    </a>
    @if ($message = Session::get('error'))
        <p class="text-danger" style="padding-top: 25px">{{ $message }}</p>
    @endif
</div><!-- /.social-auth-links -->
