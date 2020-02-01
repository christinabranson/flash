<div id="question_modal_{{ $question->id }}" class="modal question_modal" tabindex="-1" role="dialog" data-modal_question_id="{{ $question->id }}">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-12">
                        <div class="card ">
                            <div class="card-header card-header-primary">
                                @if ($question->exists)
                                    <h4 class="card-title">{{ __('Edit Question') }}</h4>
                                @else
                                    <h4 class="card-title">{{ __('Add Question') }}</h4>
                                @endif
                                <p class="card-category"></p>
                            </div>
                            <!-- hidden variable to show that it exists --->
                            <input name="questions_exists_in_post[]" id="input-exists-{{ $question->id }}" type="hidden" value="{{ $question->exists ? 1 : 0 }}">
                            <input name="questions_id[]" id="input-id-{{ $question->id }}" type="hidden" value="{{ $question->id }}">
                            <input name="questions_course_id[]" type="hidden" value="{{ $course_id }}">
                            <input name="questions_section_id[]" type="hidden" value="{{ $section_id }}">
                            <div class="card-body ">
                                <div class="row">
                                    <label class="col-sm-2 col-form-label">{{ __('Question') }}</label>
                                    <div class="col-sm-7">
                                        <div class="form-group">
                                            <input class="form-control" name="questions_question[]" id="input-question-{{ $question->id }}" type="text" placeholder="{{ __('Question') }}" value="{{ old('question', $question->question) }}" />

                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <label class="col-sm-2 col-form-label">{{ __('Type') }}</label>
                                    <div class="col-sm-7">
                                        <div class="form-group">
                                            <select name="questions_type[]" id="input-type-{{ $question->id }}" class="form-control">
                                                @foreach (\App\Models\Questions\Question::getTypesForDropdown() as $type_id => $type_name)
                                                    @php ($selected = ($question->type == $type_id) ? " selected=\"selected\" " : "" )
                                                    <option value="{{$type_id}}" {{$selected}}>{{$type_name}}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <label class="col-sm-2 col-form-label">{{ __('Correct Answer') }}</label>
                                    <div class="col-sm-7">
                                        <div class="form-group">
                                            <input class="form-control" name="questions_correct_answer[]" id="input-correct_answer-{{ $question->id }}" type="text" placeholder="{{ __('Correct Answer') }}" value="{{ old('correct_answer', $question->correct_answer) }}" />
                                        </div>
                                    </div>
                                </div>
                                @if (true)
                                <div class="row">
                                    <label class="col-sm-2 col-form-label">{{ __('Answers') }}</label>
                                    <div class="col-sm-7">
                                        <div class="form-group">
                                            @include('courses.includes.answers_table', ['question' => $question])
                                        </div>
                                    </div>
                                </div>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary JS_modal_save" data-question_id="{{ $question->id }}">Save changes</button>
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>