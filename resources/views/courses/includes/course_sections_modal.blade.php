<div id="course_section_modal_{{ $section->id }}" class="modal course_section_modal" tabindex="-1" role="dialog" data-modal_course_section_id="{{ $section->id }}">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-12">
                        <div class="card ">
                            <div class="card-header card-header-primary">
                                @if ($section->exists)
                                    <h4 class="card-title">{{ __('Edit Course Section') }}</h4>
                                @else
                                    <h4 class="card-title">{{ __('Add Course Section') }}</h4>
                                @endif
                                <p class="card-category"></p>
                            </div>
                            <!-- hidden variable to show that it exists --->
                            <input name="sections_exists_in_post[]" id="input-exists-{{ $section->id }}" type="hidden" value="{{ $section->exists ? 1 : 0 }}">
                            <input name="sections_id[]" type="hidden" value="{{$section->id}}">
                            <div class="card-body ">
                                <div class="row">
                                    <label class="col-sm-2 col-form-label">{{ __('Name') }}</label>
                                    <div class="col-sm-7">
                                        <div class="form-group">
                                            <input class="form-control" name="sections_name[]" id="input-name-{{ $section->id }}" type="text" placeholder="{{ __('Name') }}" value="{{ old('name', $section->name) }}" />

                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <label class="col-sm-2 col-form-label">{{ __('Description') }}</label>
                                    <div class="col-sm-7">
                                        <div class="form-group">
                                            <textarea rows=5 class="form-control" name="sections_description[]" id="input-description-{{ $section->id }}">{{ old('description', $section->description) }}</textarea>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary JS_modal_save" data-course_section_id="{{ $section->id }}">Save changes</button>
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>