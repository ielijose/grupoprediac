$(document).ready(function(){


$('body').append("<div id='vibeoptions'>\
<div id='vibeoptionsopener'></div><div id='vibeoptions_text'></div>\
<h4>Select Theme Color</h4>\
<ul id='coloroptions'>\
<li style='background:#418CD1;' class='vibe_active'></li>\
<li style='background:#ba4a22;'>1</li>\
<li style='background:#5895A1;'>9</li>\
<li style='background:#65A667;' class='last'>10</li>\
</ul>\
<h4>Layout</h4>\
<ul id='layoutoptions'>\
<li style='background:#EEE;border:1px solid #DDD' class='vibe_active'>Boxed</li>\
<li style='background:#EEE;border:1px solid #DDD'>Wide</li>\
</ul>\
<h4>Background</h4>\
<ul id='bgoptions'>\
<li style='background:#fbfbfb;border:1px solid #DDD' class='vibe_active'></li>\
<li style=\"background:url('options\/img\/bg_img1.jpg');\">1</li>\
<li style=\"background:url('options\/img\/bg_img2.jpg');\">2</li>\
<li style=\"background:url('options\/img\/bg_img3.jpg');\">3</li>\
</ul>\
<h4>Background Effect</h4>\
<ul id='backgroundoptions'>\
<li class='vibe_active'></li>\
<li style=\"background:url('options\/img\/bg\/bg1.png');\">1</li>\
<li style=\"background:url('options\/img\/bg\/bg2.png');\">2</li>\
<li style=\"background:url('options\/img\/bg\/bg3.png');\" class='last'>3</li>\
<li style=\"background:url('options\/img\/bg\/bg4.png');\" class='last'>4</li>\
<li style=\"background:url('options\/img\/bg\/bg5.png');\">5</li>\
<li style=\"background:url('options\/img\/bg\/bg6.png');\">6</li>\
<li style=\"background:url('options\/img\/bg\/bg13.png');\" class='last'>13</li>\
<li style=\"background:url('options\/img\/bg\/bg8.png');\" class='last'>8</li>\
<li style=\"background:url('options\/img\/bg\/bg9.png');\">9</li>\
<li style=\"background:url('options\/img\/bg\/bg10.png');\">10</li>\
<li style=\"background:url('options\/img\/bg\/bg11.png');\" class='last'>11</li>\
<li style=\"background:url('options\/img\/bg\/bg12.png');\" >12</li>\
<li style=\"background:url('options\/img\/bg\/bg16.png');\" >16</li>\
<li style=\"background:url('options\/img\/bg\/bg20.png');\" >20</li>\
<li style=\"background:url('options\/img\/bg\/bg21.png');\" class='last'>21</li>\
<li style=\"background:url('options\/img\/bg\/bg22.png');\" >22</li>\
<li style=\"background:url('options\/img\/bg\/bg23.png');\" >23</li>\
<li style=\"background:url('options\/img\/bg\/bg24.png');\" >24</li>\
<li style=\"background:url('options\/img\/bg\/bg25.png');\" class='last'>25</li>\
</ul>\
</div>");

/*==== Vibe Options Panel ==== */


$('#vibeoptions').css({'margin-right': '-200px'});
$('#vibeoptionsopener').click(function(){

  $('#vibeoptions_text').hide();
  if($('#vibeoptions').hasClass('open')){
  	$('#vibeoptions').animate({'marginRight': '-200px'},400);
  	$('#vibeoptions').removeClass('open');
  }else{
	$('#vibeoptions').animate({'marginRight': 0},400);
	$('#vibeoptions').addClass('open');
	}
});

	$('#coloroptions li').click(function(){
		$('#coloroptions').find('.vibe_active').removeClass('vibe_active');
		$(this).addClass('vibe_active');
		
		var stl='<link href="options\/css/style'+$(this).text()+'.css" id="stl_wide" rel="stylesheet" />';
		var sld='<link href="options\/css/slider'+$(this).text()+'.css" id="sld_wide" rel="stylesheet" />'
                $('#custom_changes-css').append(stl);
                //$('#slider-css').append(sld);
	});
	
	
	$('#backgroundoptions li').click(function(){
		$('#backgroundoptions').find('.vibe_active').removeClass('vibe_active');
		
		if($(this).text()){
		var bg='url("options/img/bg/bg'+$(this).text()+'.png")';
		
		 $('#bg-effect').css({'background': bg});
		 $('#layoutoptions li:first').trigger('click');
		 }else{
		 $('#bg-effect').css({'background': 'none'});
		 }
		$(this).addClass('vibe_active');
		
	});
    
    $('#bgoptions li').click(function(){
    	$('#bgoptions').find('.vibe_active').removeClass('vibe_active');
    	if($(this).text()){
    	var bg='url("options/img/bg-body'+$(this).text()+'.jpg")';
    	
    	 $('body').css({'background': bg});
         $('body').css({'background-attachment': 'fixed'});
    	 $('#layoutoptions li:first').trigger('click');
    	 }else{
    	 $('body').css({'background': '#FFFFFF'});
    	 }
    	$(this).addClass('vibe_active');
    	
    	
    });
    
	$('#layoutoptions li').click(function(){
	
	var type=$(this).text();
	if(type == 'Wide'){
		$('#slider-css').append('<link href="options/css/wide.css" id="stl_wide" rel="stylesheet" />');
		$('#layoutoptions').find('.vibe_active').removeClass();
		$(this).addClass('vibe_active');
		$('#bgoptions li:first').trigger('click');
		$('#backgroundoptions li:first').trigger('click');
	}else{
	  $('#stl_wide').remove();
	  $('#layoutoptions').find('.vibe_active').removeClass();
	  $(this).addClass('vibe_active');
	}
	});


});