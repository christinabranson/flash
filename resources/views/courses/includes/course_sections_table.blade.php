<table id="course_sections_table" class="table">
    <thead>
    <tr>
        <th>Name</th>
        <th>Description</th>
        <th class="text-right">Actions</th>
    </tr>
    </thead>
    <tbody>
    @if(count($model->sections))
        @foreach($model->sections as $section)
            <tr data-course_section_id="{{ $section->id }}">
                @include('courses.includes.course_section_modal', ['section' => $section])
                <td>{{ $section->name }}</td>
                <td>{{ $section->description }}</td>
                <td class="td-actions text-right">
                    <button type="button" rel="tooltip" class="btn btn-info">
                        <i class="material-icons">person</i>
                    </button>
                    <button type="button" rel="tooltip" class="btn btn-success">
                        <i class="material-icons">edit</i>
                    </button>
                    <button type="button" rel="tooltip" class="btn btn-danger" onclick="deleteThisItem(this)">
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
        <tr data-tr_course_section_id="{{ $section->id }}">
            @include('courses.includes.course_sections_modal', ['section' => $section])
            <td><span class="name">{{ $section->name }}</span></td>
            <td><span class="description">{{ $section->description }}v</td>
            <td class="td-actions text-right">
                <button type="button" rel="tooltip" class="btn btn-success" data-toggle="modal" data-target="#course_section_modal_{{ $section->id }}">
                    <i class="material-icons">edit</i>
                </button>
            </td>
        </tr>
    @endif
    </tbody>
</table>
<input type="button" onclick="addTableItem()" class="btn btn-sm btn-secondary" value="+ Add Item" />