<table id="course_sections_table" class="table">
    <thead>
    <tr>
        <th>Name</th>
        <th>Questions</th>
        <th class="text-right">Actions</th>
    </tr>
    </thead>
    <tbody id="sortable">
    @if(count($sections))
        @foreach($sections as $section)
            <tr class="tr_clone" data-tr_course_section_id="{{ $section->id }}">
                <td><span class="name">{{ $section->name }}</span></td>
                <td><span class="description">{{ $section->questions()->count() }}</span></td>
                <td class="td-actions text-right">

                    <a type="button" rel="tooltip" class="btn btn-success" href="{{ route("courses.manage_section_questions", $section) }}">
                        <i class="material-icons">edit</i>
                        Manage Questions
                    </a>
                </td>
            </tr>
        @endforeach
    @endif
    </tbody>
</table>