@section('title', 'HOME')
@extends('layouts.app')
@section('content')
<!-- {{phpinfo()}} -->
<div>
  <h3 class="text-center mt-5" style="color: #333;">ページが見つかりません。</h3>
  <div class="p-error__image">
    <img src="/images/404image.png" alt="" class="flat-image w-50 mx-auto d-block mt-5">
  </div>
</div>
@include('layouts.footer')
@endsection
<!-- <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script> -->
<script src="/js/project.js" defer></script>