@extends('layouts.app')
@section('content')
<div class="container">
  <div id="push">
    <push-component :pertner="{{$pertner}}" food_link="{{$link}}">
    </push-component>
  </div>
<search-component :stores="{{$stores}}" detail_link="{{$detail_link}}" edit_link="{{$edit_link}}" :u_id="{{$u_id}}" :sub_cat="{{$sub_cat}}" :cat_id="{{$cat_id}}" about="{{$about_link}}" rule="{{$rule_link}}" legal="{{$legal_link}}" privacy="{{$privacy_link}}" contact="{{$contact_link}}"></search-component>
  
</div>

@include('layouts.loading')
@endsection

<script src="/js/project.js" defer></script>
<script src="/js/search.js" defer></script>