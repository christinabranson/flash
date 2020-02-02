@extends('layouts.app', ['activePage' => 'history', 'titlePage' => __('Quiz History')])
@section('content')
    <div class="content">
        <div class="container-fluid">
            <div class="row justify-content-center">
                <div class="col-md-8">
                    @if(count($inProgressSessions))
                    <div class="card">
                        <div class="card-header card-header-info">
                            <h4 class="card-title">In Progress</h4>
                            <p class="category">Quizzes that are currently in progress</p>
                        </div>
                        <div class="card-body">
                            <table class="table">
                                <thead>
                                <tr>
                                    <th>Course</th>
                                    <th>Section</th>
                                    <th>Progress</th>
                                    <th>Actions</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($inProgressSessions as $session)
                                    <tr>
                                        <th scope="row">
                                            {{ $session->course->name }}
                                        </th>
                                        <td>{{ $session->section ? $session->section->name : "N/A" }}</td>
                                        <td>{{ $session->getNumberOfRemainingQuestions() }} Questions Remaining</td>
                                        <td>
                                            @if($session->section)
                                            <a type="button" rel="tooltip" class="btn btn-v btn-sm" href="{{ route("quiz.take_course_section_quiz", $session->section) }}">
                                                Re-Take Quiz On Section
                                            </a>
                                            @else
                                                <a type="button" rel="tooltip" class="btn btn-danger btn-sm" href="{{ route("quiz.take_course_quiz", $session->course) }}">
                                                    Re-Take Quiz On Course
                                                </a>
                                            @endif
                                        </td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                    @endif

                        @if(count($completedSessions))
                            <div class="card">
                                <div class="card-header card-header-info">
                                    <h4 class="card-title">Completed</h4>
                                    <p class="category">Completed Quizzes</p>
                                </div>
                                <div class="card-body">
                                    <table class="table">
                                        <thead>
                                        <tr>
                                            <th>Course</th>
                                            <th>Section</th>
                                            <th>Result</th>
                                            <th>Actions</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        @foreach($completedSessions as $session)
                                            <tr>
                                                <th scope="row">
                                                    {{ $session->course->name }}
                                                </th>
                                                <td>{{ $session->section ? $session->section->name : "N/A" }}</td>
                                                <td>
                                                     <strong>{{ $session->getPercentageCorrect() }}% ({{ $session->getNumberCorrect() }} / {{ count($session->logs) }})</strong>
                                                </td>
                                                <td>
                                                    <a type="button" rel="tooltip" class="btn btn-danger btn-sm" href="{{ route("quiz.results", ["quiz_session_id" => $session->sessionGUID]) }}">
                                                        View Results
                                                    </a>
                                                    @if($session->section)
                                                        <a type="button" rel="tooltip" class="btn btn-danger btn-sm" href="{{ route("quiz.take_course_section_quiz", $session->section) }}">
                                                            Re-Take Quiz On Section
                                                        </a>
                                                    @else
                                                        <a type="button" rel="tooltip" class="btn btn-danger btn-sm" href="{{ route("quiz.take_course_quiz", $session->course) }}">
                                                            Re-Take Quiz On Course
                                                        </a>
                                                    @endif
                                                </td>
                                            </tr>
                                        @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        @endif
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