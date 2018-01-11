<tr>
    <th>{{ $question['text'] }} @if(isset($question['require']) && $question['require'] == \App\Question::REQUIRE_QUESTION_YES)<span class="validate">※必須</span>@endif</th>
    <td>
        @if(is_array($choices))
            @foreach($choices as $choice)
                @php
                    $identification = 'question_' . $question['id'] . '_' . $question['survey_id'] . '_choice_' . $choice['id'];
                @endphp
                <label><input type="checkbox" {!!  \App\BaseWidget\Form::getAttributes($data_attributes) !!} class="{{ $identification }}" value="{{ $choice['id'] }}" >{{ $choice['text'] }}</label>
            @endforeach
        @endif
    </td>
</tr>