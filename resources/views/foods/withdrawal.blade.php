@section('title', '退会')
@extends('layouts.app')
@section('content')
<h2 class="text-center mt-5">退会してよろしいですか？</h2>
<form id="logout-form" action="{{ route('drawal') }}" method="POST">
  @csrf
  <button class="btn btn-dark mx-auto mt-5 d-block">退会する</button>
</form>

<footer class="footer" style="margin-bottom: 430px;">
  <ul class="footer-list">
    <li class="footer-item"><a href="{{route('about')}}" class="footer-link">RE:FOOD'sとは？</a></li>
    <li class="footer-item"><a href="{{route('privacy')}}" class="footer-link">プライバシーポリシー</a></li>
    <li class="footer-item"><a href="{{route('rule')}}" class="footer-link">利用規約</a></li>
    <li class="footer-item"><a href="{{route('legal')}}" class="footer-link">特定商法取引法</a></li>
    <li class="footer-item"><a href="" class="footer-link">お問い合わせ</a></li>

  </ul>
</footer>


@endsection

<script src="/js/project.js" defer></script>