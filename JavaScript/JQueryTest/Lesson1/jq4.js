$(document).ready(function(){
	$('.header').html("<h1>Hello jQuery!!!</h1>");
	
	$(document).on('click','h1',function(){
		$(this).append("<br>Hello too");
	});	
	
	$('#removed_div').click(function(){
		$(this).remove();
		$('.header').remove();
	});
});



