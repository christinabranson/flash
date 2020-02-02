@extends('layouts.app', ['activePage' => 'courses', 'titlePage' => __('User Management')])
@section('content')
  <div class="content">
    <div class="container-fluid">
      <div class="row">
        <div class="col-md-12">
          <form method="post" action="{{ route('courses.save') }}" autocomplete="off" class="form-horizontal">
            @csrf

            <!-- HIDDEN VALUE FOR MODEL ID -->
            <input name="model_id" type="hidden" value="{{$model->id}}">

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

    function cloneModalContentsToTable(modalButtonEl) {
      console.log("cloneModalContentsToTable");
      var courseSectionID = modalButtonEl.data("course_section_id");
      console.log(courseSectionID);

      var nameValue = $("#input-name-"+courseSectionID).val();
      var descriptionValue = $("#input-description-"+courseSectionID).val();

      var tableRow = $('tr[data-tr_course_section_id='+courseSectionID+']').first();
      tableRow.find("span.name").html(nameValue);
      tableRow.find("span.description").html(descriptionValue);

      // if name value exists, then say the field exists
      if (nameValue !== undefined && nameValue.length) {
        $("#input-exists-"+courseSectionID).val(1);
      }
    }


    /**
     * On save, write the relevant values in the table
     */
    $('button.JS_modal_save').on('click', function () {
      var modalButtonEl = $(this);
      cloneModalContentsToTable(modalButtonEl)
    });

    function addTableItem() {
      var newIDNumber = getNumberOfTableRows() + 100000;
      console.log("new table ID with course number " + newIDNumber);

      // Clone the TR
      var trElementToClone = $(".tr_clone").first();
      var newTRElement = trElementToClone.clone();

      $(tableID).append(newTRElement);
      // Update the data id on the course section
      newTRElement.attr("data-tr_course_section_id", newIDNumber);
      // Erase any existing values in name
      newTRElement.find("span.name").html("");
      // Erase any existing values in description
      newTRElement.find("span.description").html("");
      // Add the updated modal target link to the edit button
      newTRElement.find(".btn-modal-open").attr("data-target", "#course_section_modal_"+newIDNumber);


      // Clone the modal

      //var modalToClone = $(".course_section_modal").first();
      //var newModalElement = modalToClone.clone();
      var newModalElement = newTRElement.find(".course_section_modal").first();

      // Clear all inputs
      newModalElement.find("input").val("");
      newModalElement.find("textarea").val("");
      // Now change the IDs of all of the input elements
      newModalElement.find("input[name=\"sections_name[]\"]").attr("id", "input-name-"+newIDNumber);
      newModalElement.find("textarea[name=\"sections_description[]\"]").attr("id", "input-description-"+newIDNumber);

      newModalElement.attr("id", "course_section_modal_"+newIDNumber);
      newModalElement.attr("data-modal_course_section_id", newIDNumber);
      newModalElement.find("input[name=\"sections_exists_in_post[]\"]").attr("id", "input-exists-"+newIDNumber);

      newModalElement.find(".JS_modal_save").attr("data-course_section_id", newIDNumber);

      /**
       * On save, write the relevant values in the table
       */
      $('button.JS_modal_save').on('click', function () {
        var modalButtonEl = $(this);
        cloneModalContentsToTable(modalButtonEl)
      });
    }

    // Function to kill the TR
    function deleteThisItem(element) {
      console.log("deleteThisItem");

      // first make sure we have at least 1 table element

      var parentTD = $(element).parent("td");
      var parentTR = $(parentTD).parent("tr");
      var rowID = parentTR.attr("data-tr_course_section_id");
      var numberOfTableRows = getNumberOfTableRows();

      console.log("deleting row with rowID: " + rowID);

      if (numberOfTableRows <= 1) {
        alert("The last table item cannot be deleted. Please modify this item instead of deleting it");
        return;
      }

      if (confirm("Are you sure that you want to delete this element?")) {
        parentTR.remove();

        // now delete the modal
        var modalToRemove = $("#course_section_modal_"+rowID);
        modalToRemove.remove();
      }
    }

    function getNumberOfTableRows() {
      return $(".tr_clone").length;
    }
  </script>

<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
<script>
  $( function() {
    $( "#sortable" ).sortable();
    $( "#sortable" ).disableSelection();
  } );
</script>
@endpush