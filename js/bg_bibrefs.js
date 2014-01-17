/*******************************************************************************
   При создании страницы для всех элементов 'a.bg_data_title' 
   запрашивает текст Библии и заполняет всплывающую подсказку
*******************************************************************************/  
jQuery(document).ready(function(){
	var allParams = parseUrlQuery();
	if (allParams.preq == '0') return; 

	jQuery('a.bg_data_title').each (function(){
		var el = jQuery(this);
		if (el.attr('data-title') == "") return;				// Книга не задана
		var tooltip = el.children('span.bg_data_tooltip');	
		jQuery.ajax({
			type: 'GET',
			cache: false,
			async: true,
			dataType: 'text',
			url: el.attr('data-title'),							// Запрос стихов Библии
			data: {
				action: 'bg_bibrefs'
			},
			success: function (verses, textStatus) {
				if (verses != 0) {
					tooltip.html(verses);						// Добавляем стихи в подсказку
					el.attr('data-title', "");
				}
			}
		});
	});
}); 

/*******************************************************************************
   При наведении мыши на ссылку, если подсказка не пуста, 
   отображает подсказку на экране
*******************************************************************************/  
jQuery('a.bg_data_title')
	.mouseenter(function(e){
		var el = jQuery(this);
		var tooltip = el.children('span.bg_data_tooltip');	
		if (el.attr('data-title') != "") {						// Книга задана
			jQuery.ajax({
				type: 'GET',
				cache: false,
				async: false,
				dataType: 'text',
				url: el.attr('data-title'),						// Запрос стихов Библии
				data: {
					action: 'bg_bibrefs'
				},
				success: function (verses, textStatus) {
					if (verses != 0) {
						tooltip.html(verses);					// Добавляем стихи в подсказку
						el.attr('data-title', "");
					}
				}
			}); 
		}
		if (!tooltip.html()) return;							// Подсказка еще пустая, подождем
	// Определяем положение подсказки на экране
		var pos = el.position();								// Позиция родительского элемента
		var mousex = e.pageX-(el.offset().left-pos.left)-12;	// Получаем координаты по оси X - 12
//		var mousex = pos.left; 									// Получаем координаты по оси X
		var mousey =  pos.top+el.height(); 						// Получаем координаты по оси Y
		var tipWidth = tooltip.width(); 						// Вычисляем ширину подсказки
		var tipHeight = tooltip.height(); 						// Вычисляем высоту подсказки
		if (tipHeight < 10)
			tooltip.css('height', parseInt(tooltip.css('max-height'))+"px");// Задаем высоту подсказки как максимальную
		else tooltip.css('height', "auto");						// иначе высота определяется автоматически
		tipHeight = tooltip.height(); 							// Снова вычисляем высоту подсказки
		
		// Определяем дистанцию от правого края окна браузера до блока, содержащего подсказку
		var tipVisX = jQuery(window).scrollLeft()+jQuery(window).width() - (mousex + tipWidth);
		// Определяем дистанцию от ниждего края окна браузера до блока, содержащего подсказку        
		var tipVisY = jQuery(window).scrollTop()+jQuery(window).height() - (mousey + tipHeight);

		if ( tipVisX < 20 ) { // Если ширина подсказки превышает расстояние от правого края окна браузера до курсора,
			mousex = e.pageX-(el.offset().left-pos.left)+12 - tipWidth; // то распологаем область с подсказкой по другую сторону от курсора
//			mousex = pos.left - tipWidth; // то распологаем область с подсказкой по другую сторону от курсора
		} 
		if ( tipVisY < 20 ) { // Если высота подсказки превышает расстояние от нижнего края окна браузера до курсора,
			mousey = pos.top - tipHeight;  						// то распологаем область с подсказкой над курсором
		} 
		else tooltip.css('height', "auto");						// иначе высота определяется автоматически
		mousex = Math.round(mousex);							// Координаты относительно родительского элемента
		mousey = Math.round(mousey);
		//Непосредственно присваиваем найденные координаты области, содержащей подсказку
		tooltip.css('top', mousey+"px");
		tooltip.css('left', mousex+"px");
		tooltip.css('display', "block");						// Строчно-блочный элемент 
	})
/*******************************************************************************
   При удалении мыши от ссылки, удаляет подсказку с экрана
*******************************************************************************/  
	.mouseleave(function(e) {
		var el = jQuery(this);
		var tooltip = el.children('span.bg_data_tooltip');	
		tooltip.css('display', "none");							// Скрыть элемент 	
	});

/*******************************************************************************
   Получить параметры JS-файла
*******************************************************************************/  
function parseUrlQuery() {
    var data = {}
        ,   pair = false
        ,   param = false;
	var jsfile = '';
	jQuery('script[src]').each (function(){
		jsfile = jQuery(this).attr('src');
		if (jsfile && jsfile.indexOf('bg_bibrefs.js') > -1) {
			jsfile = jsfile.substr(jsfile.indexOf('?'));
			pair = (jsfile.substr(1)).split('&');
			for(var i = 0; i < pair.length; i ++) {
				param = pair[i].split('=');
				data[param[0]] = param[1];
			}
			return;
		}
	});
    return data;
}
