<?php
function bg_bibfers_getBook($title) {
	$url = array(						// Книги Священного Писания
		// Ветхий Завет
		// Пятикнижие Моисея															
		'Gen', 		'Бытие|Быт|Буття|Бут|1M', 				
		'Ex', 		'Исх|Вихід|Вих|2М',  					
		'Lev', 		'Левит|Лев|Лв|3М',  							
		'Num', 		'Числа|Числ|Чис|Чс|4М',  						
		'Deut', 	'Втор|Повтор|Повт|5М', 							
		// «Пророки» (Невиим) 
		'Nav', 		'Нав|ИсНав|Iс\.Нав|Iсус|Єг', 						
		'Judg', 	'Судей|Суддiв|Суд|Сд', 						
		'Rth', 		'Руфь|Руф|Рут', 						
		'1Sam', 	'1Цар|1Сам|1См|1С',						
		'2Sam', 	'2Цар|2Сам|2См|2С',						
		'1King', 	'3Цар|1Царей|1Царiв|1Цр|1Ц', 					
		'2King', 	'4Цар|2Царей|2Царiв|2Цр|2Ц', 					
		'1Chron', 	'1Пар|1Хрон|1Хр|1Лет',		
		'2Chron', 	'2Пар|2Хрон|2Хр|2Лет',		
		'Ezr', 		'1Ездр|1Езд|Ездр|Езд|Ез', 				
		'Nehem', 	'Неемія|Неем|Нм', 						
		'Est', 		'Есф|Эсф|Естер|Ест|Ес', 							
		'Job', 		'Иов|Йов',								
		'Ps', 		'Псалми|Псал|Пс', 							
		'Prov', 	'Притчи|Притч|Прит|Прип|Пр', 					
		'Eccl', 	'Еккл|Екк|Екл|Ек', 							
		'Song', 	'Песн|Пiсня|Пiсн',							
		'Is', 		'Исайи|Исаи|Ис|Iсая|Iс', 							
		'Jer', 		'Иер|Єремiя|Єрем|Єр',								
		'Lam', 		'Плч|Плач', 						
		'Ezek', 	'Иез|Єзек|Єз',							
		'Dan', 		'Даниїл|Дан|Днл', 								
		// Двенадцать малых пророков 
		'Hos', 		'Осии|Осiя|Ос', 							
		'Joel', 	'Иоиль|Иоил|Йоїл', 					
		'Am', 		'Амос|Амс|Ам',							
		'Avd', 		'Авд|Овдiй|Овд', 								
		'Jona', 	'Иона|Ион|Йона|Йон', 						
		'Mic', 		'Михей|Мих|Мх', 								
		'Naum', 	'Наум',							
		'Habak', 	'Аввак|Авв|Ав', 							
		'Sofon', 	'Софон|Соф', 							
		'Hag', 		'Агг|Аг|Огiй|Ог', 							
		'Zah', 		'Захар|Зах|Зхр',								
		'Mal', 		'Малах|Мал|Млх',								
		// Второканонические книги
		'1Mac', 	'1Мак',							
		'2Mac', 	'2Мак', 							
		'3Mac', 	'3Мак', 							
		'Bar', 		'Варух|Вар', 								
		'2Ezr', 	'2Ездр|2Езд',						
		'3Ezr', 	'3Ездр|3Езд',						
		'Judf', 	'Иудифь|Иудиф|Юдит', 					
		'pJer', 	'ПослИер|Посл\.Иер|ПослЄр|Посл\.Єр', 			
		'Solom', 	'Прем|ПремСол', 				
		'Sir', 		'Сирах|Сир', 						
		'Tov', 		'Товит|Тов', 						
		// Новый Завет
		// Евангилие
		'Mt', 		'Мф|Мт|Матф|Матв|Мтв|Мв', 						
		'Mk', 		'Марк|Мар|Мр|Мк', 					
		'Lk', 		'Луки|Лук|Лк',						
		'Jn', 		'Иоанна|Иоан|Ин|Iван|Iв|Iн',							
		// Деяния и послания Апостолов
		'Act', 		'Деяния|Деян|Дiї', 						
		'Jac', 		'Иакова|Иаков|Иак|Яков|Як', 								
		'1Pet', 	'1Петра|1Петр|1Пет',					
		'2Pet',		'2Петра|2Петр|2Пет',					
		'1Jn', 		'1Иоанна|1Иоан|1Ин|1Iван|1Iв|1Iн', 						
		'2Jn', 		'2Иоанна|2Иоан|2Ин|2Iван|2Iв|2Iн', 						
		'3Jn', 		'3Иоанна|3Иоан|3Ин|3Iван|3Iв|3Iн', 						
		'Juda', 	'Иуды|Иуда|Иуд|Юда|Юди|Юд', 							
		// Послания апостола Павла
		'Rom', 		'Римл|Рим', 						
		'1Cor', 	'1Кор', 							
		'2Cor', 	'2Кор',							
		'Gal', 		'Галат|Гал', 								
		'Eph', 		'Ефесян|Ефес|Еф', 							
		'Phil', 	'Филип|Фил|Флп',  				
		'Col', 		'Колос|Кол',								
		'1Thes', 	'1Солун|1Сол|1Фес', 					
		'2Thes', 	'2Солун|2Сол|2Фес', 					
		'1Tim', 	'1Тимоф|1Тим', 							
		'2Tim', 	'2Тимоф|2Тим',							
		'Tit', 		'Титу|Тита|Тит', 								
		'Phlm', 	'Филим|Флм', 						
		'Hebr', 	'Евреям|Евр|Євреїв|Євр', 							
		'Apok', 	'Откр|Отк|Апок|Об\'явл|Об');					
	$cn_url = count($url) / 2;
	for ($i=0; $i < $cn_url; $i++) {									// Просматриваем всю таблицу соответствия сокращений наименований книг
		$regvar = "/".$url[$i*2+1]."|".$url[$i*2]."/iu";				// Формируем регулярное выражение для поиска обозначения, включая латинское наименование
		preg_match_all($regvar, $title, $mts);							// Ищем все вхождения указанного наименования
		$cnt = count($mts[0]);
		for ($k=0; $k < $cnt; $k++) {									// Из всех вхождений находим точное соответствие указанному наименованию
			if (strcasecmp($mts[0][$k],  $title) == 0) {						
				return $url[$i*2];										// Обозначение книги латынью
			}
		}
	}
	return "";
}

