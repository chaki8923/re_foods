@section('title', 'お問い合わせ')
@extends('layouts.app')
@section('content')
<form  method="POST"  action="{{route('sendmail')}}" enctype="multipart/form-data">
  <div class="Form">
    @csrf

    <div class="Form-Item">
      <label for="store_name" class="Form-Item-Label"><span class="Form-Item-Label-Required">必須</span>氏名</label>
      <input id="store_name" type="text" name="store_name" class="form-control @error('store_name') is-invalid @enderror" value="{{old('store_name')}}" placeholder="例）山田太郎">
      @error('store_name')
      <span class="invalid-feedback" role="alert">
        <strong>{{ $message }}</strong>
      </span>
      @enderror
    </div>
    <div class="Form-Item">
      <label for="email" class="Form-Item-Label"><span class="Form-Item-Label-Required">必須</span>メールアドレス</label>
      <input id="email" type="email" name="email" class="form-control @error('email') is-invalid @enderror" placeholder="例）example@gmail.com" value="{{old('email')}}">
      @error('email')
      <span class="invalid-feedback" role="alert">
        <strong>{{ $message }}</strong>
      </span>
      @enderror
    </div>
    <div class="Form-Item">
      <label for="message" class="Form-Item-Label isMsg"><span class="Form-Item-Label-Required">必須</span>お問い合わせ内容</label>
      <textarea id="message" name="message" col="40" rows="10" class="form-control @error('message') is-invalid @enderror">{{old('message')}}</textarea>
      @error('message')
      <span class="invalid-feedback" role="alert">
        <strong>{{ $message }}</strong>
      </span>
      @enderror
    </div>
    <input type="submit" class="Form-Btn" value="送信する">
  </div>
</form>

@include('layouts.footer')
<script src="/js/project.js" defer></script>
@endsection