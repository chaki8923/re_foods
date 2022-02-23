window.Vue = require('vue');
require('./bootstrap');
$(function(){
  

//フェードスライドショー
$('.js-slide').hide();
$('.slide1').show();
let currentSlide = 1;
const slide = 3;

setInterval(function(){
  $('.slide' + currentSlide).fadeOut('slow');
  if(currentSlide == slide){
    currentSlide = 1;
  }else{
    currentSlide ++;
  }

  $('.slide' + currentSlide).fadeIn('slow');

},3000);


  if($('.flash-inner')){
    
    
    $('.flash-message').slideToggle('slow');
    setTimeout(()=>{    
      $('.flash-message').slideToggle('slow');
    },3000);
  }


    $('.item-view').find('.js-main-view').addClass('fadeIn');
    $('.js-img-current').addClass('active');

    $('.js-click-changeView').on('click',function(e){

      if(!$(this).find('.js-img').hasClass('active')){

        $path = $(this).find('.js-img').attr('src');
        $target = $(this).find('.js-img');

        $('.js-img').removeClass('active');
        $target.addClass('active');
        
        $('.item-view').find('.js-main-view').removeClass('fadeIn');
        setTimeout(function(){
          $('.item-view').find('.js-main-view').attr('src',$path);
          $('.item-view').find('.js-main-view').addClass('fadeIn');
        },400);
      }
    });

    $('.js-info-open').on('click',function(){
      $('.info-dropdown').toggleClass('active');

      $('.info-open').toggleClass('active');
    });

    $('.tab-item').first().addClass('active');
    
    $('.tab-item').on('click',function(){
      $('.tab-item').removeClass('active');
      $(this).addClass('active');
      
    });
    $('.mail-item').first().addClass('active');
    
    $('.mail-item').on('click',function(){
      $('.mail-item').removeClass('active');
      $(this).addClass('active');
      
    });

    //ローディングアイコン
    $(window).on('load', function () { //全ての読み込みが完了したら実行
      $('.js-loading').delay(800).fadeOut('fast');
    });
  
    //3秒たったら強制的にロード画面を非表示
    $(function () {
      setTimeout(stopload, 1000);
    });
  
    function stopload() {
      $('.js-loading').fadeOut();
    }
  
 
   
});

Vue.component('push-component', require('./components/push-component.vue').default);

const app5 = new Vue({
  el: '#push',

});