/*******************************************************************************
   Полное наименование книги Библии
   Используется в функции bg_bibfers_get_url()
*******************************************************************************/  

function bg_bibfers_getTitle($book) {
	$bookTitle = array(						// Полные названия Книг Священного Писания
		// Ветхий Завет
		// Пятикнижие Моисея
		'Gen' 		=>'Книга Буття', 
		'Ex' 		=>'Книга Вихід', 
		'Lev' 		=>'Книга Левит', 
		'Num' 		=>'Книга Числа', 
		'Deut' 		=>'Повторення Закону',
		// «Пророки» (Невиим) 
		'Nav' 		=>'Книга Ісуса Навина',
		'Judg'		=>'Книга Суддiв', 
		'Rth' 		=>'Книга Рут',
		'1Sam' 		=>'Перша книга Самуїлова', 
		'2Sam' 		=>'Друга книга Самуїлова', 
		'1King' 	=>'Перша книга царів', 
		'2King' 	=>'Друга книга царів',
		'1Chron' 	=>'Перша книга хроніки', 
		'2Chron' 	=>'Друга книга хроніки', 
		'Ezr' 		=>'Книга Ездри', 
		'Nehem' 	=>'Книга Неемії', 
		'Est' 		=>'Книга Естер',  
		// «Писания» (Ктувим)
		'Job' 		=>'Книга Йова',
		'Ps' 		=>'Псалми', 
		'Prov' 		=>'Книга приказок Соломонових', 
		'Eccl' 		=>'Книга Екклезіястова', 
		'Song' 		=>'Пiсня над пiснями',

		'Is' 		=>'Книга пророка Ісаї', 
		'Jer' 		=>'Книга пророка Єремії',
		'Lam' 		=>'Книга Плач Єремії', 
		'Ezek'	 	=>'Книга пророка Єзекіїля',
		'Dan' 		=>'Книга пророка Даниїла', 
		// Двенадцать малых пророков 
		'Hos' 		=>'Книга пророка Осії', 
		'Joel'	 	=>'Книга пророка Йоіла',
		'Am' 		=>'Книга пророка Амоса', 
		'Avd' 		=>'Книга пророка Овдія', 
		'Jona' 		=>'Книга пророка Йони',
		'Mic' 		=>'Книга пророка Михея', 
		'Naum' 		=>'Книга пророка Наума',
		'Habak' 	=>'Книга пророка Аввакума', 
		'Sofon' 	=>'Книга пророка Софонії', 
		'Hag' 		=>'Книга пророка Огія', 
		'Zah' 		=>'Книга пророка Захарія',
		'Mal' 		=>'Книга пророка Малахії',
		// Второканонические книги
		'1Mac' 		=>'Перша книга Макавеїв',
		'2Mac' 		=>'Друга книга Макавеїв', 
		'3Mac' 		=>'Третя книга Макавеїв', 
		'Bar' 		=>'Книга пророка Варуха', 
		'2Ezr' 		=>'Друга книга Ездри', 
		'3Ezr' 		=>'Третя книга Ездри',
		'Judf' 		=>'Книга Юдити', 
		'pJer' 		=>'Лист Єремії', 
		'Solom' 	=>'Книга Премудрості Соломона',
		'Sir' 		=>'Книга Премудрості Ісуса, сина Сираха', 
		'Tov' 		=>'Книга Товита',
		// Новый Завет
		// Евангилие
		'Mt' 		=>'Євангеліє від Матвія',
		'Mk' 		=>'Євангеліє від Марка', 
		'Lk' 		=>'Євангеліє від Луки', 
		'Jn' 		=>'Євангеліє від Івана', 
		// Деяния и послания Апостолов
		'Act' 		=>'Дії Апостолів', 
		'Jac' 		=>'Соборне послання апостола Якова', 
		'1Pet'	 	=>'Перше соборне послання апостола Петра', 
		'2Pet'	 	=>'Друге соборне послання апостола Петра',	
		'1Jn' 		=>'Перше соборне послання апостола Івана', 
		'2Jn' 		=>'Друге соборне послання апостола Івана', 
		'3Jn' 		=>'Третє соборне послання апостола Івана',
		'Juda'	 	=>'Соборне послання апостола Юди', 
		// Послания апостола Павла
		'Rom' 		=>'Послання апостола Павла до римлян', 
		'1Cor' 		=>'Перше послання апостола Павла до коринтян', 
		'2Cor' 		=>'Друге послання апостола Павла до коринтян',
		'Gal'	 	=>'Послання апостола Павла до галатів', 
		'Eph' 		=>'Послання апостола Павла до ефесян', 
		'Phil' 		=>'Послання апостола Павла до филип\'ян', 
		'Col' 		=>'Послання апостола Павла до колоссян',
		'1Thes' 	=>'Перше послання апостола Павла до солунян',
		'2Thes' 	=>'Друге послання апостола Павла до солунян',  
		'1Tim' 		=>'Перше послання апостола Павла Тимофію', 
		'2Tim'	 	=>'Друге послання апостола Павла Тимофію',
		'Tit' 		=>'Послання апостола Павла до Тита', 
		'Phlm'	 	=>'Послання апостола Павла до Филимона', 
		'Hebr'	 	=>'Послання апостола Павла до Євреїв', 
		'Apok' 		=>'Об\'явлення Івана Богослова (Апокаліпсис)');

	// Возвращаем полное наименование книги Библии
	return $bookTitle[$book];							// Полное наименование книги Библии
}

