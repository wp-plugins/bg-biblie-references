<?php
/*******************************************************************************
   Создание контента цитаты 
   Вызывает bg_bibfers_printVerses() - см. ниже
*******************************************************************************/  
function bg_bibfers_getQuotes($book, $chapter, $type) {

		$pat = array(						// Таблица соответствия azbyka.ru и patriarhia.ru
		// Ветхий Завет
		// Пятикнижие Моисея
		'Gen'	 	=>'gen',							//'Книга Бытия', 
		'Ex'	 	=>'ex',								//'Книга Исход', 
		'Lev'	 	=>'lev',							//'Книга Левит', 
		'Num'	 	=>'num',							//'Книга Числа', 
		'Deut'	 	=>'deu',							//'Второзаконие',
		// «Пророки» (Невиим) 
		'Nav'	 	=>'nav',							//'Книга Иисуса Навина',
		'Judg'		=>'sud',							//'Книга Судей Израилевых', 
		'Rth'	 	=>'ruf',							//'Книга Руфь',
		'1Sam'	 	=>'king1',							//'Первая книга Царств (Первая книга Самуила)', 
		'2Sam'	 	=>'king2',							//'Вторая книга Царств (Вторая книга Самуила)', 
		'1King' 	=>'king3',							//'Третья книга Царств (Первая книга Царей)', 
		'2King' 	=>'king4',							//'Четвёртая книга Царств (Вторая книга Царей)',
		'1Chron' 	=>'para1',							//'Первая книга Паралипоменон (Первая книга Хроник, Первая Летопись)', 
		'2Chron' 	=>'para2',							//'Вторая книга Паралипоменон (Вторая книга Хроник, Вторая Летопись)', 
		'Ezr'	 	=>'ezr1',							//'Книга Ездры (Первая книга Ездры)', 
		'Nehem' 	=>'nee',							//'Книга Неемии', 
		'Est'	 	=>'esf',							//'Книга Есфири',  
		// «Писания» (Ктувим)
		'Job'	 	=>'iov',							//'Книга Иова',
		'Ps' 		=>'ps',								//'Псалтирь', 
		'Prov'	 	=>'prov',							//'Книга Притчей Соломоновых', 
		'Eccl'	 	=>'eccl',							//'Книга Екклезиаста, или Проповедника', 
		'Song'	 	=>'song',							//'Песнь песней Соломона',

		'Is' 		=>'isa',							//'Книга пророка Исайи', 
		'Jer' 		=>'jer',							//'Книга пророка Иеремии',
		'Lam' 		=>'lam',							//'Книга Плач Иеремии', 
		'Ezek'	 	=>'eze',							//'Книга пророка Иезекииля',
		'Dan' 		=>'dan',							//'Книга пророка Даниила', 
		// Двенадцать малых пророков 
		'Hos' 		=>'hos',							//'Книга пророка Осии', 
		'Joel'	 	=>'joe',							//'Книга пророка Иоиля',
		'Am' 		=>'am',								//'Книга пророка Амоса', 
		'Avd' 		=>'avd',							//'Книга пророка Авдия', 
		'Jona'	 	=>'jona',							//'Книга пророка Ионы',
		'Mic' 		=>'mih',							//'Книга пророка Михея', 
		'Naum' 		=>'nau',							//'Книга пророка Наума',
		'Habak' 	=>'avv',							//'Книга пророка Аввакума', 
		'Sofon' 	=>'sof',							//'Книга пророка Софонии', 
		'Hag' 		=>'agg',							//'Книга пророка Аггея', 
		'Zah' 		=>'zah',							//'Книга пророка Захарии',
		'Mal' 		=>'mal',							//'Книга пророка Малахии',
		// Второканонические книги
		'1Mac'	 	=>'mak1',							//'Первая книга Маккавейская',
		'2Mac'	 	=>'mak2',							//'Вторая книга Маккавейская', 
		'3Mac'	 	=>'mak3',							//'Третья книга Маккавейская', 
		'Bar' 		=>'varuh',							//'Книга пророка Варуха', 
		'2Ezr' 		=>'ezr2',							//'Вторая книга Ездры', 
		'3Ezr' 		=>'ezr3',							//'Третья книга Ездры',
		'Judf' 		=>'jdi',							//'Книга Иудифи', 
		'pJer' 		=>'posjer',							//'Послание Иеремии', 
		'Solom' 	=>'prem',							//'Книга Премудрости Соломона',
		'Sir' 		=>'sir',							//'Книга Премудрости Иисуса, сына Сирахова', 
		'Tov' 		=>'tov',							//'Книга Товита',
		// Новый Завет
		// Евангилие
		'Mt' 		=>'mf',								//'Евангелие от Матфея',
		'Mk' 		=>'mk',								//'Евангелие от Марка', 
		'Lk' 		=>'lk',								//'Евангелие от Луки', 
		'Jn' 		=>'jn',								//'Евангелие от Иоанна', 
		// Деяния и послания Апостолов
		'Act' 		=>'act',							//'Деяния святых Апостолов', 
		'Jac'	 	=>'jak',							//'Послание Иакова', 
		'1Pet'	 	=>'pe1',							//'Первое послание Петра', 
		'2Pet'	 	=>'pe2',							//'Второе послание Петра',	
		'1Jn'	 	=>'jn1',							//'Первое послание Иоанна', 
		'2Jn'	 	=>'jn2',							//'Второе послание Иоанна', 
		'3Jn'	 	=>'jn3',							//'Третье послание Иоанна',
		'Juda'	 	=>'jud',							//'Послание Иуды', 
		// Послания апостола Павла
		'Rom' 		=>'rom',							//'Послание апостола Павла к Римлянам', 
		'1Cor'	 	=>'co1',							//'Первое послание апостола Павла к Коринфянам', 
		'2Cor'	 	=>'co2',							//'Второе послание апостола Павла к Коринфянам',
		'Gal' 		=>'gal',							//'Послание апостола Павла к Галатам', 
		'Eph' 		=>'eph',							//'Послание апостола Павла к Ефесянам', 
		'Phil'	 	=>'flp',							//'Послание апостола Павла к Филиппийцам', 
		'Col' 		=>'col',							//'Послание апостола Павла к Колоссянам',
		'1Thes' 	=>'fe1',							//'Первое послание апостола Павла к Фессалоникийцам (Солунянам)',
		'2Thes' 	=>'fe2',							//'Второе послание апостола Павла к Фессалоникийцам (Солунянам)',  
		'1Tim' 		=>'ti1',							//'Первое послание апостола Павла к Тимофею', 
		'2Tim' 		=>'ti2',							//'Второе послание апостола Павла к Тимофею',
		'Tit' 		=>'tit',							//'Послание апостола Павла к Титу', 
		'Phlm'	 	=>'flm',							//'Послание апостола Павла к Филимону', 
		'Hebr'	 	=>'heb',							//'Послание апостола Павла к Евреям', 
		'Apok'	 	=>'rev');							//'Откровение Иоанна Богослова (Апокалипсис)'

/*******************************************************************************
   Преобразование обозначения книги из формата azbyka.ru в формат patriarhia.ru
   чтение и преобразование файла книги
*******************************************************************************/  
	if (!$book) return "";
	$book_file = $pat[$book];																// Имя файла книги
	if (!$book_file) return "";
	$code = file_get_contents(plugins_url( 'bible/'.$book_file , dirname(__FILE__ )));		// Получить данные с сайта
	$json = json_decode($code, true);														// Преобразовать json в массив

	if ($type == "book") $verses = "<h3>".bg_bibfers_getTitle($book)."</h3>";
	else $verses = "";
		
/*******************************************************************************
   Разбор ссылки и формирование текста стихов Библии
  
*******************************************************************************/  
	
	$jj = 0;
	while (preg_match("/\\d+/u", $chapter, $matches, PREG_OFFSET_CAPTURE)) {					// Должно быть число - номер главы 
		$jj++;																					// Защита от зацикливания (не более 10 циклов)
		if ($jj > 10) return "***";
		$ch1 = (int)$matches[0][0];
//		echo " -> ".$matches[0][0];
		$chapter = substr($chapter,(int)$matches[0][1]);
		if (preg_match("/\\:|\\,|\\-/u", $chapter, $matches, PREG_OFFSET_CAPTURE)) {			// Допускается: двоеточие, запятая, тире или <конец строки>
			$sp = $matches[0][0];
//			echo " -> ".$matches[0][0];
			$chapter = substr($chapter,(int)$matches[0][1]);
		} else $sp = "";
		
		if (strcasecmp ($sp, ":") == 0) {
//		Двоеточие - далее стихи
			$ii = 0;
			while (preg_match("/\\d+/u", $chapter, $matches, PREG_OFFSET_CAPTURE)) {			// Должно быть число - номер стиха 
				$ii++;																		// Защита от зацикливания (не более 10 циклов)
				if ($ii >10) return "***";
				$vr1 = (int)$matches[0][0];
//				echo " -> ".$matches[0][0];
				$chapter = substr($chapter,(int)$matches[0][1]);
				if (preg_match("/\\:|\\,|\\-/u", $chapter, $matches, PREG_OFFSET_CAPTURE)) {	// Допускается:  двоеточие, запятая, тире или <конец строки>
					$sp = $matches[0][0];
//					echo " -> ".$matches[0][0];
					$chapter = substr($chapter,(int)$matches[0][1]);
				} else $sp = "";
				if (strcasecmp ($sp, ":") == 0) {											// Если двоеточие, то не номер стиха, а номер главы и далее стихи
					$ch1 = $vr1;
				} else {
					if (strcasecmp ($sp, "-") == 0) {
						preg_match("/\\d+/u", $chapter, $matches, PREG_OFFSET_CAPTURE);		// Должно быть число - номер стиха 
						$vr2 = (int)$matches[0][0];
//						echo " -> ".$matches[0][0];
						$chapter = substr($chapter,(int)$matches[0][1]);
						if (preg_match("/\\,/u", $chapter, $matches, PREG_OFFSET_CAPTURE)) {	// Допускается: запятая или <конец строки>
							$sp = $matches[0][0];
//							echo " -> ".$matches[0][0];
							$chapter = substr($chapter,(int)$matches[0][1]);
						} else $sp = "";
					} else {
						$vr2 = $vr1;
					}
					$verses = $verses.bg_bibfers_printVerses ($json, $ch1, $ch1, $vr1, $vr2, $type);
					if ($sp == "") break;
				}
			}
		} else {
//		Далее до двоеточия только главы
			if (strcasecmp ($sp, "-") == 0) {
				preg_match("/\\d+/u", $chapter, $matches, PREG_OFFSET_CAPTURE);				// Должно быть число - номер главы 
				$ch2 = (int)$matches[0][0];
//				echo " -> ".$matches[0][0];
				$chapter = substr($chapter,(int)$matches[0][1]);
				if (preg_match("/\\,/u", $chapter, $matches, PREG_OFFSET_CAPTURE)) {			// Допускается: запятая или <конец строки>
					$sp = $matches[0][0];
//					echo " -> ".$matches[0][0];
					$chapter = substr($chapter,(int)$matches[0][1]);
				} else $sp = "";
			} else {
				$ch2 = $ch1;
			}
			$verses = $verses.bg_bibfers_printVerses ($json, $ch1, $ch2, 1, 999, $type);
		}
		if ($sp == "") break;
	}
	return $verses;
}
/*******************************************************************************
	Формирование содержания цитаты
  
*******************************************************************************/  
function bg_bibfers_printVerses ($json, $ch1, $ch2, $vr1, $vr2, $type) {
    $class_val = get_option( 'bg_bibfers_class' );
	if ($class_val == "") $class_val = 'bg_bibfers';
	$verses = "";
	$chr = 0;
	$cn_json = count($json);
	for ($i=0; $i < $cn_json; $i++) {
		$ch = (int)$json[$i][part];
		$vr = (int)$json[$i][stix];
		if ( $ch >= $ch1 && $ch <= $ch2) {
			if ( $vr >= $vr1 && $vr <= $vr2) {
				if ($type == 'book') { 																		// Тип: книга
					if ($chr != $ch) {
						$verses = $verses."<h4>".__('Chapter', 'bg_bibfers')." ".$ch."</h4>";					// Печатаем номер главы
						$chr = $ch;
					}
					$pointer = "<span class='".$class_val."_pointer'><em>".$json[$i][stix]."</em></span> ";	// Только номер стиха
				} else if ($type == 'verses') { 																	// Тип: стихи
					$pointer = "<span class='".$class_val."_pointer'><em>".$json[$i][part].":".$json[$i][stix]."</em></span> ";	// Номер главы : номер стиха
				} else if ($type == 'b_verses') { 																	// Тип: стихи
					$pointer = "<span class='".$class_val."_pointer'><em>".$json[$i][ru_book].".".$json[$i][part].":".$json[$i][stix]."</em></span> ";	// Книга. номер главы : номер стиха
				} else {																					// Тип: цитата
					$pointer = "";																			// Ничего
				}
				$verses = $verses.$pointer.strip_tags($json[$i][text]);
				if ($type == 'quotes') {$verses = $verses." ";}													// Если цитата, строку не переводим
				else {$verses = $verses."<br>";}
			}
		}
	}
	return $verses;
}


