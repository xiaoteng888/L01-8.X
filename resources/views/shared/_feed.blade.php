@if ($statuses->count() > 0)
  <ul class="list-unstyled">
    @foreach ($statuses as $status)
      @include('statuses._status',  ['user' => $status->user])
    @endforeach
  </ul>
  <div class="mt-5">
    {!! $statuses->render() !!}
  </div>
@else
  <p>没有数据！</p>
@endif
