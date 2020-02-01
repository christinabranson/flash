@extends('layouts.app', ['activePage' => 'courses', 'titlePage' => __('User Management')])
@section('content')
  <div class="content">
    <div class="container-fluid">
      <div class="row">
        <div class="col-md-12">
          <form method="post" action="{{ route('courses.save', $model) }}" autocomplete="off" class="form-horizontal">
            @csrf
            <div class="card ">
              <div class="card-header card-header-primary">
                @if ($model->exists)
                  <h4 class="card-title">{{ __('Edit Course') }}</h4>
                @else
                  <h4 class="card-title">{{ __('Add Course') }}</h4>
                @endif
                <p class="card-category"></p>
              </div>
              <div class="card-body ">
                <div class="row">
                  <div class="col-md-12 text-right">
                    <a href="{{ route('courses.browse') }}" class="btn btn-sm btn-primary">{{ __('Back to list') }}</a>
                  </div>
                </div>
                <div class="row">
                  <label class="col-sm-2 col-form-label">{{ __('Name') }}</label>
                  <div class="col-sm-7">
                    <div class="form-group{{ $errors->has('name') ? ' has-danger' : '' }}">
                      <input class="form-control{{ $errors->has('name') ? ' is-invalid' : '' }}" name="name" id="input-name" type="text" placeholder="{{ __('Name') }}" value="{{ old('name', $model->name) }}" required="true" aria-required="true"/>
                      @if ($errors->has('name'))
                        <span id="name-error" class="error text-danger" for="input-name">{{ $errors->first('name') }}</span>
                      @endif
                    </div>
                  </div>
                </div>
                <div class="row">
                  <label class="col-sm-2 col-form-label">{{ __('Description') }}</label>
                  <div class="col-sm-7">
                    <div class="form-group{{ $errors->has('description') ? ' has-danger' : '' }}">
                      <textarea rows=5 class="form-control{{ $errors->has('description') ? ' is-invalid' : '' }}" name="description" id="input-description">{{ old('description', $model->description) }}</textarea>
                      @if ($errors->has('description'))
                        <span id="description-error" class="error text-danger" for="input-description">{{ $errors->first('description') }}</span>
                      @endif
                    </div>
                  </div>
                </div>
                <div class="row">
                  <label class="col-sm-2 col-form-label">{{ __('Split Into Sections?') }}</label>
                  <div class="col-sm-7">
                    <div class="form-check">
                      <label class="form-check-label">
                        <input class="form-check-input" type="checkbox" value="1" name="split_into_sections" @if($model->split_into_sections) checked="checked" @endif>
                        Split
                        <span class="form-check-sign">
                           <span class="check"></span>
                           </span>
                      </label>
                    </div>
                  </div>
                </div>

                <div id="sections" class="row">
                  <label class="col-sm-2 col-form-label">{{ __('Course Sections') }}</label>
                  <div class="col-sm-7">
                    <div class="form-group">
                      @include('courses.includes.course_sections_table', ['model' => $model])
                    </div>
                  </div>
                </div>

                <div class="card-footer ml-auto mr-auto">
                  @if ($model->exists)
                    <button type="submit" class="btn btn-primary">{{ __('Edit') }}</button>
                  @else
                    <button type="submit" class="btn btn-primary">{{ __('Add') }}</button>
                  @endif
                </div>
              </div>
          </form>
        </div>
      </div>
    </div>
  </div>
@endsection


@push('js')

  <script>

    var tableID = "#course_sections_table";

    /**
     * On save, write the relevant values in the table
     */
    $('button.JS_modal_save').on('click', function () {
      var modalButtonEl = $(this);
      var courseSectionID = modalButtonEl.data("course_section_id");
      console.log(courseSectionID);

      var nameValue = $("#input-name-"+courseSectionID).val();
      var descriptionValue = $("#input-description-"+courseSectionID).val();

      var tableRow = $('tr[data-tr_course_section_id='+courseSectionID+']').first();
      tableRow.find("span.name").html(nameValue);
      tableRow.find("span.description").html(descriptionValue);
    });

    function addTableItem() {
      console.log("addTableItem");
      console.log($(tableID));
      var trElementToClone = $(tableID).children("tr").first();
      var newTRElement = trElementToClone.clone();

      var newIDNumber = getNumberOfTableRows() + 1;
      console.log(newIDNumber);
      newTRElement.data("tr_id", newIDNumber);
      $(tableID).append(newTRElement);
      //newTRElement.find(".single_payor_modal").attr("id", "course_section_modal_"+newIDNumber);
      //newTRElement.find(".client-payor-modal-button").data("target", "#course_section_modal_"+newIDNumber);
    }

    // Function to kill the TR
    function deleteThisItem(element) {
      console.log("deleteThisItem");
      console.log(element);

      // first make sure we have at least 1 table element

      var parentTD = $(element).parent("td");
      var parentTR = $(parentTD).parent("tr");
      var numberOfTableRows = getNumberOfTableRows();

      if (numberOfTableRows <= 1) {
        alert("The last table item cannot be deleted. Please modify this item instead of deleting it");
        return;
      }

      if (confirm("Are you sure that you want to delete this element?")) {
        parentTR.remove();
      }
    }

    function getNumberOfTableRows() {
      return $(tableID).children("tr").length;
    }
  </script>
@endpush