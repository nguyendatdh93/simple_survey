<tr>
    <th>{{ $question['text'] }} @if(isset($question['require']) && $question['require'] == \App\Question::REQUIRE_QUESTION_YES) <span class="validate">※必須</span> @endif</th>
    <td><textarea {!!  \App\BaseWidget\Form::getAttributes($data_attributes) !!}
        @if(isset($question['require']) && $question['require'] == \App\Question::REQUIRE_QUESTION_YES) required @endif>{{ isset($question['answer']) ? $question['answer'] : "" }}</textarea></td>
</tr>