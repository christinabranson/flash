@extends('layouts.app', ['activePage' => 'dashboard', 'titlePage' => __('Dashboard')])

@section('content')
  <div class="content">
    <div class="container-fluid">
      @foreach($courses as $course)
        @php($questionsCount = count($course->getChildAttributes("questions")))
      <div class="row">
        <div class="col-12">
          <div class="card">
            <div class="card-header card-header-info">
              <div class="float-right">
                <a type="button" rel="tooltip" class="btn btn-warning btn-lg" href="{{ route("quiz.take_course_quiz", $course) }}">
                  <i class="material-icons">edit</i>
                  Take Quiz On Course
                </a>
              </div>
              <h4 class="card-title">{{ $course->name }}</h4>
              <p class="category">{{ $course->description }}</p>

            </div>
            <div class="card-body">
              <p>
                {{$questionsCount}} Questions Total
              </p>
              @php($sections = $course->getChildAttributes("sections"))
              @if (count($sections))

                    <div class="form-group">
                      <table id="course_sections_table" class="table">
                        <thead>
                        <tr>
                          <th>Name</th>
                          <th>Questions</th>
                          <th class="text-right">Actions</th>
                        </tr>
                        </thead>
                        <tbody id="sortable">
                          @foreach($sections as $section)
                            @php($sectionQuestions = $section->questions()->count())
                            <tr class="tr_clone" data-tr_course_section_id="{{ $section->id }}">
                              <td><span class="name">{{ $section->name }}</span></td>
                              <td><span class="description">{{ $section->questions()->count() }}</span></td>
                              <td class="td-actions text-right">

                                <a type="button" rel="tooltip" class="btn btn-warning" href="{{ route("courses.manage_section_questions", $section) }}">
                                  <i class="material-icons">edit</i>
                                  Take Quiz On Section ({{ $sectionQuestions }} Questions)
                                </a>
                              </td>
                            </tr>
                          @endforeach
                        </tbody>
                      </table>
                    </div>

              @endif
            </div>
          </div>
        </div>

      </div>
      @endforeach
    </div>
  </div>
@endsection

@push('js')
  <script>
    $(document).ready(function() {
      // Javascript method's body can be found in assets/js/demos.js
      md.initDashboardPageCharts();
    });
  </script>
@endpush