<table id="answer_table_{{ $question->id }}" class="table answers_table">
    <thead>
    <tr>
        <th>Answer</th>
        <th>Is Correct</th>
        <th class="text-right">Actions</th>
    </tr>
    </thead>
    <tbody id="sortableAnswers">
    @php($answers = $question->exists ? $question->getChildAttributes("answers") : [])
    @if(count($answers))
        @foreach($answers as $answer)
            <tr class="tr_clone" data-tr_answer_id="{{ $answer->id }}">
                <input type="hidden" name="answers_question_id[]" value="{{ $question->id }}" />
                <input type="hidden" name="answers_id[]" value="{{ $answer->id }}" />
                <td><span class="answer"><input name="answers_answer[]" value="{{ $answer->answer }}" /></span></td>
                <td>
                <span class="is_correct">
                    <select class="form-control" name="answers_is_correct[]">
                        @foreach([0 => "No", 1 =>  "Yes"] as $answerInt => $answerName)
                            @php($selected = $answer->is_correct == $answerInt ? " selected=\"selected\" " : "")
                            <option value="{{ $answerInt }}" {{ $selected }}>{{ $answerName }}</option>
                        @endforeach
                    </select>
                </span>
                </td>
                <td class="td-actions text-right">
                    <button type="button" rel="tooltip" class="btn btn-danger btn-modal-open" onclick="deleteThisItem(this)">
                        <i class="material-icons">delete</i>
                    </button>
                </td>
            </tr>
        @endforeach
    @else
        @php($answer = new stdClass())
        @php($answer->exists = false)
        @php($answer->id = 0)
        @php($answer->answer = "")
        @php($answer->is_correct = 0)
        <tr class="tr_clone" data-tr_answer_id="{{ $answer->id }}">
            <input type="hidden" name="answers_question_id[]" value="{{ $question->id }}" />
            <input type="hidden" name="answers_id[]" value="{{ $answer->id }}" />
            <td><span class="answer"><input name="answers_answer[]" value="{{ $answer->answer }}" /></span></td>
            <td>
                <span class="is_correct">
                    <select class="form-control" name="answers_is_correct[]">
                        @foreach([0 => "No", 1 =>  "Yes"] as $answerInt => $answerName)
                            @php($selected = $answer->is_correct == $answerInt ? " selected=\"selected\" " : "")
                            <option value="{{ $answerInt }}" {{ $selected }}>{{ $answerName }}</option>
                        @endforeach
                    </select>
                </span>
            </td>
            <td class="td-actions text-right">
                <button type="button" rel="tooltip" class="btn btn-danger btn-modal-open" onclick="deleteThisItem(this)">
                    <i class="material-icons">delete</i>
                </button>
            </td>
        </tr>
    @endif
    </tbody>
</table>
<input type="button" onclick="addAnswersTableItem('#answer_table_{{ $question->id }}')" class="btn btn-sm btn-secondary add_answers_to_table_button" value="+ Add Item" />