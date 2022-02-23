@section('title', '食材詳細')
@extends('layouts.app')
@section('content')
<div class="detail-container">
  <div id="push">
    <push-component food_link="{{$link}}" >
    </push-component>
  </div>
  <div class="item-container">
    @if($food->decision_flg)
    <img src="/storage/images/decision.gif" alt="" class="decision-img" >
    @endif
    <div id="like">
      <like-component :food="{{$food}}" :food_id="{{$food->id}}" :like_flg_check="{{$food->likes}}" :like_num="{{$likes->count()}}" :like_one="{{$like_one->count()}}" root="{{$root}}" :likes="{{$likes}}" :user_id="{{$user_id}}" like_list_link="{{$like_list_link}}" axios_path="{{$axios_path}}">
      </like-component>
    </div>
    <div class="item-view">
      <img src="/storage/images/{{$food->pic1}}" alt="" class="js-main-view">
    </div>
    <div class="item-sub-view">
      <div class="sub-view js-click-changeView">
        @if($food->pic1)
        <img src="/storage/images/{{$food->pic1}}" alt="" class="js-img js-img-current">
        @endif
      </div>
      <div class="sub-view js-click-changeView">
        @if($food->pic2)
        <img src="/storage/images/{{$food->pic2}}" alt="" class="js-img">
        @endif
      </div>
      <div class="sub-view js-click-changeView">
        @if($food->pic3)
        <img src="/storage/images/{{$food->pic3}}" alt="" class="js-img">
        @endif
      </div>
    </div>
    <div id="decision">
      @if($food->store_id == $store->id)
      <decision-component :store="{{$store}}" :food="{{$food}}" decision_link="{{$decision_link}}">
      </decision-component>
      @endif
    </div>
  </div>
  @if($food->comment)
  <div class="food-text">
    <div class="user-image">
      <img src="{{$abater->store_image}}" alt="">
      <span>{{$abater->store_name}}</span>
    </div>
    <div class="food-text-area">
      <h4>投稿者からの一言コメント</h4>
      <p>{{$food->comment}}</p>
    </div>
  </div>
  @endif

  @if($sub_category->food_name)
  <div id="resipi">
    <h2 class="resipe-title">{{$sub_category->food_name}}を使った人気レシピ４選！</h2>
    <resipi-component :parent="{{$category}}" :sub="{{$sub_category}}"></resipi-component>
  </div>
  @endif
  @include('layouts.footer')
  @include('layouts.loading')
  @endsection

  <script src="/js/project.js" defer></script>
  <script src="/js/decision.js" defer></script>
  <script src="/js/resipi.js" defer></script>