<tr>
    <th>{{ $question['text'] }} @if(isset($question['require']) && $question['require'] == \App\Question::REQUIRE_QUESTION_YES)<span class="validate">※必須</span>@endif</th>
    <td>
        @if(is_array($choices))
            @foreach($choices as $choice)
                @php
                    $identification = 'question_' . $question['id'] . '_' . $question['survey_id'] . '_choice_' . $choice['id'];
                @endphp
                <label style="font-weight:unset"><input type="checkbox" style="vertical-align: middle;margin: 0 .25em 0 0;"
                              {!!  \App\BaseWidget\Form::getAttributes($data_attributes) !!}
                              class="{{ $identification }}" value="{{ $choice['id'] }}"
                              @if(isset($question['require']) && $question['require'] == \App\Question::REQUIRE_QUESTION_YES)required @endif
                              @if(isset($question['answer']) && array_key_exists($choice['id'], $question['answer'])) checked @endif
                    >{{ $choice['text'] }}</label>
            @endforeach
        @endif
    </td>
</tr>