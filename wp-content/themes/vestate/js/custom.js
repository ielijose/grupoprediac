var $ = jQuery;
jQuery(document).ready(function ($) {
  
      $('.menu-item').has('.sub-menu').each(function(){
          if($(this).find('.megadrop').length > 0 ){
              
        }else{
            $(this).addClass('hasmenu');
        }
      });
      
      
      
          
});


    var mfwcc6=6;
    var mfwcc5=5;    
    var mfwcc4=4;
    var mfwcc3=3;
    var msp9cc4=4;
    var msp9cc3=3;
    var msp8cc4=4;
    var msp8cc3=3;
    var msp6cc4=4;
    var msp6cc3=3;
    var margin=20;

jQuery(document).ready(function ($) {

// Thumbnail Carousels
if(jQuery(window).width() < 960 && jQuery(window).width() > 768){
        mfwcc6=4;
        mfwcc5=4;
        mfwcc4=4;
        mfwcc3=3;
        msp9cc4=4;
        msp9cc3=3;
        msp8cc4=3;
        msp8cc3=3;
        msp6cc4=3;
        msp6cc3=3;
        margin=20;
   }
   if(jQuery(window).width() <= 768){
        mfwcc6=2;
        mfwcc5=2;
        mfwcc4=1;
        mfwcc3=1;
        msp9cc4=1;
        msp9cc3=1;
        msp8cc4=1;
        msp8cc3=1;
        msp6cc4=1;
        msp6cc3=1;
        margin=20;
   }
   
});

function isElementInViewport(el) {
    var rect = el.getBoundingClientRect();

    return (
        rect.top >= 0 &&
        rect.left >= 0 &&
        rect.bottom <= (window.innerHeight || document. documentElement.clientHeight) && /*or $(window).height() */
        rect.right <= (window.innerWidth || document. documentElement.clientWidth) /*or $(window).width() */
        );
}

 
;(function($) {
  $.expr[":"].onScreen = function(elem) {
    var $window = $(window)
    var viewport_top = $window.scrollTop()
    var viewport_height = $window.height()
    var viewport_bottom = viewport_top + viewport_height
    var $elem = $(elem)
    var top = $elem.offset().top
    var height = $elem.height()
    var bottom = top + height

    return (top >= viewport_top && top < viewport_bottom) ||
           (bottom > viewport_top && bottom <= viewport_bottom) ||
           (height > viewport_height && top <= viewport_top && bottom >= viewport_bottom)
  }
})(jQuery);



jQuery(document).ready(function ($) {
    
   $('.header_sidebar_hook').click(function(){
           $('.header_top').toggleClass('show'); 
           $(this).toggleClass('show'); 

   });
   
       
       $('.navsearch i').click(function(){
          $('.navsearch #search').toggleClass('active'); 
       });

   
   $('section.main').each(function(){ 
       var editor=$(this).find('.span12 .vibe_editor');
       
            if(editor.length > 0){
                if(!$.trim( $(this).find('.span12 .vibe_editor').html()).length){
                    $(this).hide();
                    }   
                } 

      if($(this).find(".content").length){
          $(this).show();
       }
   });
   
    
     $('.knob').each(function(){
         var $this = $(this).find('.dial');
        var myVal = $this.val();
        $this.knob({

       });
         $({
           value: 0
       }).animate({

           value: myVal
       }, {
           duration: 2400,
           easing: 'swing',
           step: function () {
               $this.val(Math.ceil(this.value)).trigger('change');

           }
       })
     });
});


jQuery(document).ready(function ($) {
     $('body').tooltip({
        selector: '[data-rel=tooltip]',
        placement: $(this).attr('data-placement')
    }); 
    
    //$('.date-picker').jdPicker();
    
    $('section.stripe').each(function(){
        var style = $(this).find('.v_column.stripe_container .v_module').attr('data-class');
        if(style){style='stripe '+style;
            $(this).find('.v_column.stripe .v_module').removeAttr('data-class');
            $(this).attr('class',style);
        }
        var style = $(this).find('.v_column.stripe .v_module').attr('data-class');
        if(style){style='stripe '+style;
            $(this).find('.v_column.stripe .v_module').removeAttr('data-class');
            $(this).attr('class',style);
        }
    });
    
    $('.v_module').each(function(){
        var attr = $(this).attr('data-class');
        if (typeof attr !== 'undefined' && attr !== false) {
            if($(this).parent().hasClass('v_column')){
                var pclass=$(this).parent().attr('class');
                pclass= pclass+' '+attr;
            $(this).parent().attr('class',pclass);
            }
            $(this).removeAttr('data-class');
        }
    });
    
    $('.checkout_steps li').click(function(){
       var index= $(this).index();
       if(index < ($('.checkout_steps li').length-1) && index > 0){
            $('.step').fadeOut(200);
            $('.step.step'+index).fadeIn(200);
            $('.checkout_steps').find('.active').removeClass('active');
            $('.checkout_steps li:lt('+index+')').addClass('active');
            $(this).addClass('active');
       }
    });
    
    $('.proceed .btn').live("click", function () {
        var index=$(this).attr('rel');
            $('.step').fadeOut(200);
            $('.step.step'+index).fadeIn(200);
            $('.checkout_steps').find('.active').removeClass('active');
            $('.checkout_steps li:lt('+index+')').addClass('active');
            $('.checkout_steps li:eq('+index+')').addClass('active');
    });
});


jQuery(document).ready(function ($) {
    $('#show_register').click(function(e){
       //e.preventDefault();
       $('.logintab').fadeOut();
        $('.registertab').fadeIn();
    });
    $('#show_login').click(function(e){
       //e.preventDefault();
       $('.registertab').fadeOut();
        $('.logintab').fadeIn();
    });

    $('#ajax_taxonomy').on('change_tabs',function(){
       var tabslug=$(this).find('.active a').attr('href');

        $.ajax({
                type: "POST",
                url: ajaxurl,
                data: {   action: 'update_search_selects', 
                          tax: $('.advanced_listing_search').attr('data-tax'),
                          slug: tabslug,
                          sort: $('.advanced_listing_search').attr('data-sort'),
                          sortby: $('.advanced_listing_search').attr('data-sortby'),
                          count: $('.advanced_listing_search').attr('data-count'),
                      },
                cache: false,
                success: function (html) {
                    $('.search_select').fadeOut("fast");
                    $('.search_select').remove();
                    $('.search_select').fadeIn("fast");
                    $('#submit_advanced_search').before(html);
                    $('select').chosen({disable_search_threshold: 10});
                }
            });
    });

});


