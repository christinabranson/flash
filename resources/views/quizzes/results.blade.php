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
                <div class="col-md-8">
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