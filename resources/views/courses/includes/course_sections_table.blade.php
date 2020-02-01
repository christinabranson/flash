<table id="course_sections_table" class="table">
    <thead>
    <tr>
        <th>Name</th>
        <th>Description</th>
        <th class="text-right">Actions</th>
    </tr>
    </thead>
    <tbody id="sortable">
    @php($sections = $model->getChildAttributes("sections"))
    @if(count($sections))
        @foreach($sections as $section)
            <tr class="tr_clone" data-tr_course_section_id="{{ $section->id }}">
                <td><span class="name">{{ $section->name }}</span></td>
                <td><span class="description">{{ $section->description }}</span></td>
                <td class="td-actions text-right">
                    @include('courses.includes.course_sections_modal', ['section' => $section])


                    <button type="button" rel="tooltip" class="btn btn-success btn-modal-open" data-toggle="modal" data-target="#course_section_modal_{{ $section->id }}">
                        <i class="material-icons">edit</i>
                    </button>
                    <button type="button" rel="tooltip" class="btn btn-danger btn-modal-open" onclick="deleteThisItem(this)">
                        <i class="material-icons">delete</i>
                    </button>
                </td>
            </tr>
        @endforeach
    @else
        @php($section = new stdClass())
        @php($section->exists = false)
        @php($section->id = 0)
        @php($section->displayorder = 1)
        @php($section->name = "")
        @php($section->description = "")
        <tr class="tr_clone" data-tr_course_section_id="{{ $section->id }}">
            <td><span class="name">{{ $section->name }}</span></td>
            <td><span class="description">{{ $section->description }}</span></td>
            <td class="td-actions text-right">
                @include('courses.includes.course_sections_modal', ['section' => $section])

                <button type="button" rel="tooltip" class="btn btn-success btn-modal-open" data-toggle="modal" data-target="#course_section_modal_{{ $section->id }}">
                    <i class="material-icons">edit</i>
                </button>
                <button type="button" rel="tooltip" class="btn btn-danger btn-modal-open" onclick="deleteThisItem(this)">
                    <i class="material-icons">delete</i>
                </button>
            </td>
        </tr>
    @endif
    </tbody>
</table>
<input type="button" onclick="addTableItem()" class="btn btn-sm btn-secondary" value="+ Add Item" />