jQuery(document).ready(function ($) { 

    $('.list-inline').imagesLoaded( function(){ 
          $(this).removeClass('loading');
    });
    
    $( 'body' ).delegate( '.nav-tabs a', 'click', function(e){
        e.preventDefault();
        $(this).tab('show');
        $(this).closest('.nav-tabs').trigger('change_tabs');
        });
    
$('.nav-tabs a').on('shown', function (e) {
    var tab=$(this).attr('href');
    $('.hidden-tab').find('input[type="radio"]').removeAttr('checked');
    $(tab).find('input[type="radio"]').attr('checked', 'checked') // activated tab
})

$('.nav-tabs').each(function(){
    if(!$(this).find('li').hasClass('active')){
        $(this).find('a:first').tab('show');
        $(this).find('li:first').addClass('active');
    }
}); 
 
  $('.currency_conversion a').click(function(event){
    event.preventDefault();
    var $this = $(this);

    if($(this).hasClass('active')) return false;

    $('.currency_conversion').find('.active').removeClass('active');
    $this.addClass('active');

    var conversion = parseFloat($(this).attr('data-conversion'));
    if(conversion == 1){
        var $cls = $this.find('i').attr('class');
        $('.currency').each(function(){
             $(this).html('<i class="'+$cls+'"></i> '+$(this).attr('data-base'));
        });
    }else{
      var $cls = $this.find('i').attr('class');
      $('.currency').each(function(){
          
        

          var val= parseInt($(this).text());
          var newval = '<i class="'+$cls+'"></i> '+Math.round(val*conversion);

          $(this).attr('data-base',val);
          $(this).html(newval);
      });
      
    }
  });
});


jQuery(window).load(function ($) { 


jQuery('.grid.masonry').each(function($){

var $container = jQuery(this);
$container.imagesLoaded( function(){ 
    var width= parseInt($container.attr('data-width'));
     var gutter= parseInt($container.attr('data-gutter'));

    $container.masonry({
                    itemSelector: '.grid-item',
                    columnWidth: width,
                    gutterWidth: gutter,
                    isAnimated: true
            });
        });
    });
});

jQuery(document).ready(function ($) {    
if($('.fit_video').length)
$(".fit_video").fitVids();
    
$('.toparrow').click(function(event){ 		   
      event.preventDefault();
      $('body,html').animate({
      				scrollTop: 0
      			}, 800);
      			return false;
      });
});

jQuery(document).ready(function ($) {
 $('body').tooltip({
     selector: '[data-rel=tooltip]',
     placement: $(this).attr('data-placement')
 });  


    $('select').chosen({disable_search_threshold: 10});

    $('.checkout_steps li').click(function(){
       var index= $(this).index();
       if(index < ($('.checkout_steps li').length-1) && index > 0){
            $('.step').fadeOut(200);
            $('.step.step'+index).fadeIn(200);
            $('.checkout_steps').find('.active').removeClass('active');
            $('.checkout_steps li:lt('+index+')').addClass('active');
            $(this).addClass('active');
       }
    });
    
    $('.proceed .btn').live("click", function () {
        var index=$(this).attr('rel');
            $('.step').fadeOut(200);
            $('.step.step'+index).fadeIn(200);
            $('.checkout_steps').find('.active').removeClass('active');
            $('.checkout_steps li:lt('+index+')').addClass('active');
            $('.checkout_steps li:eq('+index+')').addClass('active');
    });
    
 });
 
