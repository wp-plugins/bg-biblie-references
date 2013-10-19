<?php
/* 
    Plugin Name: Bg Bible References 
    Plugin URI: http://bogaiskov.ru/bg_bibfers/
    Description: Плагин подсвечивает ссылки на текст Библии с помощью гиперссылок на сайт <a href="http://azbyka.ru/">Православной энциклопедии "Азбука веры"</a>. / The plugin will highlight references to the Bible text with links to site of <a href="http://azbyka.ru/">Orthodox encyclopedia "The Alphabet of Faith"</a>.
    Author: Vadim Bogaiskov
    Version: 0.8
    Author URI: http://bogaiskov.ru 
*/

/*  Copyright 2013  Vadim Bogaiskov  (email: vadim.bogaiskov@gmail.com)

    This program is free software; you can redistribute it and/or modify
    it under the terms of the GNU General Public License as published by
    the Free Software Foundation; either version 2 of the License, or
    (at your option) any later version.

    This program is distributed in the hope that it will be useful,
    but WITHOUT ANY WARRANTY; without even the implied warranty of
    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
    GNU General Public License for more details.

    You should have received a copy of the GNU General Public License
    along with this program; if not, write to the Free Software
    Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA  02110-1301  USA
*/

/*
Плагин подсвечивает ссылки на текст Библии с помощью гиперссылок на сайт Православной энциклопедии "Азбука веры" (http://azbyka.ru/biblia). 
Текст Библии представлен на церковнославянском, русском, греческом, еврейском и латинском языках. Не требуется никаких настроек. 
Плагин обрабатывает ссылки следующего формата:
	(Ин. 3:16), где «Ин.» - это название книги, 3 - это глава, а 16 - это номер стиха.
	(Ин. 3:16—18) (Книга. Глава: с этого [—] по этот стих)
	(Ин. 3:16—18, 21, 34—36) (Книга. Глава: с этого [—] по этот стих, этот стих, с этого [—] по этот стих)
	(Ин. 3:16—18, 4:4—6) (Книга. Глава: с этого [—] по этот стих, глава: с этого [—] по этот стих)
	(Мф. 5—6) (Книга. С этой [—] по эту главу). 
Допускается указание ссылок в квадратных скобках и без точки после наименования книги. Пробелы игнорируются.
Допускается указание см.: сразу после открывающейся скобки. Варианты: см.: / см. / см: / см

*/


