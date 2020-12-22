$(document).ready(function(){
	//По названию тега
	$('body').css('border','1px solid red');
	//По классу
	$('.header').css('border','1px solid blue');
	//По идентификатору
	$('#main_nav').css('border','1px solid green');
	
	$('ul>li').css('border','1px solid black');
	//Селекторы атрибутов
	$('a[href*=hom]').css('font-weight', 'bold');
	
	//$('img[src$=.gif]')
	//Идентификатор элемента из списка
	$('ul li a:eq(1)').css('color','red');
	//Для каждого четного элемента последовательности
	$('ul li a:nth-child(2n)').css('text-decoration','none');
	//Для каждого нечетного элемента последовательности4
	$('ul li a:nth-child(2n+1)').css('color','pink');
	//Выбор элементов по содержимому
	//$('a:contains(Home4)').remove();
});
