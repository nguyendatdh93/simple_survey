<tr>
    <th>{{ $question['text'] }} @if(isset($question['require']) && $question['require'] == \App\Question::REQUIRE_QUESTION_YES) <span class="validate">※必須</span> @endif</th>
    <td><textarea id="comment" class="txt01" name="comment" maxlength="225" placeholder="コメントをご記入下さい"></textarea></td>
</tr>