/*******************************************************************************
   Короткое наименование книги Библии
   Используется в функции bg_bibfers_bible_proc()
*******************************************************************************/  

function bg_bibfers_getshortTitle($book) {
	$shortTitle = array(						// Книги Священного Писания
		// Ветхий Завет
		// Пятикнижие Моисея															
		'Gen'		=>"Бут.", 
		'Ex'		=>"Вих.", 
		'Lev'		=>"Лев.",
		'Num'		=>"Чис.",
		'Deut'		=>"Повт.",
		// «Пророки» (Невиим) 
		'Nav'		=>"Iсус.",
		'Judg'		=>"Суд.",
		'Rth'		=>"Рут.",
		'1Sam'		=>"1Сам.",
		'2Sam'		=>"2Сам.",
		'1King'		=>"1Царiв.",
		'2King'		=>"2Царiв.",
		'1Chron'	=>"1Хрон.",
		'2Chron'	=>"2Хрон.",
		'Ezr'		=>"Ездр.",
		'Nehem'		=>"Неем.",
		'Est'		=>"Ест.",
		// «Писания» (Ктувим)
		'Job'		=>"Йов.",
		'Ps'		=>"Пс.",
		'Prov'		=>"Прит.", 
		'Eccl'		=>"Еккл.",
		'Song'		=>"Пiсн.",
		'Is'		=>"Iс.",
		'Jer'		=>"Єр.",
		'Lam'		=>"Плч.",
		'Ezek'		=>"Єз.",
		'Dan'		=>"Дан.",	
		// Двенадцать малых пророков 
		'Hos'		=>"Ос.",
		'Joel'		=>"Йоїл.",
		'Am'		=>"Ам.",
		'Avd'		=>"Овд.",
		'Jona'		=>"Йон.",
		'Mic'		=>"Мих.",
		'Naum'		=>"Наум.",
		'Habak'		=>"Авв.",
		'Sofon'		=>"Соф.",
		'Hag'		=>"Ог.",
		'Zah'		=>"Зах.",
		'Mal'		=>"Мал.",
		// Второканонические книги
		'1Mac'		=>"1Мак.",
		'2Mac'		=>"2Мак.",
		'3Mac'		=>"3Мак.",
		'Bar'		=>"Вар.",
		'2Ezr'		=>"2Езд.",
		'3Ezr'		=>"3Езд.",
		'Judf'		=>"Юдит.",
		'pJer'		=>"ПослИер.",
		'Solom'		=>"Прем.",
		'Sir'		=>"Сир.",
		'Tov'		=>"Тов.",
		// Новый Завет
		// Евангилие
		'Mt'		=>"Мв.",
		'Mk'		=>"Мк.",
		'Lk'		=>"Лк.",
		'Jn'		=>"Iн.",
		// Деяния и послания Апостолов
		'Act'		=>"Дiї.",
		'Jac'		=>"Як.",
		'1Pet'		=>"1Пет.",
		'2Pet'		=>"2Пет.",
		'1Jn'		=>"1Iн.", 
		'2Jn'		=>"2Iн.",
		'3Jn'		=>"3Iн.",
		'Juda'		=>"Юд.",
		// Послания апостола Павла
		'Rom'		=>"Рим.",
		'1Cor'		=>"1Кор.",
		'2Cor'		=>"2Кор.",
		'Gal'		=>"Гал.",
		'Eph'		=>"Еф.",
		'Phil'		=>"Флп.",
		'Col'		=>"Кол.",
		'1Thes'		=>"1Сол.",
		'2Thes'		=>"2Сол.",
		'1Tim'		=>"1Тим.",
		'2Tim'		=>"2Тим.",
		'Tit'		=>"Тит.",
		'Phlm'		=>"Флм.",
		'Hebr'		=>"Євр.",
		'Apok'		=>"Об.");

	// Возвращаем короткое наименование книги Библии
	return $shortTitle[$book];						// Короткое наименование книги Библии
}