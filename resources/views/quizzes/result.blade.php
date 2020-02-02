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
            <div class="row justify-content-center">
                <div class="col-md-8">
                    <div class="card">
                        <div class="card-header card-header-info">
                            <h4 class="card-title">{{ $question->question }}</h4>
                            <p class="category">{{ $numRemaining }} Questions Remaining</p>
                        </div>
                        <div class="card-body">
                            <table class="table">
                                <tbody>
                                <tr>
                                    <th scope="row">Result</th>
                                    <td>{{ $log->is_correct ? "Correct" : "Incorrect" }}</td>
                                </tr>
                                <tr>
                                    <th scope="row">Your Answer</th>
                                    <td>{{ $answer_text }}</td>
                                </tr>
                                <tr>
                                    <th scope="row">Correct Answer</th>
                                    <td>{{ $correct_answer_text }}</td>
                                </tr>
                                </tbody>
                            </table>

                            @if($hasMore)
                            <div class="float-right">
                                <a type="button" rel="tooltip" class="btn btn-info btn-lg" href="{{ route("quiz.next_question", ["quiz_session_id" => $quizSession->sessionGUID]) }}">
                                    Next Question
                                </a>
                            </div>
                            @else
                                <div class="float-right">
                                    <a type="button" rel="tooltip" class="btn btn-info btn-lg" href="{{ route("quiz.results", ["quiz_session_id" => $quizSession->sessionGUID]) }}">
                                        View Results
                                    </a>
                                </div>
                            @endif
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