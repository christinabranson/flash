@extends('layouts.app', ['activePage' => '', 'titlePage' => __('Start Quiz')])

@section('content')
    <div class="content">
        <div class="container-fluid">

            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-body">
                            <div class="d-flex justify-content-between">
                                <div>COURSE: {{ $quizSession->course->name }}
                                @if($quizSession->section_id)
                                    &mdash; SECTION: {{ $quizSession->section->name }}</div>
                                @endif
                                <div>SESSION ID: {{ $quizSession->sessionGUID }}</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            @php($questionsCount = count($course_section->getChildAttributes("questions")))
            <div class="row justify-content-center">
                <div class="col-md-8">
                    <div class="card">
                        <div class="card-header card-header-info">
                            <h4 class="card-title">{{ $course->name }} &mdash; {{ $course_section->name }}</h4>
                            <p class="category">{{ $course_section->description }}</p>

                        </div>
                        <div class="card-body">
                            <p>
                                {{$questionsCount}} Questions Total
                            </p>
                            <div class="float-right">
                                <a type="button" rel="tooltip" class="btn btn-warning btn-lg" href="{{ route("quiz.next_question", ["quiz_session_id" => $quizSession->sessionGUID]) }}">
                                    Start Quiz
                                </a>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
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