jQuery(window).load(function ($) {
    var $ = jQuery;

/*=== CAROUSELs ===*/

$('.fullwidth .carousel_columns2').each(function(){
    var $this = $(this);
    var fwcc2={
    animation: "slide",
    controlNav: true,
    directionNav: false,
    animationLoop: false,
    slideshow: false,
    itemWidth: 560,
    maxItems: 2,
    minItems: 2,
    itemMargin: margin,
    prevText: "<i class='icon-left-open-mini'></i>",
    nextText: "<i class='icon-right-open-mini'></i>",
     start: function() {
               $this.removeClass('loading');
           }    
    };
    if($('.fullwidth .carousel_columns2').length > 0){
        var custom=eval('op'+$('.fullwidth .carousel_columns2').attr('id')); 
        $.extend(fwcc2,custom); 
        $('.fullwidth .carousel_columns2').flexslider(fwcc2);
    }  
});



$('.span3 .carousel_columns2').each(function(){
    var $this = $(this);
var sp3cc2={
    animation: "slide",
    controlNav: true,
    directionNav: false,
    animationLoop: false,
    slideshow: false,
    itemWidth: 110,
    maxItems: 2,
    minItems: 1,
    itemMargin: margin,
    prevText: "<i class='icon-left-open-mini'></i>",
    nextText: "<i class='icon-right-open-mini'></i>",
    start: function() {
               $this.removeClass('loading');
           } 
  };
  
    var custom=eval('op'+$('.span3 .carousel_columns2').attr('id')); 
    $.extend(sp3cc2,custom); 
    $this.flexslider(sp3cc2); 
});


$('.span4 .carousel_columns2').each(function(){
    var $this = $(this);
var sp4cc2={
    animation: "slide",
    controlNav: true,
    directionNav: false,
    animationLoop: false,
    slideshow: false,
    itemWidth: 171,
    itemMargin:30,
    maxItems: 2,
    minItems: 1,
    itemMargin: margin,
    prevText: "<i class='icon-left-open-mini'></i>",
    nextText: "<i class='icon-right-open-mini'></i>",
    start: function() {
               $this.removeClass('loading');
           } 
  };
  
var custom=eval('op'+$this.attr('id')); 
$.extend(sp4cc2,custom); 
$this.flexslider(sp4cc2);
});


$('.span6 .carousel_columns2').each(function(){
    var $this = $(this);
var sp6cc2={
    animation: "slide",
    controlNav: true,
    directionNav: false,
    animationLoop: false,
    slideshow: false,
    itemWidth: 255,
    maxItems: 2,
    minItems: 2,
    itemMargin: margin,
    prevText: "<i class='icon-left-open-mini'></i>",
    nextText: "<i class='icon-right-open-mini'></i>",
    start: function() {
               $this.removeClass('loading');
           }
  };

var custom=eval('op'+$this.attr('id')); 
$.extend(sp6cc2,custom); 
$this.flexslider(sp6cc2);

});

$('.span8 .carousel_columns2').each(function(){
    var $this = $(this);
var sp8cc2={
    animation: "slide",
    controlNav: true,
    directionNav: false,
    animationLoop: false,
    slideshow: false,
    itemWidth: 360,
    maxItems: 2,
    minItems: 2,
    itemMargin: margin,
    prevText: "<i class='icon-left-open-mini'></i>",
    nextText: "<i class='icon-right-open-mini'></i>",
     start: function() {
               $this.removeClass('loading');
           }
  };
 
  var custom=eval('op'+$this.attr('id')); 
$.extend(sp8cc2,custom); 
$this.flexslider(sp8cc2);
});
   

$('.span9 .carousel_columns2').each(function(){
    var $this = $(this);
var sp9cc2={
    animation: "slide",
    controlNav: true,
    directionNav: false,
    animationLoop: false,
    slideshow: false,
    itemWidth: 420,
    itemMargin:30,
    maxItems: 2,
    minItems: 2,
    itemMargin: margin,
    prevText: "<i class='icon-left-open-mini'></i>",
    nextText: "<i class='icon-right-open-mini'></i>",
    start: function() {
               $this.removeClass('loading');
           }
    
  };
var custom=eval('op'+$this.attr('id')); 
$.extend(sp9cc2,custom);   
$this.flexslider(sp9cc2);  
});

$('.fullwidth .carousel_columns3').each(function(){
    var $this = $(this);
var fwcc3={
    animation: "slide",
    controlNav: true,
    directionNav: false,
    animationLoop: false,
    slideshow: false,
    itemWidth: 370,
    maxItems: 3,
    minItems: mfwcc3,
    itemMargin: margin,
    prevText: "<i class='icon-left-open-mini'></i>",
    nextText: "<i class='icon-right-open-mini'></i>",
    start: function() {
               $this.removeClass('loading');
           }
  };

var custom=eval('op'+$this.attr('id')); 
$.extend(fwcc3,custom); 
$this.flexslider(fwcc3);
});

$('.span4 .carousel_columns3').each(function(){
    var $this = $(this);
var sp4cc3={
    animation: "slide",
    controlNav: true,
    directionNav: false,
    animationLoop: false,
    slideshow: false,
    itemWidth: 100,
    itemMargin:30,
    maxItems: 3,
    minItems: 1,
    itemMargin: margin,
    prevText: "<i class='icon-left-open-mini'></i>",
    nextText: "<i class='icon-right-open-mini'></i>",
    start: function() {
               $this.removeClass('loading');
           }
  };
var custom=eval('op'+$this.attr('id')); 
$.extend(sp4cc3,custom); 
$this.flexslider(sp4cc3);
});

$('.span6 .carousel_columns3').each(function(){
    var $this = $(this);
var sp6cc3={
    animation: "slide",
    controlNav: true,
    directionNav: false,
    animationLoop: false,
    slideshow: false,
    itemWidth: 160,
    maxItems: 3,
    minItems: msp6cc3,
    itemMargin: margin,
    prevText: "<i class='icon-left-open-mini'></i>",
    nextText: "<i class='icon-right-open-mini'></i>",
    start: function() {
               $this.removeClass('loading');
           }
  };
var custom=eval('op'+$this.attr('id')); 
$.extend(sp6cc3,custom); 
$this.flexslider(sp6cc3);

});

$('.span8 .carousel_columns3').each(function(){
    var $this = $(this);
var sp8cc3={
    animation: "slide",
    controlNav: true,
    directionNav: false,
    animationLoop: false,
    slideshow: false,
    itemWidth: 236,
    maxItems: 3,
    minItems: msp8cc3,
    itemMargin: margin,
    prevText: "<i class='icon-left-open-mini'></i>",
    nextText: "<i class='icon-right-open-mini'></i>",
    start: function() {
               $this.removeClass('loading');
           }
  };
   
var custom=eval('op'+$this.attr('id')); 
$.extend(sp8cc3,custom); 

  $this.flexslider(sp8cc3);
});

$('.span9 .carousel_columns3').each(function(){
    var $this = $(this);
  var sp9cc3={
    animation: "slide",
    controlNav: true,
    directionNav: false,
    animationLoop: false,
    slideshow: false,
    itemWidth: 270,
    maxItems: 3,
    minItems: msp9cc3,
    itemMargin: margin,
    prevText: "<i class='icon-left-open-mini'></i>",
    nextText: "<i class='icon-right-open-mini'></i>",
    start: function() {
               $this.removeClass('loading');
           }
  };
  
var custom=eval('op'+$this.attr('id')); 
$.extend(sp9cc3,custom); 

  $this.flexslider(sp9cc3);
});

$('.fullwidth .carousel_columns4').each(function(){
var $this=$(this);

var fwcc4={
    animation: "slide",
    controlNav: true,
    directionNav: false,
    animationLoop: false,
    slideshow: false,
    itemWidth: 270,
    maxItems: 4,
    minItems: mfwcc4,
    itemMargin: margin,
    prevText: "<i class='icon-left-open-mini'></i>",
    nextText: "<i class='icon-right-open-mini'></i>",
    start: function() {
               $this.removeClass('loading');
           }
  }; 
var custom=eval('op'+$this.attr('id')); 
$.extend(fwcc4,custom); 
$this.flexslider(fwcc4); 
});

$('.span4 .carousel_columns4').each(function(){
var $this=$(this);
var sp4cc4={
    animation: "slide",
    controlNav: true,
    directionNav: false,
    animationLoop: false,
    slideshow: false,
    itemWidth: 170,
    maxItems: 2,
    minItems: 2,
    itemMargin: margin,
    prevText: "<i class='icon-left-open-mini'></i>",
    nextText: "<i class='icon-right-open-mini'></i>",
    start: function() {
               $this.removeClass('loading');
           }
  };
    
var custom=eval('op'+$this.attr('id')); 
$.extend(sp4cc4,custom);   
$this.flexslider(sp4cc4);
});

$('.span6 .carousel_columns4').each(function(){
var $this=$(this);
var sp6cc4={
    animation: "slide",
    controlNav: true,
    directionNav: false,
    animationLoop: false,
    slideshow: false,
    itemWidth: 120,
    maxItems: 4,
    minItems: msp6cc4,
    itemMargin: margin,
    prevText: "<i class='icon-left-open-mini'></i>",
    nextText: "<i class='icon-right-open-mini'></i>",
    start: function() {
               $this.removeClass('loading');
           }
  };

var custom=eval('op'+$this.attr('id')); 
$.extend(sp6cc4,custom); 
$this.flexslider(sp6cc4);  
});

$('.span8 .carousel_columns4').each(function(){
var $this=$(this);
 var sp8cc4={
    animation: "slide",
    controlNav: true,
    directionNav: false,
    animationLoop: false,
    slideshow: false,
    itemWidth: 170,
    maxItems: 4,
    minItems: msp8cc4,
    itemMargin: margin,
    prevText: "<i class='icon-left-open-mini'></i>",
    nextText: "<i class='icon-right-open-mini'></i>",
    start: function() {
               $this.removeClass('loading');
           }
  };
    
var custom=eval('op'+$this.attr('id')); 
$.extend(sp8cc4,custom); 
 $this.flexslider(sp8cc4); 
});

$('.span9 .carousel_columns4').each(function(){
var $this=$(this);
var sp9cc4={
    animation: "slide",
    controlNav: true,
    directionNav: false,
    animationLoop: false,
    slideshow: false,
    itemWidth: 275,
    maxItems: 4,
    minItems: msp9cc4,
    itemMargin: margin,
    prevText: "<i class='icon-left-open-mini'></i>",
    nextText: "<i class='icon-right-open-mini'></i>",
    start: function() {
               $this.removeClass('loading');
           }
  };
   
var custom=eval('op'+$('.span9 .carousel_columns4').attr('id')); 
$.extend(sp9cc4,custom); 
  $('.span9 .carousel_columns4').flexslider(sp9cc4); 
});

$('.fullwidth .carousel_columns1').each(function(){
var $this=$(this);
  var fwcc1={
    animation: "slide",
    controlNav: true,
    directionNav: false,
    animationLoop: false,
    slideshow: false,
    maxItems:1,
    minItems:1,
    itemMargin: 0,
    prevText: "<i class='icon-left-open-mini'></i>",
    nextText: "<i class='icon-right-open-mini'></i>",
    start: function() {
               $this.removeClass('loading');
           }
  };
   
var custom=eval('op'+$this.attr('id')); 
$.extend(fwcc1,custom); 
  $this.flexslider(fwcc1);
});

$('.span3 .carousel_columns1').each(function(){
var $this=$(this);
  var sp3cc1={
    animation: "slide",
    controlNav: true,
    directionNav: false,
    animationLoop: false,
    slideshow: false,
    maxItems:1,
    minItems:1,
    itemMargin: margin,
    prevText: "<i class='icon-left-open-mini'></i>",
    nextText: "<i class='icon-right-open-mini'></i>",
    start: function() {
               $this.removeClass('loading');
           }
  };
     
var custom=eval('op'+$this.attr('id')); 
$.extend(sp3cc1,custom); 
  $this.flexslider(sp3cc1);
});
  
$('.span4 .carousel_columns1').each(function(){
var $this=$(this);  
  var sp4cc1={
    animation: "slide",
    controlNav: true,
    directionNav: false,
    animationLoop: false,
    slideshow: false,
    maxItems:1,
    minItems:1,
    prevText: "<i class='icon-left-open-mini'></i>",
    nextText: "<i class='icon-right-open-mini'></i>",
    start: function() {
               $this.removeClass('loading');
           }
  };
      
var custom=eval('op'+$this.attr('id')); 
$.extend(sp4cc1,custom); 
  $this.flexslider(sp4cc1);
});
  
$('.span6 .carousel_columns1').each(function(){
var $this=$(this);   
    var sp6cc1={
    animation: "slide",
    controlNav: true,
    directionNav: false,
    animationLoop: false,
    slideshow: false,
    maxItems:1,
    minItems:1,
    prevText: "<i class='icon-left-open-mini'></i>",
    nextText: "<i class='icon-right-open-mini'></i>",
    start: function() {
               $this.removeClass('loading');
           }
  };
  
      
var custom=eval('op'+$this.attr('id')); 
$.extend(sp6cc1,custom); 
  $this.flexslider(sp6cc1);
});

$('.span8 .carousel_columns1').each(function(){
var $this=$(this); 
  var sp8cc1={
    animation: "slide",
    controlNav: true,
    directionNav: false,
    animationLoop: false,
    slideshow: false,
    maxItems:1,
    minItems:1,
    prevText: "<i class='icon-left-open-mini'></i>",
    nextText: "<i class='icon-right-open-mini'></i>",
    start: function() {
               $this.removeClass('loading');
           }
  };
  
var custom=eval('op'+$this.attr('id')); 
$.extend(sp8cc1,custom);  
  $this.flexslider(sp8cc1);
});
  
$('.span9 .carousel_columns1').each(function(){
var $this=$(this);   
    var sp9cc1={
    animation: "slide",
    controlNav: true,
    directionNav: false,
    animationLoop: false,
    slideshow: false,
    maxItems:1,
    minItems:1,
    prevText: "<i class='icon-left-open-mini'></i>",
    nextText: "<i class='icon-right-open-mini'></i>",
    start: function() {
               $this.removeClass('loading');
           }
  };
        
var custom=eval('op'+$this.attr('id')); 
$.extend(sp9cc1,custom); 

  $this.flexslider(sp9cc1);
});
  
$('.fullwidth .carousel_columns6').each(function(){ 
var $this=$(this);   
  var fwcc6={
    animation: "slide",
    controlNav: true,
    directionNav: false,
    animationLoop: false,
    slideshow: false,
    itemWidth: 170,
    maxItems: 6,
    minItems: mfwcc6,
    itemMargin: margin,
    prevText: "<i class='icon-left-open-mini'></i>",
    nextText: "<i class='icon-right-open-mini'></i>",
    start: function() {
               $this.removeClass('loading');
           }
  };
  
  
var custom=eval('op'+$this.attr('id')); 
$.extend(fwcc6,custom); 
$this.flexslider(fwcc6); 
});

  
$('.fullwidth .carousel_columns5').each(function(){
var $this=$(this); 
  var fwcc5={
    animation: "slide",
    controlNav: true,
    directionNav: false,
    animationLoop: false,
    slideshow: false,
    itemWidth: 210,
    maxItems: 5,
    minItems: mfwcc5,
    itemMargin: margin,
    prevText: "<i class='icon-left-open-mini'></i>",
    nextText: "<i class='icon-right-open-mini'></i>",
    start: function() {
               $this.removeClass('loading');
           }
  };
  
   
var custom=eval('op'+$this.attr('id')); 
$.extend(fwcc5,custom); 
$this.flexslider(fwcc5); 

});

// The slider being synced must be initialized first

 $('.project_carousel').each(function(){
var $this=$(this);  
  $this.flexslider({
      animation: "slide",
      controlNav: false,
      directionNav: true,
      animationLoop: false,
      slideshow: false,
      itemWidth: 370,
      itemMargin:margin,
      maxItems: 3,
      minItems: mfwcc3,
        prevText: "<i class='icon-left-open-mini'></i>",
        nextText: "<i class='icon-right-open-mini'></i>",
    start: function() {
               $this.removeClass('loading');
           }
    });  
 });
 
 
  $('.listing_carousel').each(function(){
  var $this=$(this);
  $this.flexslider({
      animation: "slide",
      controlNav: false,
      directionNav: true,
      animationLoop: false,
      slideshow: false,
      itemWidth: 370,
      itemMargin:margin,
      maxItems: 3,
      minItems: mfwcc3,
        prevText: "<i class='icon-left-open-mini'></i>",
        nextText: "<i class='icon-right-open-mini'></i>",
    start: function() {
               $this.removeClass('loading');
           }
    });
 });    
 $('.archive_carousel').flexslider({
      animation: "slide",
      controlNav: false,
      directionNav: true,
      animationLoop: false,
      slideshow: false,
      itemWidth: 220,
    prevText: "<i class='icon-left-open-mini'></i>",
    nextText: "<i class='icon-right-open-mini'></i>"
    });
 $('.widget_carousel').each(function(){
     var $this=$(this);
     $this.flexslider({
     animation: "slide",
     slideshow: true,                //Boolean: Animate slider automatically
     slideshowSpeed: 3000, 
     controlNav: true,
     directionNav: false,
     animationLoop: false,
     minItems:1,
    prevText: "<i class='icon-left-open-mini'></i>",
    nextText: "<i class='icon-right-open-mini'></i>",
    start: function() {
               $this.removeClass('loading');
           }
   });
});

  $('.twitter_carousel').each(function(){
      
  var $this = $(this);
   $this.flexslider({
      animation: "slide",
      controlNav: false,
      directionNav: false,
      animationLoop: true,
      slideshow: true,
    prevText: "<i class='icon-left-open-mini'></i>",
    nextText: "<i class='icon-right-open-mini'></i>",
    start: function() {
               $this.removeClass('loading');
           }
    });    
  });
  
 $('.vibe_mega_carousel').fadeOut(); 
 $('.vibe_mega_carousel').eq(0).fadeIn(600); 
 $('.megacarousel').eq(0).addClass('active');
 $('.megacarousel').click(function(){
    var i= $(this).index();
    $('.vibe_mega_carousel').fadeOut(600);
    $('.megacarousel').removeClass('active');
    var $this = $('.vibe_mega_carousel').eq(i).find('.woocommerce');
    setTimeout(function(){
         $('.vibe_mega_carousel').eq(i).fadeIn(600);
         v_carousel_fx($this);
          $('.megacarousel').eq(i).addClass('active');
    },600);
    
    return false;
 });  
 
$('.vibe_carousel .woocommerce').each(function(){
     var $this= $(this);
     if($this.is(":visible")){
        v_carousel_fx($this);
     }
});


function v_carousel_fx($this){
    var direction,control,itemwidth,maxitem,minitem,scroll,vmargin;
    direction=control=false;vmargin=margin;
    scroll='horizontal';
    $this.find('li.product').removeClass().addClass('product');
    if($this.parent().hasClass('direction'))
        direction = true;
    else
        direction = false;
    if($this.parent().hasClass('control'))
        control = true;
    else
        control = false;

   if($this.parent().hasClass('columns1')){
       itemwidth=true;
       maxitem=1;
       minitem=1;
   }
       
       
   if($this.parent().hasClass('columns2')){
       itemwidth = 420;
       maxitem=2;
       minitem=2;
   }
       
   
   if($this.parent().hasClass('columns3')){
       itemwidth=320;
       maxitem=3;
       minitem=2;
   }
       
   
   if($this.parent().hasClass('columns4')){
       itemwidth=200;
       maxitem=4;
       minitem=2;
   }
       
   
   if($this.parent().hasClass('columns5')){
       itemwidth=180;
       maxitem=5;
       minitem=2;
   }
   if($this.parent().hasClass('columns6')){
       itemwidth=140;
       maxitem=6;
       minitem=2;
   }
       
   if($this.parent().hasClass('vertical')){
      
       itemwidth=true;
       vmargin=0;
       
        $this.flexslider({
      animation: "slide",
      selector: ".products > li", 
      direction: 'vertical',
      controlNav: control,
      directionNav: direction,
      animationLoop: false,
      slideshow: false,
      prevText: "<i class='icon-left-open-mini'></i>",
      nextText: "<i class='icon-right-open-mini'></i>"
    });
    
   }else{
        $this.flexslider({
      animation: "slide",
      selector: ".products > li", 
      controlNav: control,
      directionNav: direction,
      animationLoop: false,
      slideshow: false,
      itemWidth: itemwidth,
      itemMargin:20,
      maxItems:maxitem,
      minItems:minitem,
      prevText: "<i class='icon-left-open-mini'></i>",
      nextText: "<i class='icon-right-open-mini'></i>"
    });
   }
}

    /*
    $('.projectitem').mouseenter(function(){
     this.append('<div class="overlay"><span>view details</span></div>');
    }); 
    
    */
});



