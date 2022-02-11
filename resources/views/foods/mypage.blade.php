@extends('layouts.app')
@section('content')
<div class="mypage">
  <div id="push">
    <push-component :pertner="{{$pertner}}" food_link="{{$link}}">
    </push-component>
  </div>
  <mypage-component detail_link="{{$detail_link}}" edit_link="{{$edit_link}}" delete_link="{{$delete_link}}" :u_id="{{$u_id}}" about="{{$about_link}}" rule="{{$rule_link}}" legal="{{$legal_link}}" privacy="{{$privacy_link}}" contact="{{$contact_link}}" :categories="{{$categories}}"></mypage-component>
 
</div>
@include('layouts.loading')
@endsection
<script src="https://unpkg.com/vue-router@3.1.5/dist/vue-router.js"></script>
<script src="/js/project.js" defer></script>
<script src="/js/mypage.js" defer></script>