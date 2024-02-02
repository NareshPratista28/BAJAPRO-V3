<div class="table-responsive">
  <table class="table" id="courses-table">
    <thead>
      <tr>
        <th>Name</th>
        @if($title == "summary")
            <th>Level</th>
        @else
            <th>Content</th>
        @endif
        <th>Description</th>
        <th colspan="3">Action</th>
      </tr>
    </thead>
    <tbody>
      @foreach ($explain as $explain)
        <tr>
          <td>{{ $explain->users->name }}</td>
          @if($title == "summary")
              <td>{{$explain->level->name}}</td>
          @else
              <td>{{$explain->question->content->title}}</td>
          @endif
          <td>{!! @$explain->description !!}</td>
          <td class=" text-center">
            <div class='btn-group'>
            @if($title == "summary")
              <a href="{!! route('admin.explaination.edit', [$explain->id]) !!}" class='btn btn-warning action-btn edit-btn'><i
                  class="fa fa-edit"></i></a>
            @else
              <a href="{!! route('admin.code.edit.explanation', [$explain->id]) !!}" class='btn btn-warning action-btn edit-btn'><i
                  class="fa fa-edit"></i></a>
            @endif
            </div>
          </td>
        </tr>
      @endforeach
    </tbody>
  </table>
</div>
