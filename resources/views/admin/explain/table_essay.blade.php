<div class="table-responsive">
  <table class="table" id="courses-table">
    <thead>
      <tr>
        <th>Name</th>
        <th>Content</th>
        <th>Question</th>
        <th>User Answer</th>
        <th>Answer Key</th>
      </tr>
    </thead>
    <tbody>
      @foreach ($explain as $data)
        <tr>
            <td>{{$data->user->name}}</td>
            <td>{{$data->essay->questions->content->title}}</td>
            <td>{!! $data->essay->question !!}</td>
            <td>{{$data->answer}}</td>
            <td>{{$data->essay->answer}}</td>
            </div>
          </td>
        </tr>
      @endforeach
    </tbody>
  </table>
</div>
