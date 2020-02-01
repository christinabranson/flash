<table id="course_sections_table" class="table">
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
            <tr class="tr_clone" data-tr_question_id="{{ $answer->id }}">
                <td><span class="answer"><input name="answers_answer[]" value="{{ $answer->answer }}" /></span></td>
                <td><span class="is_correct">{{ $answer->is_correct }}</span></td>
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
        <tr class="tr_clone" data-tr_course_section_id="{{ $answer->id }}">
            <td><span class="answer"><input name="answers_answer[]" value="{{ $answer->answer }}" /></span></td>
            <td><span class="is_correct"></span></td>
            <td class="td-actions text-right">
                <button type="button" rel="tooltip" class="btn btn-danger btn-modal-open" onclick="deleteThisItem(this)">
                    <i class="material-icons">delete</i>
                </button>
            </td>
        </tr>
    @endif
    </tbody>
</table>
<input type="button" onclick="addAnswersTableItem()" class="btn btn-sm btn-secondary" value="+ Add Item" />