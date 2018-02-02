@extends('admin::survey.form_survey')

@section('htmlheader_title')
    {{ trans('adminlte_lang::survey.htmlheader_title_preview') }}
@endsection

@section('preview_script')
    <script>
        var current_url = window.location.href,
                pattern = /editing\/preview/;

        if (pattern.test(current_url)) {
            var image_data = sessionStorage.preview_image;
            if (image_data == 'no-image') {
                $('#survey_thumbnail').remove();
            } else {
                $('#survey_thumbnail').attr('src', image_data);
            }
        }
    </script>
@stop