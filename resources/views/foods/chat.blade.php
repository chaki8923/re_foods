@section('title', 'チャット')
@extends('layouts.app')
@section('content')
  <div id="chat">
  <chat-component :food_id="{{$food->id}}" :messages="{{$messages}}" :mypic="{{$my}}" :pertner="{{$pertner}}" :food="{{$food}}" axios_path={{$axios_path}} ></chat-component>

    @error('message')
    <strong>{{ $message }}</strong>
    @enderror
  </div>
@endsection
<script src="/js/chat.js" defer></script>

