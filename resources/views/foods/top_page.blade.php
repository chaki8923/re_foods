@extends('layouts.app')
<link rel="stylesheet" type="text/css" href="https://cdn.tutorialjinni.com/pagePiling.js/1.5.6/jquery.pagepiling.min.css" />
@section('content')
<div id="pagepiling">
  <section id="section1" class="key-view section" style="background-image: url('images/main_bc.jpg');">
    <div class="key-view--panel">
      <h2>芽吹いた命、<br>努力の手、無駄にしない<span class="fs-5">。</span></h2>
      <p>作り手、そして買い手の双方の手助けを<br class="page-text">消費者が行う</p>
      <a href="{{route('signup')}}"><button class="btn btn-light start-btn w-75">無料で始める</button></a>
      <div class="form-group row mt-2">
        <label for="name" class="col-sm-4 col-form-label text-md-right " style="color:#fff;">Googleで簡単登録</label>
        <div class="col-md-6">
          <a href="{{ url('signin/google')}}" class="btn btn-danger w-75"><i class="fa-brands fa-google"></i> Google</a>
        </div>
      </div>
    </div>
    <a href="#" class="scroll text-white" style="text-decoration: none;"><span></span>Scroll</a>
  </section>

  <section id="section2" class="about section" style="background-image: url('images/bezitable.jpg');">
    <span class="get-parent"></span>
    <div class="panel index2">
      <h2 class="panel-title">RE:FOOD'sとは？</h2>
      <div class="panel-body">
        <p>地域を限定して飲食店同士や飲食店と顧客が<br>繋がる事の出来るサービス。
          <br>飲食店などのフードロスを防ぎ、<br>
          それを必要とする人達と共有する手助けをします。
        </p>
      </div>
    </div>
    <a href="#" class="scroll text-white" style="text-decoration: none;"><span></span>Scroll</a>
  </section>

  <section id="section3" class="merit section" style="background-image: url('images/mugi.jpg');">
    <div class="panel index3">
      <h2 class="panel-title">どんな価値があるか？</h2>
      <div class="panel-body">
        <p>もちろんフードロスを防ぐ事は<br>重要ではありますがそれはあくまで「手段」。<br>
          目的は食材のやり取りを通した<br>地域のコミュニティの活性化です。
        </p>
      </div>
    </div>
    <a href="#" class="scroll text-white" style="text-decoration: none;"><span></span>Scroll</a>
  </section>

  <section id="section4" class="howto section" style="background-image: url('images/seep.jpg');">
    <div class="panel index4">
      <h2 class="panel-title">誰でもすぐ始められます</h2>
      <div class="panel-body">
        <p>自分のお店の情報を登録すれば、<br>
          誰でも無料ですぐに始められます。</p>
      </div>
    </div>
    <a href="#" class="scroll text-white" style="text-decoration: none;"><span></span>Scroll</a>
  </section>

  <section id="section5" class="start section" style="background-image: url('images/peaceful.jpg');">
    <div class="panel index5">
      <h2 class="panel-title">手の届く範囲で助け合えば<br>良いじゃない。</h2>
      <div class="panel-body text-center">
        <a href="{{route('signup')}}"><button class="btn btn-light start-btn w-75 m-auto">無料で始める</button></a>
        </p>
      </div>
      <div class="form-group row mt-2">
        <label for="name" class="col-sm-4 col-form-label text-md-right " style="color:#fff;">Googleで簡単登録</label>
        <div class="col-md-6">
          <a href="{{ url('signin/google')}}" class="btn btn-danger w-75"><i class="fa-brands fa-google"></i> Google</a>
        </div>
      </div>
    </div>
  </section>
  @endsection
  <script src="https://cdn.jsdelivr.net/npm/vue@2.5.17/dist/vue.min.js"></script>
  <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
  <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.0/js/bootstrap.min.js"></script>
  <script src="https://cdn.tutorialjinni.com/pagePiling.js/1.5.6/jquery.pagepiling.min.js"></script>
  <script src="/js/main.js" defer></script>
  @include('layouts.footer')