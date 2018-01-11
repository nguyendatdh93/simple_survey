<tr>
    <th>{{ $question['text'] }} @if(isset($question['require']) && $question['require'] == \App\Question::REQUIRE_QUESTION_YES)<span class="validate">※必須</span>@endif</th>
    <td><input type="text" name="num" value="" class="ipt01" maxlength="255"></td>
</tr>