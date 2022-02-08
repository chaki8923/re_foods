
$(function(){

  $('.delete-image').on('click',function(){
    $('#image-output').attr('src', '');
    $('.prview-inner').css('opacity',0);
    $('.image').attr('src', '');
    
  });

  $('.dropdown-toggle').on('click',()=>{

    
    $('.dropdown-menu').show();
    
  });

  $(window).on('click',function(e){
    if(!$(e.target).closest('.dropdown-toggle').length){
      $('.dropdown-menu').removeClass('show');
    }
  });
  
});

//==============================ページスクロール========================================
$(function() {
  $('#pagepiling').pagepiling({
      menu: '#nav',
      sectionSelector: '.section',
      sectionsColor: [''],
      scrollingSpeed: 500,
      anchors: ['page1', 'page2', 'page3', 'page4','page5'],
      navigation: {
          'textColor': '#000',
          'bulletsColor': '#000',
          'position': 'right',
          'tooltips': ['page1', 'page2', 'page3', 'page4','page5']
      },
      afterLoad: function(anchorLink, index){
        //using index
        if(index == 2){
          $('.index2').addClass('slideup');
          $('.index3').removeClass('slideup');
          $('.index4').removeClass('slideup');
          $('.index5').removeClass('slideup');
        }
        if(index == 3){
          $('.index2').removeClass('slideup');
          $('.index3').addClass('slideup');
          $('.index4').removeClass('slideup');
          $('.index5').removeClass('slideup');
        }
        if(index == 4){
          $('.index2').removeClass('slideup');
          $('.index3').removeClass('slideup');
          $('.index4').addClass('slideup');
          $('.index5').removeClass('slideup');
        }
        if(index == 5){
          $('.index2').removeClass('slideup');
          $('.index3').removeClass('slideup');
          $('.index4').removeClass('slideup');
          $('.index5').addClass('slideup');
        }
        
      
      }
  });
});
//======================================================================