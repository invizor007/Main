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
	//$('ul li a:even)...
	//Для каждого нечетного элемента последовательности4
	$('ul li a:nth-child(2n+1)').css('color','pink');
	//$('ul li a:odd)...
	//Выбор элементов по содержимому
	//$('a:contains(Home4)').remove();
	//$('ul li:has(a)');
	
	//$(':input').css('border','1px solid black');
	$(':input:text:enabled').css('display','none');
	$(':input:radio:checked').css('display','none');	
	$(':input:textarea').css('display','none');	
	
	//Первый и последний элемент 
	//$('ul li:first') $('ul li:last')

	//Исключение из выборки
	//$('ul li:not(.classA)');
});
