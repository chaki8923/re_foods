@section('title', 'HOME')
@extends('layouts.app')
@section('content')
<!-- {{phpinfo()}} -->
<div class="new-massage-area">
  <ul class="info-list">


    @if($pertner->count() > 0 || $likes->count())
    <li class="info-item js-info-open">お知らせ<span class="info-open">▼</span></li>
    @endif
    @if(!$pertner->count() && !$likes->count())
    <li class="info-item ">お知らせはありません</li>
    @endif
    <ul class="info-dropdown">
      @foreach($pertner as $val)
      <li class="info-item">
        <a href="{{route('chat.list',$val->food_id)}}" class="info-link">{{$val->store_name}}からの新着メッセージ</a>
      </li>
      @endforeach
      @foreach($likes as $val)
      <li class="info-item">
        <a href="{{route('item_detail',$val->food_id)}}" class="info-link">1件の食材を気になってる人がいます。</a>
      </li>
      @endforeach
    </ul>
  </ul>
</div>

<div id="push">
  <push-component :pertner="{{$pertner}}" food_link="{{$link}}" :my_food_id="{{$my_food_id}}" detail_link="{{$detail_link}}">
  </push-component>
</div>
<div>
  @if($store->id == 16)
  <h3 class="text-center mt-5" style="color: #3490dc;">現在のユーザー数:{{$store->count()}}人</h3>
  @endif
  
  @if($address->address)
  @if($my_address->count())
  <h3 class="text-center mt-5" style="color: #3490dc;">あなたの近くのユーザー数:{{$my_address->count()}}人</h3>
  @else
  <h3 class="text-center mt-5" style="color: #3490dc;">あなたの近くのユーザーはまだいません。</h3>
  @endif
  @endif

  @if($address->address)
  <h2 class="text-center mt-5">ようこそ、<strong>{{$store->store_name}}</strong> <span class="small">さん</span><br>まずはどちらかを選択してください。</h2>
  @else
  <h2 class="text-center mt-5">ようこそ、<strong>{{$store->store_name}}</strong> <span class="small">さん</span><br>まずは右上のメニューの<br>会員情報変更から住所を登録してください。</h2>
  @endif

  @if($address->address)
  <div class="select-content">
    <a href="{{route('food_register_show',$store->id)}}" class="action-select register text-white text-center text-decoration-none">
      <p class="h4">ロスになりそうな食品を登録。</p>
      <img src="{{asset('images/safe2.png')}}" alt="" class="flat-image">
    </a>
    <a href="{{route('foods_show')}}" class="action-select search text-white text-center text-decoration-none">
      <p class="h4">ロスになりそうな食品を助ける。</p>
      <img src="{{asset('images/safe3.png')}}" alt="" class="flat-image">
    </a>
  </div>
  @else
  <div class="no-address">
    <img src="{{asset('images/woman.png')}}" alt="" class="flat-image w-50 mx-auto d-block mt-5">
  </div>
  @endif
</div>

@include('layouts.footer')
@include('layouts.loading')
@endsection
<!-- <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script> -->
<script src="/js/project.js" defer></script>