function get_url($parts) {
// Формирование ссылки на http://azbyka.ru/biblia/
	$url = array(						// Книги Священного Писания
		// Ветхий Завет
		'Gen', 'Быт', 
		'Ex', 'Исх', 
		'Lev', 'Лев', 
		'Num', 'Чис', 'Num', 'Числ', 
		'Deut', 'Втор',
		'Nav', 'Нав', 'Nav', 'ИсНав', 
		'Judg', 'Суд', 'Judg', 'Судей', 
		'Rth', 'Руф', 'Rth', 'Руфь', 
		'1Sam', '1Цар', '1Sam', '1Сам',
		'2Sam', '2Цар', '1Sam', '2Сам',
		
		'1King', '3Цар', '1King', '1Царей', 
		'2King', '4Цар', '2King', '2Царей', 
		'1Chron', '1Пар', '1Chron', '1Хр', '1Chron', '1Хрон', '1Chron', '1Лет',
		'2Chron', '2Пар', '2Chron', '2Хр', '2Chron', '2Хрон', '2Chron', '2Лет',
		'Ezr', '1Ездр', 'Ezr', '1Езд', 'Ezr', 'Езд', 'Ezr', 'Ездр', 
		'Nehem', 'Неем', 
		'Est', 'Есф', 'Est', 'Эсф', 
		'Job', 'Иов',
		'Ps', 'Пс', 'Ps', 'Псал', 
		'Prov', 'Притч', 'Prov', 'Прит', 
		
		'Eccl', 'Еккл', 
		'Song', 'Песн',
		'Is', 'Ис', 'Is', 'Исаи', 
		'Jer', 'Иер',
		'Lam', 'Плч','Lam', 'Плач', 
		'Ezek', 'Иез',
		'Dan', 'Дан', 
		'Hos', 'Ос', 'Hos', 'Осии', 
		'Joel', 'Иоил', 'Joel', 'Иоиль', 
		'Am', 'Ам', 'Am', 'Амос',
		
		'Avd', 'Авд', 
		'Jona', 'Ион', 'Jona', 'Иона', 
		'Mic', 'Мих', 
		'Naum', 'Наум',
		'Habak', 'Авв', 
		'Sofon', 'Соф', 
		'Hag', 'Агг', 'Hag', 'Аг', 
		'Zah', 'Зах',
		'Mal', 'Мал',
		// Второканонические книги
		'1Mac', '1Мак',
		'2Mac', '2Мак', 
		'3Mac', '3Мак', 
		'Bar', 'Вар', 
		'2Ezr', '2Ездр', '2Ezr', '2Езд',
		'3Ezr', '3Ездр', '3Ezr', '3Езд',
		'Judf', 'Иудиф', 'Judf', 'Иудифь', 
		'pJer', 'ПослИер', 'pJer', 'Посл.Иер', 
		'Solom', 'Прем', 'Solom', 'ПремСол', 
		'Sir', 'Сир', 'Sir', 'Сирах', 
		'Tov', 'Тов', 'Tov', 'Товит', 
		// Новый Завет
		// Евангилие
		'Mt', 'Мф', 'Mt', 'Мт', 'Mt', 'Матф', 
		'Mk', 'Мк', 'Mk', 'Mp', 'Mk', 'Mаp', 'Mk', 'Mapк', 
		'Lk', 'Лк', 'Lk', 'Лук', 'Lk', 'Луки',
		'Jn', 'Ин', 'Jn', 'Иоан',
		// Деяния послания Апостолов
		'Act', 'Деян', 'Act', 'Деяния', 
		'Jac', 'Иак', 
		'1Pet', '1Пет', '1Pet', '1Петра',
		'2Pet', '2Пет',	'2Pet', '2Петра',	
		'1Jn', '1Ин', '1Jn', '1Иоан', 
		'2Jn', '2Ин', '2Jn', '2Иоан', 
		'3Jn', '3Ин', '3Jn', '3Иоан', 
		'Juda', 'Иуд', 
		// Послания апостола Павла
		'Rom', 'Рим', 'Rom', 'Римл', 
		'1Cor', '1Кор', 
		'2Cor', '2Кор',
		'Gal', 'Гал', 
		'Eph', 'Еф', 'Eph', 'Ефес', 
		'Phil', 'Флп', 'Phil', 'Фил', 'Phil', 'Филип',  
		'Col', 'Кол',
		'1Thes', '1Сол','1Thes', '1Фес', 
		'2Thes', '2Сол', '2Thes', '2Фес', 
		'1Tim', '1Тим', 
		'2Tim', '2Тим',
		'Tit', 'Тит', 
		'Phlm', 'Флм', 'Phlm', 'Филим', 
		'Hebr', 'Евр', 
		'Apok', 'Откр', 'Apok', 'Отк', 'Apok', 'Апок');
		
	$book = array(						// Полные названия Книг Священного Писания
		// Ветхий Завет
		'Gen', 'Книга Бытия', 
		'Ex', 'Книга Исход', 
		'Lev', 'Книга Левит', 
		'Num', 'Книга Числа', 
		'Deut', 'Второзаконие',
		'Nav', 'Книга Иисуса Навина',
		'Judg', 'Книга Судей Израилевых', 
		'Rth', 'Книга Руфь',
		'1Sam', ' Первая книга Царств (Первая книга Самуила)', 
		'2Sam', 'Вторая книга Царств (Вторая книга Самуила)', 
		
		'1King', 'Третья книга Царств (Первая книга Царей)', 
		'2King', 'Четвёртая книга Царств (Вторая книга Царей)',
		'1Chron', ' Первая книга Паралипоменон (Первая книга Хроник, Первая Летопись)', 
		'2Chron', 'Вторая книга Паралипоменон (Вторая книга Хроник, Вторая Летопись)', 
		'Ezr', ' Книга Ездры (Первая книга Ездры)', 
		'Nehem', ' Книга Неемии', 
		'Est', 'Книга Есфири',  
		'Job', 'Книга Иова',
		'Ps', 'Псалтирь', 
		'Prov', 'Книга Притчей Соломоновых', 
		
		'Eccl', 'Книга Екклезиаста, или Проповедника', 
		'Song', 'Песнь песней Соломона',
		'Is', 'Книга пророка Исайи', 
		'Jer', 'Книга пророка Иеремии',
		'Lam', 'Книга Плач Иеремии', 
		'Ezek', 'Книга пророка Иезекииля',
		'Dan', 'Книга пророка Даниила', 
		'Hos', 'Книга пророка Осии', 
		'Joel', 'Книга пророка Иоиля',
		'Am', 'Книга пророка Амоса', 
		
		'Avd', 'Книга пророка Авдия', 
		'Jona', 'Книга пророка Ионы',
		'Mic', 'Книга пророка Михея', 
		'Naum', 'Книга пророка Наума',
		'Habak', 'Книга пророка Аввакума', 
		'Sofon', 'Книга пророка Софонии', 
		'Hag', 'Книга пророка Аггея', 
		'Zah', 'Книга пророка Захарии',
		'Mal', 'Книга пророка Малахии',
		// Второканонические книги
		'1Mac', 'Первая книга Маккавейская',
		'2Mac', 'Вторая книга Маккавейская', 
		'3Mac', 'Третья книга Маккавейская', 
		'Bar', 'Книга пророка Варуха', 
		'2Ezr', 'Вторая книга Ездры', 
		'3Ezr', 'Третья книга Ездры',
		'Judf', 'Книга Иудифи', 
		'pJer', 'Послание Иеремии', 
		'Solom', 'Книга Премудрости Соломона',
		'Sir', 'Книга Премудрости Иисуса, сына Сирахова', 
		'Tov', 'Книга Товита',
		// Новый Завет
		// Евангилие
		'Mt', 'Евангелие от Матфея',
		'Mk', 'Евангелие от Марка', 
		'Lk', 'Евангелие от Луки', 
		'Jn', 'Евангелие от Иоанна', 
		// Деяния и послания Апостолов
		'Act', 'Деяния святых Апостолов', 
		'Jac', 'Послание Иакова', 
		'1Pet', 'Первое послание Петра', 
		'2Pet', 'Второе послание Петра',	
		'1Jn', 'Первое послание Иоанна', 
		'2Jn', 'Второе послание Иоанна', 
		'3Jn', 'Третье послание Иоанна',
		'Juda', 'Послание Иуды', 
		// Послания апостола Павла
		'Rom', 'Послание апостола Павла к Римлянам', 
		'1Cor', 'Первое послание апостола Павла к Коринфянам', 
		'2Cor', 'Второе послание апостола Павла к Коринфянам',
		'Gal', 'Послание апостола Павла к Галатам', 
		'Eph', 'Послание апостола Павла к Ефесянам', 
		'Phil', 'Послание апостола Павла к Филиппийцам', 
		'Col', 'Послание апостола Павла к Колоссянам',
		'1Thes', 'Первое послание апостола Павла к Фессалоникийцам (Солунянам)',
		'2Thes', 'Второе послание апостола Павла к Фессалоникийцам (Солунянам)',  
		'1Tim', 'Первое послание апостола Павла к Тимофею', 
		'2Tim', 'Второе послание апостола Павла к Тимофею',
		'Tit', 'Послание апостола Павла к Титу', 
		'Phlm', 'Послание апостола Павла к Филимону', 
		'Hebr', 'Послание апостола Павла к Евреям', 
		'Apok', 'Откровение Иоанна Богослова (Апокалипсис)');
		
	$cn_url = count($url) / 2;
	$cn_book = count($book) / 2;
	$mainaddr = "http://azbyka.ru/biblia/?";
	$title = preg_replace("/\\s|&nbsp\\;/u", '',$parts[3]); 			// Убираем пробельные символы, включая пробел, табуляцию, переводы строки 
	$chapter = preg_replace("/\\s|&nbsp\\;/u", '', $parts[7]);			// и другие юникодные пробельные символы, а также неразрывные пробелы &nbsp;
	$chapter = preg_replace("/—|–/u", '-', $chapter);					// Замена разных вариантов тире на обычный
	preg_match("/[\\:\\,\\-]/u", $chapter, $matches);
	if (strcasecmp($matches[0], ',') == 0) {
		$chapter = str_replace(",", ':', $chapter);				// Первое число всегда номер главы. Если глава отделена запятой, заменяем ее на двоеточие.
	}
	$ref = $title .".". $chapter;
	
	for ($i=0; $i < $cn_url; $i++) {
		if (strcasecmp($url[$i*2+1],  $title) == 0) {
			$title_book = "";
			for ($j=0; $j < $cn_book; $j++) {
				if (strcasecmp($book[$j*2],$url[$i*2]) == 0) {
					$title_book = $book[$j*2+1];
					break;
				}
			}
			$fullurl = $mainaddr.$url[$i*2];
			return "href='".str_replace($title, $fullurl, $ref)."' title='".$title_book."\nгл. ".$chapter. "' "; 
		}
	}

	return "#";
}

