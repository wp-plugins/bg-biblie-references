/*******************************************************************************
   При наведении мыши на ссылку запрашивает текст Библии
   и заполняет всплывающую подсказку
*******************************************************************************/  
jQuery('a.bg_data_title').mouseenter(function(e){
	var el = jQuery(this);
	if (el.attr('data-title') == "") return;			// Книга не задана
	var tooltip = el.children('span.bg_data_tooltip');	
	if (tooltip.attr('display') != 'opened') {		// Подсказка еще не открыта
		tooltip.attr('display', 'opened');			// Вешаем флаг "Открыто"
		jQuery.ajax({
			type: 'GET',
			dataType: 'text',
			url:  el.attr('data-title'),					// Запрос стихов Библии
			success: function (verses) {
				tooltip.append(verses);						// Добавляем стихи в подсказку
			}
		});
	}
		var position = el.position();
		var mousex = e.pageX + 2; //Получаем координаты по оси X
		var mousey =  position.top + el.height(); // Получаем координаты по оси Y
		var tipWidth = tooltip.width(); //Вычисляем ширину подсказки
		var tipHeight = tooltip.height(); // Вычисляем высоту подсказки
		//Определяем дистанцию от правого края окна браузера до блока, содержащего подсказку
		var tipVisX = jQuery(window).width() - (mousex + tipWidth);
		// Определяем дистанцию от ниждего края окна браузера до блока, содержащего подсказку        
		var tipVisY = jQuery(window).height() - (mousey + tipHeight);

		if ( tipVisX < 20 ) { //Если ширина подсказки превышает расстояние от правого края окна браузера до курсора,
			mousex = e.pageX - 8*tipWidth/10 - 2; // то распологаем область с подсказкой по другую сторону от курсора
		} 
		if ( tipVisY < 20 ) { // Если высота подсказки превышает расстояние от нижнего края окна браузера до курсора,
			tipHeight = parseInt(tooltip.css('max-height'));
			tooltip.css('height', tipHeight+"px");
			mousey = position.top - tipHeight;  // то распологаем область с подсказкой над курсором
		} 
		mousex = mousex - position.left - 2*tipWidth/10;
		mousey = mousey - position.top;
		//Непосредственно присваиваем найденные координаты области, содержащей подсказку
		tooltip.css('top', mousey+"px");
		tooltip.css('left', mousex+"px");
});

