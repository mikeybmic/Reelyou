
//Slide menu function
function menuSlide(){
	// if($(window).width() < 768){
	// 	$('.wrapper').addClass('menu-on');
	// }else{
	// 	$('.wrapper').removeClass('menu-on');
	// }
};
$('.navbar-minimalize').click(function(e){
		e.preventDefault();
		$('body').toggleClass('menu-active');
	});
menuSlide();
$(window).resize(function(){
	menuSlide();
});

$( function() {
    $( "#tabs" ).tabs();
  } );
  
  
$( document ).ready(function() {
	$(document).on('click', '.makepin-post', function(){
        var $this = $(this);
        
                    var post = $this.attr('post');
                    var data = 'post=' + post;
                    $.ajax({
                        url: window.base_url + 'Posts/pin_post',
                        data: data,
                        type: 'POST',
                        success: function (postBack) {
                            var result = $.parseJSON(postBack);
                            if (result.msg == 1) {
                               
							   location.reload();
                            }
                        }
                    });
             
    });
	
$('.unpin-post').on('click', function () {
        var $this = $(this);
        
                    var post = $this.attr('post');
                    var data = 'post=' + post;
                    $.ajax({
                        url: window.base_url + 'Posts/unpin_post',
                        data: data,
                        type: 'POST',
                        success: function (postBack) {
                            var result = $.parseJSON(postBack);
                            if (result.msg == 1) {
                               
							 location.reload();
                            }
                        }
                    });
             
    });
	
	
	
});  

function like(post_id){
       
                    var data = 'post_id=' + post_id;
                    $.ajax({
                        url: window.base_url + 'Comments/like_post',
                        data: data,
                        type: 'POST',
                        success: function (postBack) {
                            var result = $.parseJSON(postBack);
                            if (result.success == 1) {
                              if(result.type=='like'){
								
                               $('#like_btn_'+post_id).html('<img src="'+result.imgsrc+'" alt="" title=""> Unlike('+result.total_like+')');
								}else{
								$('#like_btn_'+post_id).html('<img src="'+result.imgsrc+'" alt="" title=""> Like('+result.total_like+')');	
								}
                            }
                        }
                    });
              
}
