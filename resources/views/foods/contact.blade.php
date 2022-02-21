@extends('layouts.app')

@section('content')
<form action="{{route('sendmail')}}" method="post">
<div class="Form">
@csrf

<div class="Form-Item">
<p class="Form-Item-Label"><span class="Form-Item-Label-Required">必須</span>氏名</p>
<input type="text" name="name" class="Form-Item-Input" value="" placeholder="例）山田太郎">
</div>
<div class="Form-Item">
<p class="Form-Item-Label"><span class="Form-Item-Label-Required">必須</span>メールアドレス</p>
<input type="email" name="email" class="Form-Item-Input" placeholder="例）example@gmail.com">
</div>
<div class="Form-Item">
<p class="Form-Item-Label isMsg"><span class="Form-Item-Label-Required">必須</span>お問い合わせ内容</p>
<textarea name="comment" class="Form-Item-Textarea"></textarea>
</div>
<input type="submit" class="Form-Btn" value="送信する">
</div>
</form>

@include('layouts.footer')
<script src="/js/project.js" defer></script>
@endsection
