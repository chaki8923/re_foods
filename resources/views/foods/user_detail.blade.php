@section('title', 'ユーザー詳細')
@extends('layouts.app')
@section('content')
<div id="push">
  <push-component :pertner="{{$pertner}}" food_link="{{$link}}">
  </push-component>
</div>
<div class="user-content">
  <div class="user-name">
    <div class="user-image">
      @if(!$store->store_image )
      <img src="/images/default_image.png"  alt="プロフィール画像" >
      @elseif($store->store_image == '/storage/images/ .jpeg')
      <img src="/images/default_image.png"  alt="プロフィール画像2"  style="opacity: 1;">
      @else
      <img src="{{$store->store_image}}" alt="プロフィール画像"  style="opacity: 1;">
      @endif
    </div>
    <div class="user-comment">
      @if($store->comment)
      <p>{{$store->comment}}</p>
      @else
      <p>コメントはまだ登録されていません。</p>
      @endif
    </div>
  </div>
  <table class="user-table">
    <tr>
      <th>住所</th>
      <td>{{$store->prefecture}}{{$store->city}}{{$store->address}}</td>
    </tr>
    <tr>
      <th>登録してる食材</th>
      <td><a href="{{route('pertner',$store->store_id)}}">{{$foods_num}}件</a></td>
    </tr>
    <tr>
      <th>電話番号</th>
      @if($store->tell_number)
      <td>{{$store->tell_number}}<a href="tel:{{$store->tell_nember}}" class="btn btn-info ml-5 text-white">電話をかける<i class="fas fa-phone-square tell-icon"></i></a></td>
      @else
      <td>登録されていません</td>
      @endif
    </tr>
  </table>
</div>


<footer class="footer" style="margin-bottom: 430px;">
  <ul class="footer-list">
    <li class="footer-item"><a href="{{route('about')}}" class="footer-link">RE:FOOD'sとは？</a></li>
    <li class="footer-item"><a href="{{route('privacy')}}" class="footer-link">プライバシーポリシー</a></li>
    <li class="footer-item"><a href="{{route('rule')}}" class="footer-link">利用規約</a></li>
    <li class="footer-item"><a href="{{route('legal')}}" class="footer-link">特定商法取引法</a></li>
    <li class="footer-item"><a href="{{route('contact')}}" class="footer-link">お問い合わせ</a></li>

  </ul>
</footer>


@endsection

<script src="/js/project.js" defer></script>