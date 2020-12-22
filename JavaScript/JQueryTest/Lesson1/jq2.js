$(document).ready(function(){
	$('.header').html("<h1>Hello jQuery!!!</h1>");
	$(document).on('click','h1',function(){
		$(this).text("Hello too");
	});
});
