@extends('layouts.app', ['activePage' => 'courses', 'titlePage' => __('Courses')])

@section('content')
  <div class="content">
    <div class="container-fluid">
      <div class="row">
        <div class="col-md-12">
            <div class="card">
              <div class="card-header card-header-primary">
                <h4 class="card-title ">{{ __('Courses') }}</h4>
                <p class="card-category"> {{ __('Here you can manage courses') }}</p>
              </div>
              <div class="card-body">
                @if (session('status'))
                  <div class="row">
                    <div class="col-sm-12">
                      <div class="alert alert-success">
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                          <i class="material-icons">close</i>
                        </button>
                        <span>{{ session('status') }}</span>
                      </div>
                    </div>
                  </div>
                @endif
                <div class="row">
                  <div class="col-12 text-right">
                    <a href="{{ route('courses.add') }}" class="btn btn-sm btn-primary">{{ __('Add course') }}</a>
                  </div>
                </div>
                <div class="table-responsive">
                  <table class="table">
                    <thead class=" text-primary">
                      <th>
                          {{ __('Name') }}
                      </th>
                      <th>
                        {{ __('Creation date') }}
                      </th>
                      <th>
                        {{ __('Sections') }}
                      </th>
                      <th>
                        {{ __('Questions') }}
                      </th>
                      <th class="text-right">
                        {{ __('Actions') }}
                      </th>
                    </thead>
                    <tbody>
                      @foreach($models as $model)
                        @php($questionsCount = count($model->getChildAttributes("questions")))
                        @php($sectionsCount = count($model->getChildAttributes("sections")))
                        <tr>
                          <td>
                            {{ $model->name }}
                          </td>
                          <td>
                            {{ $model->created_at->toDateTimeString() }}
                          </td>
                          <td>
                            {{ $sectionsCount }}
                          </td>
                          <td>
                            {{ $questionsCount }}
                          </td>
                          <td class="td-actions text-right">
                            <a rel="tooltip" class="btn btn-success btn-link" href="{{ route('courses.view', $model) }}" data-original-title="" title="">
                              <i class="material-icons">launch</i>
                              <div class="ripple-container"></div>
                            </a>
                              <a rel="tooltip" class="btn btn-success btn-link" href="{{ route('courses.edit', $model) }}" data-original-title="" title="">
                                <i class="material-icons">edit</i>
                                <div class="ripple-container"></div>
                              </a>
                          </td>
                        </tr>
                      @endforeach
                    </tbody>
                  </table>
                </div>
              </div>
            </div>
        </div>
      </div>
    </div>
  </div>
@endsection