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
                            <form method="POST" action="{{ route('quiz.submit') }}">
                                @csrf
                                <input type="hidden" name="quiz_session_id" value="{{ $quizSession->sessionGUID }}" />
                                <input type="hidden" name="question_id" value="{{ $question->id }}" />
                                @if($question->type == \App\Models\Questions\Question::TYPE_INPUT)
                                    <p>Answers are case-insensitive.</p>
                                    <div class="form-group">
                                        <input class="form-control" type="text" name="answer" placeholder="Type answer" />
                                    </div>
                                @else
                                    <p>Choose one</p>
                                    @foreach($question->answers()->get() as $answer)
                                        <div class="form-check form-check-radio">
                                            <label class="form-check-label">
                                                <input class="form-check-input" type="radio" name="answer" id="exampleRadios1" value="{{ $answer->id }}" >
                                                {{ $answer->answer }}
                                                <span class="circle">
                                                <span class="check"></span>
                                                </span>
                                            </label>
                                        </div>
                                    @endforeach
                                @endif
                                <div class="card-footer ml-auto mr-auto">
                                    <button type="submit" class="btn btn-info">{{ __('Submit') }}</button>
                                </div>
                            </form>
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