jQuery(window).load(function ($) {
 var $ = jQuery;
 $('.custom_post_filterable').each(function(){
        var $container = $(this).find('.filterableitems_container'),
    	$filtersdiv = $(this).find('.vibe_filterable'),
        $checkboxes = $(this).find('.vibe_filterable a');
    

  $container.imagesLoaded( function(){  
    $container.isotope({
      itemSelector: '.filteritem'
    }); 
  });
  
    $checkboxes.click(function(event){
      event.preventDefault();
      var me = $(this);
      $filtersdiv.find('.active').removeClass();
      var filters = me.attr('data-filter');
      me.parent().addClass('active');
      $container.isotope({filter: filters});
    });
   
   $('.vibe_filterable a:first').trigger('click');
   $('.vibe_filterable a:first').parent().addClass('active');
 });
});

  
jQuery(document).ready(function ($) {
 $('.show_nav').next('ul').hide();
  	  $('.show_nav').click(function(){
  	  	$(this).next('ul').slideToggle('slow');
  	  }); 	
  	  
      $('.accordionnav li > ul').hide();    //hide all nested ul's
      $('.accordionnav li > ul li a[class=current]').parents('ul').show().prev('a').addClass('vaccordionExpanded');  //show the ul if it has a current link in it (current page/section should be shown expanded)
      $('.accordionnav li:has(ul)').addClass('vaccordion');
      if(!$('.accordionnav li:has(ul) > a').has('i'))
      $('.accordionnav li:has(ul) > a').append('<i class="icon-down-open-big"></i>');  

      $('.accordionnav li:has(ul) > a').click(function() {
          $(this).toggleClass('vaccordionExpanded'); //for CSS bgimage, but only on first a (sub li>a's don't need the class)
          $(this).find('i').toggleClass('icon-up-open-big');
          $(this).next('ul').slideToggle('fast');
          $(this).parent().siblings('li').children('ul:visible').slideUp('fast')
              .parent('li').find('a').removeClass('vaccordionExpanded')
              .parent('li').find('i').removeClass('icon-minus');
          return false;
      });
  });
  
  
  
 jQuery(document).ready(function ($) {
 $('.comment-form-rating span a').mouseenter(function(){
 	var parent=$(this).parent();
 	var select = parent.parent().parent().find('#rating');
 	var k=$(this).index();
 	var ri = 5-k;
 	for(var i=0;i<k;i++){
 		parent.find('a').eq(i).addClass('over');
 		}
 		var rate_text=select.find('option').eq(ri).text();
 		parent.after('<span id="rate_text">'+rate_text+'</span>');
 		parent.parent().find('#clickrate_text').hide();
 	});
 	$('.comment-form-rating span a').mouseleave(function(){
 		var parent=$(this).parent();
 		var k=$(this).index();
 		for(var i=0;i<k;i++){
 			parent.find('a').eq(i).removeClass('over');
 			}
 		 parent.parent().find('#rate_text').remove();
 		 parent.parent().find('#clickrate_text').show();
 		});
 		
 	$('.comment-form-rating span a').click(function(){
 		var parent=$(this).parent();
 		var select = parent.parent().parent().find('#rating');
 		var k=$(this).index();
 		var ri = 5-k;
 		//remove and reset value
 		parent.find('a').removeClass('clickover');
 		select.find('option:selected').removeAttr("selected");
 		parent.parent().find('#clickrate_text').remove();
 		
 		for(var i=0;i<=k;i++){
 			parent.find('a').eq(i).addClass('clickover');
 			}
 		select.find('option').eq(ri).attr('selected','selected');
 		select.trigger('change');
 		var rate_text=select.find('option').eq(ri).text();
 		parent.after('<span id="clickrate_text">'+rate_text+'</span>');	
 	});	
 }); 

  
