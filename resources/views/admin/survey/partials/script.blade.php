<link href="{{ asset('/survey/css/custom.css') }}" rel="stylesheet" media="screen">

<script type="text/javascript" src="{{ url ('/survey/js/jquery-1.11.3.min.js') }}"></script>

<script type="text/javascript">
    (function (jQuery) {
        jQuery(document).ready(function() {

            // ▼年齢認証が必要ない場合は、削`除してください
            // ▲年齢認証が必要ない場合は、削除してください

            // toggleRule
            jQuery('#js-toggleRule1').on('click',function(){
                jQuery(this).toggleClass('on');
                jQuery('#js-ruleArea1').toggleClass('on');
                return false;
            });

            // jsを自由に記述できます。

        });
    })(jQuery);
</script>