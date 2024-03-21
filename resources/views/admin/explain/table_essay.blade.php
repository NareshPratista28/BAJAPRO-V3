<div class="table-responsive">
    <table class="table" id="courses-table">
        <thead>
            <tr>
                <th>Name</th>
                <th>Content</th>
                <th>Question</th>
                <th>User Answer</th>
                <th>Answer Key</th>
                <th>Score</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($explain as $data)
                @php
                    $explaining = \App\Models\ExplainingScore::where('user_answer_id', $data->id)->first();
                @endphp
                <tr>
                    <td>{{ $data->user->name }}</td>
                    <td>{{ $data->essay->questions->content->title }}</td>
                    <td>{!! $data->essay->question !!}</td>
                    <td>{{ $data->answer }}</td>
                    <td>{{ $data->essay->answer }}</td>
                    <td>
                      @if($explaining?->konteks_penjelasan)
                          {{ $explaining?->konteks_penjelasan }}
                      @elseif($explaining?->keruntutan)
                          {{ $explaining?->keruntutan }}
                      @elseif($explaining?->kebenaran)
                          {{ $explaining?->kebenaran }}
                      @else
                          Not Scored
                      @endif
                  </td>
</div>
</td>
</tr>
@endforeach
</tbody>
</table>
</div>
