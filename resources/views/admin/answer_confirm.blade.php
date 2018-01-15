@extends('admin::survey.form_survey')

@section('form-header')
    <h1 class="headline1"></h1>

    <!-- ▼変更可能エリア※div（headFreeArea）は固定なので変更しないで下さい -->
    <div class="headFreeArea">内容をご確認のうえ、「送信する」ボタンを押してください。</div>
@endsection

@section("form-content")
    <form action="{{ route(\App\Survey::NAME_URL_SUBMIT_CONFIRM, ['encrypt' => isset($survey['encrypt_url']) ? $survey['encrypt_url'] : ""]) }}" method="GET" name="join_form">
        <!-- ▼変更可能エリア※div（hruleArea1）は固定なので変更しないでください -->
        <table class="formTable">
            @foreach($survey['questions'] as $answer)
                <tr>
                    <th class="CThWid175">{{ $answer['text'] }}</th>
                    <td>
                        <p>
                            @if(!isset($answer['answer']))
                                {!!  "-" !!}
                            @else
                                @if (!is_array($answer['answer']))
                                    @if (!\App\BaseWidget\Validator::isNullOrEmpty($answer['answer']))
                                        {!!  "-" !!}
                                    @else
                                        {{ $answer['answer'] }}
                                    @endif
                                @else
                                    @php $answer_text = "" @endphp
                                    @foreach($answer['answer'] as $text)
                                        @php
                                            $answer_text = $answer_text . ',' . $text['text']
                                        @endphp
                                    @endforeach
                                    {{ trim($answer_text,',') }}
                                @endif
                            @endif
                        </p>
                    </td>
                </tr>
            @endforeach
            <!-- /.formTable --></table>
        <!-- ▲変更可能エリア 終わり -->
        <ul class="btnSet2">
            <li><p class="btn2"><a href="{{ route(\App\Survey::NAME_URL_ANSWER_SURVEY,['encrypt' => $survey['encrypt_url']]) }}">戻る</a></p></li>
            <li><p class="btn1"><a href="javascript:;" onClick="document.join_form.submit();">送信する</a></p></li>
            <!-- /.btnSet2 --></ul>
        <script>
            function goBack() {
                window.history.back();
            }
        </script>
    </form>
@endsection