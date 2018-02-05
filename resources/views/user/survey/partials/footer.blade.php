<div class="footer">
    <!-- ▼変更可能エリア※div（copy）は固定なので変更しないでください -->
    <p class="copy">
        @if(Config::get('config.copyright_text_in_footer'))
            {{ str_replace('_YEAR_', date('Y'), Config::get('config.copyright_text_in_footer')) }}
        @else
            Copyright &copy; {{ date('Y') }} ●●●●●, Inc. All Rights Reserved.
        @endif
    </p>
    <!-- ▲変更可能エリア 終わり -->
<!-- /.footer --></div>