//AJAX CONTACT FORM
jQuery(document).ready(function ($) {
	
	// SUBSCRIPTION FORM AJAX HANDLE
	         $( 'body' ).delegate( '.form .form_submit', 'click', function(event){
                      event.preventDefault();
                      var parent = $(this).parent();
	              var $response= parent.find(".response");
                      var error= '';
                      var data = [];
                      var label = [];
	              var regex = [];
                      var to = parent.attr('data-email');
                      var subject = parent.attr('data-subject');
                      regex['email'] = /^([a-z0-9._-]+@[a-z0-9._-]+\.[a-z]{2,4}$)/i;
                      regex['phone'] = /[A-Z0-9]{7}|[A-Z0-9][A-Z0-9-]{7}/i;
                      regex['numeric'] = /^[0-9]+$/i;
                      var i=0;
                      parent.find('.form_field').each(function(){
                          i++;
                          var validate=$(this).attr('data-validate');
                          var value = $(this).val();
                          if(!value.match(regex[validate])){
                              error += 'Invalid '+validate;
                              $(this).css('border-color','#e16038');
                          }else{
                              data[i]=value;
                              label[i]=$(this).attr('placeholder');
                          }
                      });
                          if (error !== "") {
	                  $response.fadeIn("slow");
	                  $response.html("<span style='color:#D03922;'>Error: " + error + "</span>");
                            } else {
                        $response.css("display", "block");
	                  $response.html("<span style='color:#0E7A00;'>Sending message... </span>");
	                  $response.fadeIn("slow");
                          setTimeout(function(){sendmail(to,subject,data,label,parent);}, 2000);
	              }
                      
	              return false;
	          });
	          
	      
	      
	      function sendmail(to,subject,formdata,labels,parent) { 
	      	var $response= parent.find(".response");
	      	$.ajax({
	              type: "POST",
	              url: ajaxurl,
                      data: {   action: 'contact_submission', 
                                to: to,
                                subject : subject,
                                data:JSON.stringify(formdata),
                                label:JSON.stringify(labels)
                            },
	              cache: false,
	              success: function (html) {
	                  $response.fadeIn("slow");
	                  $response.html(html);
	                  setTimeout(function(){$response.fadeOut("slow");}, 10000);
	              }
	          });
	      }
	     
});

