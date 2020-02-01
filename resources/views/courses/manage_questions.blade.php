@extends('layouts.app', ['activePage' => 'courses', 'titlePage' => __('Courses')])
@section('content')
  <div class="content">
    <div class="container-fluid">
      <div class="row">
        <div class="col-md-12">
          <form method="post" action="{{ route('courses.save_questions') }}" autocomplete="off" class="form-horizontal">
            @csrf

            <!-- HIDDEN VALUE FOR MODEL ID -->
              <input name="model_id" type="hidden" value="{{$model->id}}">
              <input name="model_type" type="hidden" value="{{$classType}}">

          <div class="card">
            <div class="card-header card-header-primary">
              <h4 class="card-title ">{{ $model->name }}</h4>
              @if ($classType == "course")
              <p class="card-category">View Course Details & Modify Questions</p>
                @else
                <p class="card-category">View Course Section Details & Modify Questions</p>
              @endif
            </div>
            <div class="card-body">
              <div class="row">
                <div class="col-md-12 text-right">
                  <a href="{{ route('courses.browse') }}" class="btn btn-sm btn-primary">{{ __('Back to list') }}</a>
                </div>
              </div>

              <div class="row">
                <label class="col-sm-2 col-form-label">{{ __('Name') }}</label>
                <div class="col-sm-7">
                  <div class="form-group">
                    {{ $model->name }}
                  </div>
                </div>
              </div>
              <div class="row">
                <label class="col-sm-2 col-form-label">{{ __('Description') }}</label>
                <div class="col-sm-7">
                  <div class="form-group">
                    {{ $model->description }}
                  </div>
                </div>
              </div>

              <div id="sections" class="row">
                <label class="col-sm-2 col-form-label">{{ __('Questions') }}</label>
                <div class="col-sm-7">
                  <div class="form-group">
                    @include('courses.includes.questions_table', ['model' => $model, 'course_id' => $course_id, 'section_id' => $section_id])
                  </div>
                </div>
              </div>

            </div>
            <div class="card-footer ml-auto mr-auto">
                <button type="submit" class="btn btn-primary">{{ __('Save Questions') }}</button>
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

  function cloneModalContentsToTable(modalButtonEl) {
    var courseSectionID = modalButtonEl.data("question_id");
    console.log(courseSectionID);

    var questionValue = $("#input-question-"+courseSectionID).val();
    var typeValue = $("#input-type-"+courseSectionID + " option:selected").text();

    console.log(questionValue);
    console.log(typeValue);

    var tableRow = $('tr[data-tr_question_id='+courseSectionID+']').first();
    tableRow.find("span.question").html(questionValue);
    tableRow.find("span.type").html(typeValue);

    // if name value exists, then say the field exists
    if (questionValue !== undefined && questionValue.length) {
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

  function addTableItem(tableID) {
    var newIDNumber = getNumberOfTableRows(tableID) + 100000;
    console.log("new table ID with course number " + newIDNumber);

    // Clone the TR
    var trElementToClone = $(tableID + " .tr_clone").first();
    var newTRElement = trElementToClone.clone();

    $(tableID).append(newTRElement);
    // Update the data id on the course section
    newTRElement.attr("data-tr_question_id", newIDNumber);
    // Erase any existing values in name
    newTRElement.find("span.question").html("");
    // Erase any existing values in description
    newTRElement.find("span.type").html("");
    // Add the updated modal target link to the edit button
    newTRElement.find(".btn-modal-open").attr("data-target", "#question_modal_"+newIDNumber);


    // Clone the modal

    //var modalToClone = $(".question_modal").first();
    var newModalElement = newTRElement.find(".question_modal").first();

    //$(tableID).append(newModalElement);

    // Clear all inputs
    // Now change the IDs of all of the input elements
    newModalElement.find("input[name=\"questions_id[]\"]").val(""); // clear the old values
    newModalElement.find("input[name=\"questions_question[]\"]").val(""); // clear the old values
    newModalElement.find("input[name=\"questions_correct_answer[]\"]").val(""); // clear the old values
    newModalElement.find("input[name=\"questions_exists_in_post[]\"]").val(0); // clear the old values

    newModalElement.find("input[name=\"questions_id[]\"]").attr("id", "input-id-"+newIDNumber);
    newModalElement.find("input[name=\"questions_exists_in_post[]\"]").attr("id", "input-exists-"+newIDNumber);
    newModalElement.find("input[name=\"questions_question[]\"]").attr("id", "input-question-"+newIDNumber);
    newModalElement.find("input[name=\"questions_correct_answer[]\"]").attr("id", "input-correct_answer-"+newIDNumber);
    newModalElement.find("select[name=\"questions_type[]\"]").attr("id", "input-type-"+newIDNumber);

    newModalElement.attr("id", "question_modal_"+newIDNumber);
    newModalElement.attr("data-modal_question_id", newIDNumber);
    newModalElement.find(".JS_modal_save").attr("data-question_id", newIDNumber);

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
    var parentTableBody = $(parentTR).parent("tbody");
    var parentTable = $(parentTableBody).parent("table");
    var parentTableID = "#" + $(parentTable).attr("id");
    var numberOfTableRows = getNumberOfTableRows(parentTableID);
    console.log(parentTableID);
    console.log(numberOfTableRows);

    if (numberOfTableRows <= 1) {
      alert("The last table item cannot be deleted. Please modify this item instead of deleting it");
      return;
    }

    if (confirm("Are you sure that you want to delete this element?")) {
      parentTR.remove();

      // now delete the modal
      //var modalToRemove = $("#question_modal_"+rowID);
      //modalToRemove.remove();
    }
  }

  function getNumberOfTableRows(tableID) {
    return $(tableID + " .tr_clone").length;
  }

  /**
   * NOW ADD FUNCTIONALITY TO HANDLE THE ANSWERS
   */
  function addAnswersTableItem(tableID) {
    console.log(tableID);
    var newIDNumber = getNumberOfTableRows(tableID) + 200000;
    console.log("new answers table ID with course number " + newIDNumber);

    // Clone the TR
    var trElementToClone = $(tableID + " .tr_clone").first();
    console.log(trElementToClone);
    var newTRElement = trElementToClone.clone();

    $(tableID).append(newTRElement);
    // Update the data id on the course section
    newTRElement.attr("data-tr_question_id", newIDNumber);
    newTRElement.find("input[name=\"answers_id[]\"]").val(0);
    newTRElement.find("input[name=\"answers_answer[]\"]").val("");
    newTRElement.find("select[name=\"answers_is_correct[]\"]").val(0);
    // Erase any existing values in description
    // Add the updated modal target link to the edit button
    newTRElement.find(".btn-modal-open").attr("data-target", "#question_modal_"+newIDNumber);
  }

</script>
@endpush