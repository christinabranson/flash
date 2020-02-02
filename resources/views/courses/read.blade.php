@extends('layouts.app', ['activePage' => 'courses', 'titlePage' => __('Courses')])

@section('content')
  <div class="content">
    <div class="container-fluid">
      <div class="row">
        <div class="col-md-12">
            <div class="card">
              <div class="card-header card-header-primary">
                <h4 class="card-title ">{{ $model->name }}</h4>
                <p class="card-category">View Course Details & Modify Questions</p>
              </div>
              <div class="card-body">
                <div class="row">
                  <div class="col-md-12 text-right">
                    <a href="{{ route('courses.browse') }}" class="btn btn-sm btn-primary">{{ __('Back to list') }}</a>
                    <a href="{{ route('courses.edit', $model) }}" class="btn btn-sm btn-primary">{{ __('Edit Course') }}</a>
                  </div>
                </div>

                <div class="row">
                  <label class="col-sm-2 col-form-label">{{ __('Name') }}</label>
                  <div class="col-sm-7">
                    <div class="form-group">
                      {{ $model->name }}
                    </div>
                  </div>
                </div>
                <div class="row">
                  <label class="col-sm-2 col-form-label">{{ __('Description') }}</label>
                  <div class="col-sm-7">
                    <div class="form-group">
                      {{ $model->description }}
                    </div>
                  </div>
                </div>

                @php($questionsCount = count($model->getChildAttributes("questions")))
                <div id="questions" class="row">
                  <label class="col-sm-2 col-form-label">{{ __('Course Questions') }}</label>
                  <div class="col-sm-7">
                    <div class="form-group">
                      <a class="btn btn-sm btn-primary" href="{{ route('courses.manage_course_questions', $model) }}">Manage Course Questions ({{ $questionsCount }})</a>
                    </div>
                  </div>
                </div>

                @php($sections = $model->getChildAttributes("sections"))
                  @if (count($sections))
                  <div id="sections" class="row">
                    <label class="col-sm-2 col-form-label">{{ __('Course Sections') }}</label>
                    <div class="col-sm-7">
                      <div class="form-group">
                        @include('courses.includes.course_sections_table_view', ['model' => $model, 'sections' => $sections])
                      </div>
                    </div>
                  </div>
                @endif

              </div>
            </div>
        </div>
      </div>
    </div>
  </div>
@endsection