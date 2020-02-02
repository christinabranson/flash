@extends('layouts.app', ['activePage' => '', 'titlePage' => __('Start Quiz')])
@section('content')
    <div class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-body">
                            <div class="d-flex justify-content-between">
                                <div>COURSE: {{ $quizSession->course->name }}</div>
                                @if($quizSession->section_id)
                                    <div>SECTION: {{ $quizSession->section->name }}</div>
                                @endif
                                <div>SESSION ID: {{ $quizSession->sessionGUID }}</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row justify-content-center">
                <div class="col-md-6">
                    <div class="card">
                        <div class="card-header card-header-info">
                            <h4 class="card-title">Results</h4>
                            <p class="category">{{ $quizSession->course->name }}</p>
                        </div>
                        <div class="card-body">
                            <table class="table">
                                <thead>
                                <tr>
                                    <th>Question</th>
                                    <th>Your Answer</th>
                                    <th>Correct Answer</th>
                                    <th>Result</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($logs as $log)
                                    <tr>
                                        <th scope="row">
                                            {{ $log->question->question }}
                                        </th>
                                        <td>{{ $log->provided_answer }}</td>
                                        <td>{{ $log->correct_answer }}</td>
                                        <td>{{ $log->is_correct ? "Correct" : "Incorrect" }}</td>
                                    </tr>
                                @endforeach
                                <tr>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td>{{ $totalCorrect  }} / {{ count($logs) }}</td>
                                </tr>
                                </tbody>
                            </table>
                            <div class="float-right">
                                <a type="button" rel="tooltip" class="btn btn-danger btn-lg" href="{{ route("quiz.take_course_quiz", $quizSession->course) }}">
                                    Take Quiz Again
                                </a>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-lg-3 col-md-6 col-sm-6">
                    <div class="card card-stats">
                        <div class="card-header card-header-danger card-header-icon">
                            <div class="card-icon">
                                <i class="material-icons">assessment</i>
                            </div>
                            <p class="card-category">Total Score</p>
                            <h3 class="card-title">{{ $totalCorrect  }} / {{ count($logs) }}</h3>

                            <p>
                            <div class="ct-chart ct-perfect-fourth"></div>

                            </p>
                        </div>
                        <div class="card-footer align-content-center">
                            <div class="align-content-center">
                                <a type="button" rel="tooltip" class="btn btn-danger btn-sm" href="{{ route("quiz.take_course_quiz", $quizSession->course) }}">
                                    Take Quiz Again
                                </a>
                            </div>
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
    new Chartist.Pie('.ct-chart', {
        series: [{{ $totalCorrect  }}, {{ count($logs) - $totalCorrect }}]
    }, {
        donut: true,
        donutWidth: 60,
        donutSolid: true,
        startAngle: 270,
        showLabel: true
    });
</script>
@endpush