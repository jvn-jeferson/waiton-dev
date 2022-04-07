// hide #back-top first-------------------------------------------------------------

$(document).ready(function(){
	$("#BackTop").hide();
	$(window).scroll(function () {
 	if ($(this).scrollTop() >300) {
  		$('#BackTop').fadeIn();
 	} else {
 		$('#BackTop').fadeOut();
 	}
	});
});

 // ページ内リンクのみ取得
// var scroll = new SmoothScroll('a[href*="#"]', {
//   speed: 500, //スクロールする速さ
//   header: '#header'//固定ヘッダーがある場合
//  });
  
  $(function(){
$('a[href^="#"]'+ 'a,area').click(function(){
      var href= $(this).attr("href");
      var target = $(href == "#" || href == "" ? 'html' : href);
      var position = target.offset().top;
      var speed = 500; 
      $('body,html').animate({scrollTop:position}, speed, 'swing'); 
      return false;
   });
});


// hide #back-top first-------------------------------------------------------------


$(".qa-list dd").hide();
$(".qa-list dl").on("click", function(e){
    $('dd',this).slideToggle('fast');
    if($(this).hasClass('open')){
        $(this).removeClass('open');
    }else{
        $(this).addClass('open');
    }
});



// スムーズ-------------------------------------------------------------
