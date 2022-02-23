@section('title', 'RE:FOODsとは')

@extends('layouts.app')
@section('content')
<div class="main-title title">
  <p>地域密着型フードロス<br>削減サービス</p>
</div>
<div class="main-content">
  <h3 class="main-content-title title">
    RE:FOOD'sとは？
  </h3>
  <div class="main-content-inner">
    <strong>
      ”手の届く”範囲、”顔の見れる”範囲で<br>
      助け合う事の出来るサービス
    </strong>
    <div class="main-content-image">
      <img src="/images/hand.jpg" alt="" class="js-slide slide1">
      <img src="/images/radexish.jpg" alt="" class="js-slide slide2">
      <img src="/images/vegitable.jpg" alt="" class="js-slide slide3">
    </div>
    <h3 class="discription-title title">こんなサービスです</h3>
    <section class="discription">
      <h2>1、表示される食材は自分の住所の近くのユーザーのもの</h2>
      <p>コンセプトである「手の届く範囲」で助け合う。<br>これを実現させる為に表示される食材等は全て”徒歩10分以内”。実際にフードロスに困っている人に逢いに行ってやり取りをします。</p>
    </section>
    <div class="main-content-image">
      <img src="/images/safe_person.png" class="">
      
    </div>
    <section class="discription">
      <h2>2、多彩なカテゴリーに対応</h2>
      <p>大カテゴリー、サブカテゴリーとわかれており合計200種類以上の食材を登録する事が可能なため、欲しい食材がきっと見つかるはずです。</p>
    </section>
    <div class="main-content-image">
      <img src="/images/baravegi.jpg" alt="" class="js-slide slide1">
      <img src="/images/orange.jpg" alt="" class="js-slide slide2">
      <img src="/images/pan.jpg" alt="" class="js-slide slide3">
    </div>
    <section class="discription">
      <h2>3、食材を使った人気レシピを表示</h2>
      <p>楽天レシピAPIと連携しており、登録されてる食材に合わせた人気レシピ4選が表示されます。<br>
        フードロスになるはずだった食材を使って食卓を彩りましょう。
      </p>
    </section>
    <div class="main-content-image">
      <img src="/images/eggpalte.jpg" alt="" class="">
    </div>
    <section class="discription">
      <h2>4、相手のアクションがリアルタイムでわかる</h2>
      <p>自分の登録した食材を気になってる人がいたらリアルタイムでお知らせ。<br>
        そうするとその人達にメッセージを送る事が出来るようになるのでそこで
        やり取りを開始しましょう。
      </p>
    </section>
    
    
  </div>
</div>

@include('layouts.footer')
@endsection
<script src="/js/project.js" defer></script>
