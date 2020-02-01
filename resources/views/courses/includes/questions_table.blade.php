<table id="questions_table" class="table">
    <thead>
    <tr>
        <th>Question</th>
        <th>Type</th>
        <th class="text-right">Actions</th>
    </tr>
    </thead>
    <tbody id="sortableQuestions">
    @php($questions = $model->getChildAttributes("questions"))
    @if(count($questions))
        @foreach($questions as $question)
            <tr class="tr_clone" data-tr_question_id="{{ $question->id }}">
                <td><span class="question">{{ $question->question }}</span></td>
                <td><span class="type">{{ $question->getThisTypeString() }}</span></td>
                <td class="td-actions text-right">
                    @include('courses.includes.questions_modal', ['section' => $question, 'course_id' => $course_id, 'section_id' => $section_id])


                    <button type="button" rel="tooltip" class="btn btn-success btn-modal-open" data-toggle="modal" data-target="#question_modal_{{ $question->id }}">
                        <i class="material-icons">edit</i>
                    </button>
                    <button type="button" rel="tooltip" class="btn btn-danger btn-modal-open" onclick="deleteThisItem(this)">
                        <i class="material-icons">delete</i>
                    </button>
                </td>
            </tr>
        @endforeach
    @else
        @php($question = new stdClass())
        @php($question->exists = false)
        @php($question->id = 0)
        @php($question->question = "")
        @php($question->type = 1)
        @php($question->correct_answer = "")
        <tr class="tr_clone" data-tr_question_id="{{ $question->id }}">
            <td><span class="question"></span></td>
            <td><span class="type"></span></td>
            <td class="td-actions text-right">
                @include('courses.includes.questions_modal', ['question' => $question, 'course_id' => $course_id, 'section_id' => $section_id])

                <button type="button" rel="tooltip" class="btn btn-success btn-modal-open" data-toggle="modal" data-target="#question_modal_{{ $question->id }}">
                    <i class="material-icons">edit</i>
                </button>
                <button type="button" rel="tooltip" class="btn btn-danger btn-modal-open" onclick="deleteThisItem(this)">
                    <i class="material-icons">delete</i>
                </button>
            </td>
        </tr>
    @endif
    </tbody>
</table>
<input type="button" onclick="addTableItem('#questions_table')" class="btn btn-sm btn-secondary" value="+ Add Item" />