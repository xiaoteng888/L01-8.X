@extends('layouts.default')
@section('title', $user->name)

@section('content')
  <div class="row">
    <div class="offset-md-2 col-md-8">
      <div class="col-md-12">
        <div class="offset-md-2 col-md-8">
          <section class="user_info">
           @include('shared._user_info', ['user'=> $user])
          </section>
          @if(Auth::check())
            @include('users._follow_form')
          @endif
          <section class="stats mt-2">
            @include('shared._stats')
          </section>
          <section class="status">
            {{--@if($statuses->count() > 0)
              <ul class="list-unstyled">
                @foreach($statuses as $status)
                  @include('statuses._status', ['user'=>$user,'status'=>$status])
                @endforeach
              </ul>
              <div class="mt-5">
                {!! $statuses->render() !!}
              </div>
            @else
              <p>没有数据!</p>
            @endif--}}
            @include('shared._feed')
          </section>
        </div>
      </div>
     </div>
  </div>
@stop