jQuery(document).ready(function ($) {
	   $( 'audio' ).audioPlayer(); 
           $("a[data-rel^='prettyPhoto']").prettyPhoto({theme : 'light_square',hook: 'data-rel'});
           $("a[data-rel^='thumbnails']").prettyPhoto({theme : 'light_square'});
});

jQuery(document).ready(function ($) {
    $( 'body' ).delegate( '.like', 'click', function(){
        var el =$(this);
       var id=$(this).attr('id');
       $.ajax({
	              type: "POST",
	              url: ajaxurl,
                      data: {action: 'like_count', 
                                id:id
                            },
	              cache: false,
	              success: function (html) {
                          var defaultcolor = el.css('color');
                          el.css('color','#e16f4b');
                          if(html.length > 5){
                              alert(html);
                          }else{
                              
                              el.html('<i class="icon-heart"></i> '+html);
	                      //setTimeout(function(){el.css('color',defaultcolor);}, 10000);
                          }
	                  
	              }
	          });
    });
});

jQuery(document).ready(function ($) {
$('.scroll_product').click(function() { 
    var modalid=$(this).attr('href');
    var currentid = '#'+$(this).parent().parent().attr('id');
    $(currentid).modal('hide');
    $(modalid).modal('show');
    });
    
    $(".mousetrap").live('click',function(){
					$(this).prev().trigger('click');
	});
        
});


var fixed = false;
var inpage_top =0;

if(jQuery(".inpage_menu").length > 0){
  var height=0;
  if(jQuery('#nav_horizontal.fix').length>0)
    height = jQuery('#nav_horizontal.fix').height();
    
    inpage_top=jQuery('.inpage_menu').offset().top - height + 2; //Adjusting Borders
}

          
jQuery(document).scroll(function ($) {
      var top = jQuery('#nav_horizontal').attr('data-top');
      if( jQuery(this).scrollTop() > top ) {
          if( !fixed ) { 
              fixed = true;
              jQuery('.toparrow').show('fast');
              var height = jQuery('#nav_horizontal.fix').height();
              
               jQuery('#nav_horizontal.fix').addClass('fixed');
              
             
              if(jQuery('#nav_horizontal.fix').next().is(':visible'))
                jQuery('#nav_horizontal.fix').next().css('marginTop',height); 
              else{
                  if(jQuery('#nav_horizontal.fix').next().next().is(':visible'))
                    jQuery('#nav_horizontal.fix').next().next().css('marginTop',height); 
                  else
                     jQuery('#nav_horizontal.fix').next().next().next().css('marginTop',height);  
              }
                
                
          }
      } else {
          if( fixed ) {
              fixed = false;
              jQuery('.toparrow').hide('fast');
              jQuery('#nav_horizontal.fix').removeClass('fixed');
              
              
              if(jQuery('#nav_horizontal.fix').next().is(':visible'))
                jQuery('#nav_horizontal.fix').next().css('marginTop',0); 
              else{
                  if(jQuery('#nav_horizontal.fix').next().next().is(':visible'))
                    jQuery('#nav_horizontal.fix').next().next().css('marginTop',0); 
                  else
                     jQuery('#nav_horizontal.fix').next().next().next().css('marginTop',0);  
              }
              
          }
      }
      
      jQuery('.inpage_menu').each(function(){
          var $this =jQuery(this);
          
         if(jQuery(window).scrollTop() > inpage_top){
            $this.addClass('fixed');
         }else{
             $this.removeClass('fixed');
         }
      });
      
      
      jQuery('header#onepage').each(function(){
          var $this = jQuery(this);
          var h = $this.height();
          if(jQuery(window).scrollTop() > h){
            $this.addClass('fixed');
         }else{
             $this.removeClass('fixed');
         }
      });
      /*
      jQuery('.scroll_menu').each(function(){
          var $this = jQuery(this);
          if(jQuery(window).scrollTop() > 220){
            $this.addClass('fixed');
         }else{
             $this.removeClass('fixed');
         }
      });*/
      
     
 
  });