function bible_proc($txt) {

// Ищем все вхождения ссылок на Библию
	preg_match_all("/[\\(\\[](см\\.?\\:?(\\s|&nbsp\\;)*)?(\\d?(\\s|&nbsp\\;)*[А-яA-z]{2,8})((\\.|\\s|&nbsp\\;)*)(\\d+((\\s|&nbsp\\;)*[\\:\\,\\-—–](\\s|&nbsp\\;)*\\d+)*)[\\]\\)]/ui", $txt, $matches);
	
	$cnt = count($matches[0]);
	if ($cnt > 0) {
		for ($i = 0; $i < $cnt; $i++) {
		// Проверим по каждому паттерну. 
			preg_match("/[\\(\\[](см\\.?\\:?(\\s|&nbsp\\;)*)?(\\d?(\\s|&nbsp\\;)*[А-яA-z]{2,8})((\\.|\\s|&nbsp\\;)*)(\\d+((\\s|&nbsp\\;)*[\\:\\,\\-—–](\\s|&nbsp\\;)*\\d+)*)[\\]\\)]/ui", $matches[0][$i], $mt);
			$cn = count($mt);
			if ($cn > 0) {
				$addr = get_url($mt);
				if (strcasecmp($addr, "#") != 0) {
					$newmt = "<a " .$addr. "target='_blank'>" .$matches[0][$i]. "</a>";
					$txt = str_replace($matches[0][$i], $newmt, $txt);
				}			
			}
		}
	}
	
	return $txt;
}

/*
	Загрузка плагина
*/

if ( !defined('ABSPATH') ) { 							// Запрет прямого запуска скрипта
	die( 'Sorry, you are not allowed to access this page directly.' ); 
}	

function bg_bibfers($content) {
//	if ( is_single() || is_page())
		$content = bible_proc($content);
	return $content;
}
	
if ( defined('ABSPATH') && defined('WPINC') ) {
	add_filter( 'the_content', 'bg_bibfers' );
}
	
?>