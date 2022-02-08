
$(function(){
  
    if($('.flash-inner')){
      
      
      $('.flash-message').slideToggle('slow');
      setTimeout(()=>{    
        $('.flash-message').slideToggle('slow');
      },3000);
    }
  
      for(let i = 1;i <= 3;i ++){
  
        $(`.pic-preview${i}`).on('click',function(){
          
          $(`.input-file${i}`).click();
          
        });
        $(`.input-file${i}`).on('change',function(e){
          let reader = new FileReader();
          reader.onload = function(e){
            $(`.js-preview${i}`).attr('src',e.target.result);
            $(`.js-preview${i}`).css('opacity',1);
          }
          reader.readAsDataURL(e.target.files[0]);
        });
      }
  
      $('.image-clear').on('click',function(e){
        e.stopPropagation();
        $(this).closest('.preview-area').prev('.file-area').val('');
        $(this).next().attr('src','');
        $(this).next().css('opacity',0);
  
      });
  
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
   
   
  });


Vue.component('resipi-component', require('./components/resipi.vue').default);

const app = new Vue({
    el: '#resipi',
});


Vue.component('like-component', require('./components/like.vue').default);

const app2 = new Vue({
    el: '#like',
});