jQuery(document).ready(function($) { 
    /*
    jQuery('.scroll_menu').each(function(){
          var $this = jQuery(this);
          if(jQuery(window).scrollTop() > 220){
            $this.addClass('fixed');
         }else{
             $this.removeClass('fixed');
         }
      });
      */
     
  if($('.scroll_menu').length > 0){
      var top = $('.scroll_menu').offset().top ;
      var $this = $('.scroll_menu');
      var endtop;
      
      if($('#nav_horizontal').hasClass('fix'))
          endtop = $('footer').offset().top-$('#nav_horizontal').height()-100;
      else
          endtop = $('footer').offset().top-$('#nav_horizontal').height()-40;
      

        $(window).scroll(function (event) {
    var y = $(this).scrollTop();
    if (y >= top && y<=endtop) {
      $this.addClass('fixed');
    } else {
      $this.removeClass('fixed');
    }
  });
 } 
  });
  
jQuery(document).ready(function($) { 
 // Cache selectors
 var lastId;
 var topMenu = $(".in_menu"); 
 var topMenuHeight = 224;
     // All list items
 var menuItems = topMenu.find("a"),
     // Anchors corresponding to menu items
     scrollItems = menuItems.map(function(){
       var item = $($(this).attr("href"));
       
       if (item.length) { return item; }
     });
  

 // Bind click handler to menu items
 // so we can get a fancy scroll animation
 menuItems.live('click', function(event){
  var $this=$(this);
   var href = $(this).attr("href"),
       offsetTop = href === "#" ? 0 : $(href).offset().top-topMenuHeight+50;
       
    $('html, body').stop().animate({ 
       scrollTop: offsetTop
   }, 600);
 
   event.preventDefault();
 });


        $(window).scroll( function ()
        {
            var fromTop = $(this).scrollTop()+225;
            
            var cur = scrollItems.map(function(){
              if ($(this).offset().top < fromTop)
                return this;
            });

            cur = cur[cur.length-1];
            var id = cur && cur.length ? cur[0].id : "";
            if (lastId !== id) {
                lastId = id; 
                menuItems
                  .removeClass("active");
                  menuItems.filter("[href=#"+id+"]").addClass("active"); 
                                
                   }
              
        });
});

jQuery(document).ready(function($){
    $('.v_parallax_block').each(function(){
        var $bgobj = $(this);
        var i = parseInt($bgobj.attr('data-scroll'));
        var rev = parseInt($bgobj.attr('data-rev'));
        
        $(window).scroll(function(e) {
            e.preventDefault();
            var $window = jQuery(window);
            var yPos = -Math.round(($window.scrollTop()/i));
            var coords;
             if(rev != undefined){
                 if(rev){
                    yPos= yPos * -1  -150; 
                    coords = '50% '+yPos + 'px';
                   }else{ 
                 coords = '50% '+yPos + 'px';
                 }
              }
            // Move the background
            $bgobj.css({backgroundPosition: coords});
        }); 
        
    });   
    
   
    
    $('.animate').not('.load').each(function(i){
        var $this=$(this);
        var ind = i * 100;
        var docViewTop = $(window).scrollTop();
        var docViewBottom = docViewTop + $(window).height();
        var elemTop = $this.offset().top;      

           
            if (docViewBottom >= elemTop) { 
                setTimeout(function(){ 
                     $this.addClass('load');
                	}, ind);
                }
    });


$(window).scroll(function (event) {
    
    $('section').each(function(){ 
     //   $(this).find('.animate').not('.load').filter(":onScreen").each(function(i){
var animate = $('.animate').filter(":onScreen").not('.load');
var len = animate.length;
var i = 0;
clearInterval(test);

var test =  setInterval(function(){
                animate.eq(i).filter(":onScreen").delay(i*100).queue(function(){
                  	$(this).filter(":onScreen").addClass('load');
                })   
                i++;
                if (len == 0) {
                    clearInterval(test);
                }
             }, 400);
       }); 
    });
});


jQuery(document).ready(function ($) {
                        
    $('.postlist_pagination').each(function(){
        $(this).find('.pagination_previous').hide();
                var max_page = $(this).find('.pagination.max_pages').val();
                var current_page = $(this).find('.pagination.cur_page').val();
                if(max_page == current_page){
                        $(this).find('.pagination_next').hide();
                }
    });
              
  function calculateMoPayment(loanAmt, yearlyRate, numYears) {
    var numMonths = numYears * 12;
    var monthlyRate = yearlyRate / 1200;
    var moPayment = loanAmt * (monthlyRate / (1 - (Math.pow((1 + monthlyRate), -numMonths))));
    return (yearlyRate == 0) ? loanAmt / (numYears * 12) : moPayment;
  }
             
    // Loan Calaultor
    $('#calculate_loan').click(function(event){
        event.preventDefault();
        $('#monthly_payment').remove();

        var loan_amount=parseInt($('#loan_amount').val());
        var loan_years=parseInt($('#loan_years').val());
        var interest_rate=parseFloat($('#loan_interest').val());
        var html = '<div id="monthly_payment">';
        var cur = $(this).attr('data-currency');
        html = html + '<span><i class="'+cur+'"></i>' + Math.round(calculateMoPayment(loan_amount, interest_rate, loan_years));
        html = html+'</span> / MONTH</div>';
        $(this).after(html);
    });    
   
    $('.pagination_previous').click(function(){
            var parent = $(this).parent();
            var current_page = parent.find('.pagination.cur_page').val();
            var max_page = $(this).find('.pagination.max_pages').val();
            var the_query = parent.find('.pagination.query').val();
            
            var list_style = parent.find('.pagination.postlist_style').val();
            var excerpt_length = parent.find('.pagination.postlist_excerpt_length').val();
            var link = parent.find('.pagination.postlist_link').val();
            var lightbox = parent.find('.pagination.postlist_lightbox').val();
            
            
            $.ajax({
	              type: "POST",
	              url: ajaxurl,
                      data: {action: 'postlist_pagination', 
                                scroll: 'previous',
                                curr: current_page,
                                list_style: list_style,
                                excerpt_length: excerpt_length,
                                link: link,
                                lightbox: lightbox,
                                query: the_query
                            },
	              cache: false,
	              success: function (html) {
                          current_page = parseInt(current_page)-1;
	                  parent.find('.pagination.cur_page').val(current_page);
                          parent.parent().find('ul.postlist').html(html);
                          
                          if(current_page <= 1){
                                parent.find('.pagination_previous').hide();
                                parent.find('.pagination_next').show(); 
                            }else{
                               parent.find('.pagination_next').show(); 
                            }
	              }
	          }); 
    });
    
     $('.pagination_next').click(function(){
            var parent = $(this).parent();
            var current_page = parent.find('.pagination.cur_page').val();
            var max_page = parent.find('.pagination.max_pages').val();
            var the_query = parent.find('.pagination.query').val();
            
            var list_style = parent.find('.pagination.postlist_style').val();
            var excerpt_length = parent.find('.pagination.postlist_excerpt_length').val();
            var link = parent.find('.pagination.postlist_link').val();
            var lightbox = parent.find('.pagination.postlist_lightbox').val();
            
            
            $.ajax({
	              type: "POST",
	              url: ajaxurl,
                      data: {action: 'postlist_pagination', 
                                scroll: 'next',
                                curr: current_page,
                                list_style: list_style,
                                excerpt_length: excerpt_length,
                                link: link,
                                lightbox: lightbox,
                                query: the_query
                            },
	              cache: false,
	              success: function (html) {
                          current_page = parseInt(current_page)+1;
	                  parent.find('.pagination.cur_page').val(current_page);
                          parent.parent().find('ul.postlist').html(html);
                         if(current_page >= max_page){
                                    parent.find('.pagination_next').hide();
                                    parent.find('.pagination_previous').show();
                          }else{
                               parent.find('.pagination_previous').show();
                          } 
	              }
	          });  
             });     
});
// Boxed Fix

