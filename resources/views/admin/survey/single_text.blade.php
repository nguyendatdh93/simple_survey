<tr>
    <th>{{ $question['text'] }} @if(isset($question['require']) && $question['require'] == \App\Question::REQUIRE_QUESTION_YES)<span class="validate">※必須</span>@endif</th>
    <td><input type="text" {!!  \App\BaseWidget\Form::getAttributes($data_attributes) !!}></td>
</tr>