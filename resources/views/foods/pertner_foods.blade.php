@extends('layouts.app')
@section('content')
<div class="container">
<div id="push">
  <push-component   food_link="{{$link}}">
  </push-component>
</div>

<div class="row  justify-content-center">
  @foreach($foods as $food)
  <div class="sp col-xl-3 col-lg-5 col-md-5 mb-5 mt-5 p-0 col-xs-1"> 
    <a href="{{route('item_list',$food->category_id)}}" class="card" >
      <div class="card-header d-flex justify-content-between">{{$food->category_name}} <span>{{$food->count_cat}}件</span></div>
      <div class="card-body category-card-body" style="height:215px;">
        <img src="/images/{{$food->category_image}}" alt="画像" width="100%">
      </div>
    </a>
  </div>

  @endforeach
</div>
</div>
@include('layouts.footer')
@endsection
<script src="/js/project.js" defer></script>