jQuery(document).ready(function ($) {
   $('section.stripe').each(function(){
		var next = $(this).next();
      if(next.hasClass('main')){
        next.addClass('stripenext');
     	}
     });


// handles the carousel thumbnails
$('[id^=carousel-selector-]').click( function(){
  var id_selector = $(this).attr("id");
  var id = id_selector.substr(id_selector.length -1);
  id = parseInt(id);
  $('.thumb_slider').carousel(id);
});


});

jQuery(window).load(function($){
if(jQuery(window).width() > 768){
   jQuery('.homesliderparallax').each(function(){
        var homeslider = jQuery(this);
     var height=homeslider.height();
     if(jQuery('.homesliderparallax').next().is(':visible'))
                jQuery('.homesliderparallax').next().css('marginTop',height); 
              else{
                  if(jQuery('.homesliderparallax').next().next().is(':visible'))
                    jQuery('.homesliderparallax').next().next().css('marginTop',height); 
                  else
                     jQuery('.homesliderparallax').next().next().next().css('marginTop',height);  
              }
       }); 
 } else{
      jQuery('.homesliderparallax').css({position: 'relative'});
    }     
});

jQuery(document).ready(function ($) {
    $('#sortform select').change(function(){
        this.form.submit();
    });
});
jQuery(document).ready(function ($) {
    
    if($('.vibe_grid').length && $('.vibe_grid').hasClass('inifnite_scroll')){
    var $this= $('.vibe_grid.inifnite_scroll:not(.loaded)');
        var end = $this.parent().find('.end_grid');
        var load = $this.parent().find('.load_grid');
        var args = $this.find('.wp_query_args').html();
        var max = parseInt($this.find('.wp_query_args').attr('data-max-pages'));
        
        var top = $('.vibe_grid.inifnite_scroll:not(.loaded) li:last').offset().top -500;
        var rel = parseInt($('.vibe_grid.inifnite_scroll:not(.loaded)').attr('data-page')); 
        
     $(window).data('ajaxready', true).scroll(function(e) {
         
           if ($(window).data('ajaxready') == false) return;
          
          if(!$('.vibe_grid.inifnite_scroll').hasClass('loaded'))
            top = $('.vibe_grid.inifnite_scroll:not(.loaded) li:last').offset().top -500;
          else
              rel = max;
         
         if ($(window).scrollTop() >= top && rel < max ) {
            
        $(window).data('ajaxready', false);
        
       
        $.ajax({
	              type: "POST",
	              url: ajaxurl,
                      data: {action: 'grid_scroll', 
                                args: args,
                                page: rel
                            },
	              cache: false,
	              success: function (html) {
                         
                          if(html){
                              rel++;
                              $this.attr('data-page',rel);
                             if($this.hasClass('masonry')){
                                    $('.vibe_grid.inifnite_scroll:not(.loaded) .grid.masonry').append(html).masonry('reload');
                                    $(window).trigger('resize');
                                    $('.vibe_grid.inifnite_scroll .grid.masonry').imagesLoaded( function(){
                                       $('.vibe_grid.inifnite_scroll .grid.masonry').masonry('reload');});
                                }else{
                                $('.vibe_grid.inifnite_scroll:not(.loaded) li:last').after(html); 
                                } 
                          } 
                          // All Queries
                          $(".fit_video").fitVids();
                          $( 'audio' ).audioPlayer(); 
                          
                          $("a[data-rel^='prettyPhoto']").prettyPhoto({
                              theme: 'light_square'
                          });
                          $("a[data-rel^='thumbnails']").prettyPhoto();
                          $('select').chosen({disable_search_threshold: 10});
                          $(window).data('ajaxready', true);
                        
                           
                        
                              
	              }
	          }); 
            }else{
             if(rel == max){
                             end.fadeIn(200);
                                load.fadeOut(200);
                              $this.addClass('loaded');
             }     
            }
        });
    }
});


// EventListener | @jon_neal | //github.com/jonathantneal/EventListener
!window.addEventListener && window.Element && (function () {
    function addToPrototype(name, method) {
        Window.prototype[name] = HTMLDocument.prototype[name] = Element.prototype[name] = method;
    }
 
    var registry = [];
 
    addToPrototype("addEventListener", function (type, listener) {
        var target = this;
 
        registry.unshift({
            __listener: function (event) {
                event.currentTarget = target;
                event.pageX = event.clientX + document.documentElement.scrollLeft;
                event.pageY = event.clientY + document.documentElement.scrollTop;
                event.preventDefault = function () { event.returnValue = false };
                event.relatedTarget = event.fromElement || null;
                event.stopPropagation = function () { event.cancelBubble = true };
                event.relatedTarget = event.fromElement || null;
                event.target = event.srcElement || target;
                event.timeStamp = +new Date;
 
                listener.call(target, event);
            },
            listener: listener,
            target: target,
            type: type
        });
 
        this.attachEvent("on" + type, registry[0].__listener);
    });
 
    addToPrototype("removeEventListener", function (type, listener) {
        for (var index = 0, length = registry.length; index < length; ++index) {
            if (registry[index].target == this && registry[index].type == type && registry[index].listener == listener) {
                return this.detachEvent("on" + type, registry.splice(index, 1)[0].__listener);
            }
        }
    });
 
    addToPrototype("dispatchEvent", function (eventObject) {
        try {
            return this.fireEvent("on" + eventObject.type, eventObject);
        } catch (error) {
            for (var index = 0, length = registry.length; index < length; ++index) {
                if (registry[index].target == this && registry[index].type == eventObject.type) {
                    registry[index].call(this, eventObject);
                }
            }
        }
    });
})();