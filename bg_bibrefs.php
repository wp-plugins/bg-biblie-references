<?php
/* 
    Plugin Name: Bg Bible References 
    Plugin URI: http://bogaiskov.ru/bg_bibfers/
    Description: Плагин подсвечивает ссылки на текст Библии с помощью гиперссылок на сайт <a href="http://azbyka.ru/">Православной энциклопедии "Азбука веры"</a>. / The plugin will highlight references to the Bible text with links to site of <a href="http://azbyka.ru/">Orthodox encyclopedia "The Alphabet of Faith"</a>.
    Author: Vadim Bogaiskov
    Version: 1.0.0
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

/*****************************************************************************************
	Блок загрузки плагина
	
******************************************************************************************/

if ( !defined('ABSPATH') ) { 										// Запрет прямого запуска скрипта
	die( 'Sorry, you are not allowed to access this page directly.' ); 
}

define('BG_BIBREFS_URL', dirname( plugin_basename( __FILE__ )));	// Путь к папке плагина

// Таблица стилей для плагина
wp_enqueue_style( "bg_bibfers_styles", plugins_url( '/css/styles.css' , plugin_basename(__FILE__) ) );

// Загрузка интернационализации
load_plugin_textdomain( 'bg_bibfers', false, BG_BIBREFS_URL . '/languages/' );

// Регистрируем крючок для обработки контента при его загрузке
if ( defined('ABSPATH') && defined('WPINC') ) {
	add_filter( 'the_content', 'bg_bibfers' );
}

// Регистрируем крючок для добавления меню администратора
add_action('admin_menu', 'bg_bibfers_add_pages');

// Регистрируем крючок на удаление плагина
if (function_exists('register_uninstall_hook')) {
	register_uninstall_hook(__FILE__, 'bg_bibfers_deinstall');
}
 
/*****************************************************************************************
	Функции запуска плагина
	
******************************************************************************************/
 
// Функция обработки ссылок на Библию 
function bg_bibfers($content) {
//	if ( is_single() || is_page())
		$content = bg_bibfers_bible_proc($content);
	return $content;
}
// Функция действия перед крючком добавления меню
function bg_bibfers_add_pages() {
    // Добавим новое подменю в раздел Параметры 
    add_options_page( __('Bible References', 'bg_bibfers' ), __('Bible References', 'bg_bibfers' ), 8, __FILE__, 'bg_bibfers_options_page');
}	
// Задание параметров по умолчанию
function bg_bibrefs_options_ini () {
	add_option('bg_bibfers_c_lang', "c");
	add_option('bg_bibfers_r_lang', "r");
	add_option('bg_bibfers_g_lang');
	add_option('bg_bibfers_l_lang');
	add_option('bg_bibfers_i_lang');
	add_option('bg_bibfers_c_font', "ucs");
	add_option('bg_bibfers_target', "_blank");
	add_option('bg_bibfers_class', "bg_bibfers");
}

// Очистка таблицы параметров при удалении плагина
function bg_bibfers_deinstall() {
	delete_option('bg_bibfers_c_lang');
	delete_option('bg_bibfers_r_lang');
	delete_option('bg_bibfers_g_lang');
	delete_option('bg_bibfers_l_lang');
	delete_option('bg_bibfers_i_lang');
	delete_option('bg_bibfers_c_font');
	delete_option('bg_bibfers_target');
	delete_option('bg_bibfers_class');

	delete_option('bg_bibfers_submit_hidden');
}

/******************************************************************************************************************************************
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

********************************************************************************************************************************************/

function bg_bibfers_get_url($parts) {
// Формирование ссылки на http://azbyka.ru/biblia/
	$url = array(						// Книги Священного Писания
		// Ветхий Завет
		// Пятикнижие Моисея															
		// translators: abbr. Genesis
		'Gen', 		__('Gen', 'bg_bibfers'), 'Gen', 'Быт', 								
		// translators: abbr. Exodus
		'Ex', 		__('Ex', 'bg_bibfers'), 'Ex', 'Исх',  								
		// translators: abbr. Leviticus
		'Lev', 		__('Lev', 'bg_bibfers'), 'Lev', 'Лев',  							
		// translators: abbr. Numbers
		'Num', 		__('Num', 'bg_bibfers'), 'Num', 'Чис|Числ',  						
		// translators: abbr. Deuteronomy
		'Deut', 	__('Deut', 'bg_bibfers'), 'Deut', 'Втор', 							
		// «Пророки» (Невиим) 
		// translators: abbr. Joshua (Iesous)
		'Nav', 		__('Nav', 'bg_bibfers'), 'Nav', 'Нав|ИсНав', 						
		// translators: abbr. Judges
		'Judg', 	__('Judg', 'bg_bibfers'), 'Judg', 'Суд|Судей', 						
		// translators: abbr. Ruth
		'Rth', 		__('Rth', 'bg_bibfers'), 'Rth', 'Руф|Руфь', 						
		// translators: abbr. 1 Samuel (1 Kingdoms)
		'1Sam', 	__('1Sam', 'bg_bibfers'), '1Sam', '1Цар|1Сам',						
		// translators: abbr. 2 Samuel (2 Kingdoms)
		'2Sam', 	__('2Sam', 'bg_bibfers'), '2Sam', '2Цар|2Сам',						
		// translators: abbr. 1 Kings (3 Kingdoms)
		'1King', 	__('1King', 'bg_bibfers'), '1King', '3Цар|1Царей', 					
		// translators: abbr. 2 Kings (4 Kingdoms)
		'2King', 	__('2King', 'bg_bibfers'), '2King', '4Цар|2Царей', 					
		// translators: abbr. 1 Chronicles (1 Paralipomenon)
		'1Chron', 	__('1Chron', 'bg_bibfers'), '1Chron', '1Пар|1Хр|1Хрон|1Лет',		
		// translators: abbr. 2 Chronicles (2 Paralipomenon)
		'2Chron', 	__('2Chron', 'bg_bibfers'), '2Chron', '2Пар|2Хр|2Хрон|2Лет',		
		// translators: abbr. 1 Esdras
		'Ezr', 		__('Ezr', 'bg_bibfers'), 'Ezr', '1Ездр|1Езд|Езд|Ездр', 				
		// translators: abbr. Nehemiah (2 Esdras)
		'Nehem', 	__('Nehem', 'bg_bibfers'), 'Nehem', 'Неем', 						
		// translators: abbr. Esther
		'Est', 		__('Est', 'bg_bibfers'), 'Est', 'Есф|Эсф', 							
		// «Писания» (Ктувим)
		// translators: abbr. Job
		'Job', 		__('Job', 'bg_bibfers'), 'Job', 'Иов',								
		// translators: abbr. Psalms
		'Ps', 		__('Ps', 'bg_bibfers'), 'Ps', 'Пс|Псал', 							
		// translators: abbr. Proverbs
		'Prov', 	__('Prov', 'bg_bibfers'), 'Prov', 'Притч|Прит', 					
		// translators: abbr. Ecclesiastes
		'Eccl', 	__('Eccl', 'bg_bibfers'), 'Eccl', 'Еккл', 							
		// translators: abbr. Song of Songs (Aisma Aismaton)
		'Song', 	__('Song', 'bg_bibfers'), 'Song', 'Песн',							
		// translators: abbr. Isaiah
		'Is', 		__('Is', 'bg_bibfers'), 'Is', 'Ис|Исаи', 							
		// translators: abbr. Jeremiah
		'Jer', 		__('Jer', 'bg_bibfers'), 'Jer', 'Иер',								
		// translators: abbr. Lamentations
		'Lam', 		__('Lam', 'bg_bibfers'), 'Lam', 'Плч|Плач', 						
		// translators: abbr. Ezekiel
		'Ezek', 	__('Ezek', 'bg_bibfers'), 'Ezek', 'Иез',							
		// translators: abbr. Daniel
		'Dan', 		__('Dan', 'bg_bibfers'), 'Dan', 'Дан', 								
		// Двенадцать малых пророков 
		// translators: abbr. Hosea
		'Hos', 		__('Hos', 'bg_bibfers'), 'Hos', 'Ос|Осии', 							
		// translators: abbr. Joel
		'Joel', 	__('Joel', 'bg_bibfers'), 'Joel', 'Иоил|Иоиль', 					
		// translators: abbr. Amos
		'Am', 		__('Am', 'bg_bibfers'), 'Am', 'Ам|Амос',							
		// translators: abbr. Obadiah
		'Avd', 		__('Avd', 'bg_bibfers'), 'Avd', 'Авд', 								
		// translators: abbr. Jonah
		'Jona', 	__('Jona', 'bg_bibfers'), 'Jona', 'Ион|Иона', 						
		// translators: abbr. Micah
		'Mic', 		__('Mic', 'bg_bibfers'), 'Mic', 'Мих', 								
		// translators: abbr. Nahum
		'Naum', 	__('Naum', 'bg_bibfers'), 'Naum', 'Наум',							
		// translators: abbr. Habakkuk
		'Habak', 	__('Habak', 'bg_bibfers'), 'Habak', 'Авв', 							
		// translators: abbr. Zephaniah
		'Sofon', 	__('Sofon', 'bg_bibfers'), 'Sofon', 'Соф', 							
		// translators: abbr. Haggai
		'Hag', 		__('Hag', 'bg_bibfers'), 'Hag', 'Агг|Аг', 							
		// translators: abbr. Zechariah
		'Zah', 		__('Zah', 'bg_bibfers'), 'Zah', 'Зах',								
		// translators: abbr. Malachi
		'Mal', 		__('Mal', 'bg_bibfers'), 'Mal', 'Мал',								
		// Второканонические книги
		// translators: abbr. 1 Maccabees
		'1Mac', 	__('1Mac', 'bg_bibfers'), '1Mac', '1Мак',							
		// translators: abbr. 2 Maccabees
		'2Mac', 	__('2Mac', 'bg_bibfers'), '2Mac', '2Мак', 							
		// translators: abbr. 3 Maccabees
		'3Mac', 	__('3Mac', 'bg_bibfers'), '3Mac', '3Мак', 							
		// translators: abbr. Baruch
		'Bar', 		__('Bar', 'bg_bibfers'), 'Bar', 'Вар', 								
		// translators: abbr. 2 Esdras
		'2Ezr', 	__('2Ezr', 'bg_bibfers'), '2Ezr', '2Ездр|2Езд',						
		// translators: abbr. 3 Esdras
		'3Ezr', 	__('3Ezr', 'bg_bibfers'), '3Ezr', '3Ездр|3Езд',						
		// translators: abbr. Judith
		'Judf', 	__('Judf', 'bg_bibfers'), 'Judf', 'Иудиф|Иудифь', 					
		// translators: abbr. Letter of Jeremiah
		'pJer', 	__('pJer', 'bg_bibfers'), 'pJer', 'ПослИер|Посл\\.Иер', 			
		// translators: abbr. Wisdom
		'Solom', 	__('Solom', 'bg_bibfers'), 'Solom', 'Прем|ПремСол', 				
		// translators: abbr. Sirach
		'Sir', 		__('Sir', 'bg_bibfers'), 'Sir', 'Сир|Сирах', 						
		// translators: abbr. Tobit (Tobias)
		'Tov', 		__('Tov', 'bg_bibfers'), 'Tov', 'Тов|Товит', 						
		// Новый Завет
		// Евангилие
		// translators: abbr. Matthew			
		'Mt', 		__('Mt', 'bg_bibfers'), 'Mt', 'Мф|Мт|Матф', 						
		// translators: abbr. Mark					
		'Mk', 		__('Mk', 'bg_bibfers'), 'Mk', 'Мк|Mp|Mаp|Mapк', 					
		// translators: abbr. Luke
		'Lk', 		__('Lk', 'bg_bibfers'), 'Lk', 'Лк|Лук|Луки',						
		// translators: abbr. John
		'Jn', 		__('Jn', 'bg_bibfers'), 'Jn', 'Ин|Иоан',							
		// Деяния и послания Апостолов
		// translators: abbr. Acts
		'Act', 		__('Act', 'bg_bibfers'), 'Act', 'Деян|Деяния', 						
		// translators: abbr. James
		'Jac', 		__('Jac', 'bg_bibfers'), 'Jac', 'Иак', 								
		// translators: abbr. 1 Peter
		'1Pet', 	__('1Pet', 'bg_bibfers'), '1Pet', '1Пет|1Петра',					
		// translators: abbr. 2 Peter
		'2Pet',		__('2Pet', 'bg_bibfers'), '2Pet', '2Пет|2Петра',					
		// translators: abbr. 1 John
		'1Jn', 		__('1Jn', 'bg_bibfers'), '1Jn', '1Ин|1Иоан', 						
		// translators: abbr. 2 John
		'2Jn', 		__('2Jn', 'bg_bibfers'), '2Jn', '2Ин|2Иоан', 						
		// translators: abbr. 3 John
		'3Jn', 		__('3Jn', 'bg_bibfers'), '3Jn', '3Ин|3Иоан', 						
		// translators: abbr. Jude
		'Juda', 	__('Juda', 'bg_bibfers'), 'Juda', 'Иуд', 							
		// Послания апостола Павла
		// translators: abbr. Romans
		'Rom', 		__('Rom', 'bg_bibfers'), 'Rom', 'Рим|Римл', 						
		// translators: abbr. 1 Corinthians
		'1Cor', 	__('1Cor', 'bg_bibfers'), '1Cor', '1Кор', 							
		// translators: abbr. 2 Corinthians
		'2Cor', 	__('2Cor', 'bg_bibfers'), '2Cor', '2Кор',							
		// translators: abbr. Galatians
		'Gal', 		__('Gal', 'bg_bibfers'), 'Gal', 'Гал', 								
		// translators: abbr. Ephesians
		'Eph', 		__('Eph', 'bg_bibfers'), 'Eph', 'Еф|Ефес', 							
		// translators: abbr. Philippians
		'Phil', 	__('Phil', 'bg_bibfers'), 'Phil', 'Флп|Фил|Филип',  				
		// translators: abbr. Colossians
		'Col', 		__('Col', 'bg_bibfers'), 'Col', 'Кол',								
		// translators: abbr. 1 Thessalonians
		'1Thes', 	__('1Thes', 'bg_bibfers'), '1Thes', '1Сол|1Фес', 					
		// translators: abbr. 2 Thessalonians
		'2Thes', 	__('2Thes', 'bg_bibfers'), '2Thes', '2Сол|2Фес', 					
		// translators: abbr. 1 Timothy
		'1Tim', 	__('1Tim', 'bg_bibfers'), '1Tim', '1Тим', 							
		// translators: abbr. 2 Timothy
		'2Tim', 	__('2Tim', 'bg_bibfers'), '2Tim', '2Тим',							
		// translators: abbr. Titus
		'Tit', 		__('Tit', 'bg_bibfers'), 'Tit', 'Тит', 								
		// translators: abbr. Philemon
		'Phlm', 	__('Phlm', 'bg_bibfers'), 'Phlm', 'Флм|Филим', 						
		// translators: abbr. Hebrews
		'Hebr', 	__('Hebr', 'bg_bibfers'), 'Hebr', 'Евр', 							
		// translators: abbr. Revelation
		'Apok', 	__('Apok', 'bg_bibfers'), 'Apok', 'Откр|Отк|Апок');					
		
	$book = array(						// Полные названия Книг Священного Писания
		// Ветхий Завет
		// Пятикнижие Моисея
		'Gen', 		__('Genesis', 'bg_bibfers' ),							//'Книга Бытия', 
		'Ex', 		__('Exodus', 'bg_bibfers' ),							//'Книга Исход', 
		'Lev', 		__('Leviticus', 'bg_bibfers' ),							//'Книга Левит', 
		'Num', 		__('Numbers', 'bg_bibfers' ),							//'Книга Числа', 
		'Deut', 	__('Deuteronomy', 'bg_bibfers' ),						//'Второзаконие',
		// «Пророки» (Невиим) 
		'Nav', 		__('Joshua (Iesous)', 'bg_bibfers' ),					//'Книга Иисуса Навина',
		'Judg',		__('Judges', 'bg_bibfers' ),							//'Книга Судей Израилевых', 
		'Rth', 		__('Ruth', 'bg_bibfers' ),								//'Книга Руфь',
		'1Sam', 	__('1 Samuel (1 Kingdoms)', 'bg_bibfers' ),				//'Первая книга Царств (Первая книга Самуила)', 
		'2Sam', 	__('2 Samuel (2 Kingdoms)', 'bg_bibfers' ),				//'Вторая книга Царств (Вторая книга Самуила)', 
		'1King', 	__('1 Kings (3 Kingdoms)', 'bg_bibfers' ),				//'Третья книга Царств (Первая книга Царей)', 
		'2King', 	__('2 Kings (4 Kingdoms)', 'bg_bibfers' ),				//'Четвёртая книга Царств (Вторая книга Царей)',
		'1Chron', 	__('1 Chronicles (1 Paralipomenon)', 'bg_bibfers' ),	//'Первая книга Паралипоменон (Первая книга Хроник, Первая Летопись)', 
		'2Chron', 	__('2 Chronicles (2 Paralipomenon)', 'bg_bibfers' ),	//'Вторая книга Паралипоменон (Вторая книга Хроник, Вторая Летопись)', 
		'Ezr', 		__('1 Esdras', 'bg_bibfers' ),							//'Книга Ездры (Первая книга Ездры)', 
		'Nehem', 	__('Nehemiah (2 Esdras)', 'bg_bibfers' ),				//'Книга Неемии', 
		'Est', 		__('Esther', 'bg_bibfers' ),							//'Книга Есфири',  
		// «Писания» (Ктувим)
		'Job', 		__('Job', 'bg_bibfers' ),								//'Книга Иова',
		'Ps', 		__('Psalms', 'bg_bibfers' ),							//'Псалтирь', 
		'Prov', 	__('Proverbs', 'bg_bibfers' ),							//'Книга Притчей Соломоновых', 
		'Eccl', 	__('Ecclesiastes', 'bg_bibfers' ),						//'Книга Екклезиаста, или Проповедника', 
		'Song', 	__('Song of Songs (Aisma Aismaton)', 'bg_bibfers' ),	//'Песнь песней Соломона',

		'Is', 		__('Isaiah', 'bg_bibfers' ),							//'Книга пророка Исайи', 
		'Jer', 		__('Jeremiah', 'bg_bibfers' ),							//'Книга пророка Иеремии',
		'Lam', 		__('Lamentations', 'bg_bibfers' ),						//'Книга Плач Иеремии', 
		'Ezek', 	__('Ezekiel', 'bg_bibfers' ),							//'Книга пророка Иезекииля',
		'Dan', 		__('Daniel', 'bg_bibfers' ),							//'Книга пророка Даниила', 
		// Двенадцать малых пророков 
		'Hos', 		__('Hosea', 'bg_bibfers' ),								//'Книга пророка Осии', 
		'Joel', 	__('Joel', 'bg_bibfers' ),								//'Книга пророка Иоиля',
		'Am', 		__('Amos', 'bg_bibfers' ),								//'Книга пророка Амоса', 
		'Avd', 		__('Obadiah', 'bg_bibfers' ),							//'Книга пророка Авдия', 
		'Jona', 	__('Jonah', 'bg_bibfers' ),								//'Книга пророка Ионы',
		'Mic', 		__('Micah', 'bg_bibfers' ),								//'Книга пророка Михея', 
		'Naum', 	__('Nahum', 'bg_bibfers' ),								//'Книга пророка Наума',
		'Habak', 	__('Habakkuk', 'bg_bibfers' ),							//'Книга пророка Аввакума', 
		'Sofon', 	__('Zephaniah', 'bg_bibfers' ),							//'Книга пророка Софонии', 
		'Hag', 		__('Haggai', 'bg_bibfers' ),							//'Книга пророка Аггея', 
		'Zah', 		__('Zechariah', 'bg_bibfers' ),							//'Книга пророка Захарии',
		'Mal', 		__('Malachi', 'bg_bibfers' ),							//'Книга пророка Малахии',
		// Второканонические книги
		'1Mac', 	__('1 Maccabees', 'bg_bibfers' ),						//'Первая книга Маккавейская',
		'2Mac', 	__('2 Maccabees', 'bg_bibfers' ),						//'Вторая книга Маккавейская', 
		'3Mac', 	__('3 Maccabees', 'bg_bibfers' ),						//'Третья книга Маккавейская', 
		'Bar', 		__('Baruch', 'bg_bibfers' ),							//'Книга пророка Варуха', 
		'2Ezr', 	__('2 Esdras', 'bg_bibfers' ),							//'Вторая книга Ездры', 
		'3Ezr', 	__('3 Esdras', 'bg_bibfers' ),							//'Третья книга Ездры',
		'Judf', 	__('Judith', 'bg_bibfers' ),							//'Книга Иудифи', 
		'pJer', 	__('Letter of Jeremiah', 'bg_bibfers' ),				//'Послание Иеремии', 
		'Solom', 	__('Wisdom', 'bg_bibfers' ),							//'Книга Премудрости Соломона',
		'Sir', 		__('Sirach', 'bg_bibfers' ),							//'Книга Премудрости Иисуса, сына Сирахова', 
		'Tov', 		__('Tobit (Tobias)', 'bg_bibfers' ),					//'Книга Товита',
		// Новый Завет
		// Евангилие
		'Mt', 		__('Matthew', 'bg_bibfers' ),							//'Евангелие от Матфея',
		'Mk', 		__('Mark', 'bg_bibfers' ),								//'Евангелие от Марка', 
		'Lk', 		__('Luke', 'bg_bibfers' ),								//'Евангелие от Луки', 
		'Jn', 		__('John', 'bg_bibfers' ),								//'Евангелие от Иоанна', 
		// Деяния и послания Апостолов
		'Act', 		__('Acts', 'bg_bibfers' ),								//'Деяния святых Апостолов', 
		'Jac', 		__('James', 'bg_bibfers' ),								//'Послание Иакова', 
		'1Pet', 	__('1 Peter', 'bg_bibfers' ),							//'Первое послание Петра', 
		'2Pet', 	__('2 Peter', 'bg_bibfers' ),							//'Второе послание Петра',	
		'1Jn', 		__('1 John', 'bg_bibfers' ),							//'Первое послание Иоанна', 
		'2Jn', 		__('2 John', 'bg_bibfers' ),							//'Второе послание Иоанна', 
		'3Jn', 		__('3 John', 'bg_bibfers' ),							//'Третье послание Иоанна',
		'Juda', 	__('Jude', 'bg_bibfers' ),								//'Послание Иуды', 
		// Послания апостола Павла
		'Rom', 		__('Romans', 'bg_bibfers' ),							//'Послание апостола Павла к Римлянам', 
		'1Cor', 	__('1 Corinthians', 'bg_bibfers' ),						//'Первое послание апостола Павла к Коринфянам', 
		'2Cor', 	__('2 Corinthians', 'bg_bibfers' ),						//'Второе послание апостола Павла к Коринфянам',
		'Gal', 		__('Galatians', 'bg_bibfers' ),							//'Послание апостола Павла к Галатам', 
		'Eph', 		__('Ephesians', 'bg_bibfers' ),							//'Послание апостола Павла к Ефесянам', 
		'Phil', 	__('Philippians', 'bg_bibfers' ),						//'Послание апостола Павла к Филиппийцам', 
		'Col', 		__('Colossians', 'bg_bibfers' ),						//'Послание апостола Павла к Колоссянам',
		'1Thes',	__('1 Thessalonians', 'bg_bibfers' ),					//'Первое послание апостола Павла к Фессалоникийцам (Солунянам)',
		'2Thes', 	__('2 Thessalonians', 'bg_bibfers' ),					//'Второе послание апостола Павла к Фессалоникийцам (Солунянам)',  
		'1Tim', 	__('1 Timothy', 'bg_bibfers' ),							//'Первое послание апостола Павла к Тимофею', 
		'2Tim', 	__('2 Timothy', 'bg_bibfers' ),							//'Второе послание апостола Павла к Тимофею',
		'Tit', 		__('Titus', 'bg_bibfers' ),								//'Послание апостола Павла к Титу', 
		'Phlm', 	__('Philemon', 'bg_bibfers' ),							//'Послание апостола Павла к Филимону', 
		'Hebr', 	__('Hebrews', 'bg_bibfers' ),							//'Послание апостола Павла к Евреям', 
		'Apok', 	__('Revelation', 'bg_bibfers' ));						//'Откровение Иоанна Богослова (Апокалипсис)'

// http://azbyka.ru/biblia/?Lk.4:25-5:13,6:1-13&crgli&rus&num=cr 
	$opt = "";
	bg_bibrefs_options_ini (); 			// Параметры по умолчанию
	$c_lang_val = get_option( 'bg_bibfers_c_lang' );
    $r_lang_val = get_option( 'bg_bibfers_r_lang' );
    $g_lang_val = get_option( 'bg_bibfers_g_lang' );
    $l_lang_val = get_option( 'bg_bibfers_l_lang' );
    $i_lang_val = get_option( 'bg_bibfers_i_lang' );
    $target_val = get_option( 'bg_bibfers_target' );
    $class_val = get_option( 'bg_bibfers_class' );
	if ($class_val == "") $class_val = 'bg_bibfers';

	$lang_val = $c_lang_val.$r_lang_val.$g_lang_val.$l_lang_val.$i_lang_val;
	$font_val = get_option( 'bg_bibfers_c_font' );
	if ($lang_val) $opt = "&".$lang_val;
	if ($font_val && $c_lang_val) $opt = $opt."&".$font_val;
	
	$cn_url = count($url) / 2;
	$cn_book = count($book) / 2;
	$mainaddr = "http://azbyka.ru/biblia/?";
	$title = preg_replace("/\\s|&nbsp\\;/u", '',$parts[3]); 			// Убираем пробельные символы, включая пробел, табуляцию, переводы строки 
	$chapter = preg_replace("/\\s|&nbsp\\;/u", '', $parts[7]);			// и другие юникодные пробельные символы, а также неразрывные пробелы &nbsp;
	$chapter = preg_replace("/—|–/u", '-', $chapter);					// Замена разных вариантов тире на обычный
	preg_match("/[\\:\\,\\-]/u", $chapter, $matches);
	if (strcasecmp($matches[0], ',') == 0) {
		$chapter = preg_replace("/\,/u", ':', $chapter, 1);				// Первое число всегда номер главы. Если глава отделена запятой, заменяем ее на двоеточие.
	}
	$ref = $title .".". $chapter;
	
	for ($i=0; $i < $cn_url; $i++) {
		$regvar = "/".$url[$i*2+1]."|".$url[$i*2]."/i";
		preg_match_all($regvar, $title, $mts);

		if (count($mts[0])) {
//		if (strcasecmp($url[$i*2+1],  $title) == 0) {
			$title_book = "";
			for ($j=0; $j < $cn_book; $j++) {
				if (strcasecmp($book[$j*2],$url[$i*2]) == 0) {
					$title_book = $book[$j*2+1];
					break;
				}
			}
			$fullurl = $mainaddr.$url[$i*2];
			// translators: ch. - is abbr. "chapter"
			return "href='".str_replace($title, $fullurl, $ref).$opt."' class='".$class_val."' title='".$title_book."\n".(__('ch. ', 'bg_bibfers' ))." ".$chapter. "' target='".$target_val."'"; 
		}
	}

	return "#";
}

function bg_bibfers_bible_proc($txt) {

// Ищем все вхождения ссылок на Библию
	preg_match_all("/[\\(\\[](см\\.?\\:?(\\s|&nbsp\\;)*)?(\\d?(\\s|&nbsp\\;)*[А-яA-z]{2,8})((\\.|\\s|&nbsp\\;)*)(\\d+((\\s|&nbsp\\;)*[\\:\\,\\-—–](\\s|&nbsp\\;)*\\d+)*)[\\]\\)]/ui", $txt, $matches);
	
	$cnt = count($matches[0]);
	if ($cnt > 0) {
		for ($i = 0; $i < $cnt; $i++) {
		// Проверим по каждому паттерну. 
			preg_match("/[\\(\\[](см\\.?\\:?(\\s|&nbsp\\;)*)?(\\d?(\\s|&nbsp\\;)*[А-яA-z]{2,8})((\\.|\\s|&nbsp\\;)*)(\\d+((\\s|&nbsp\\;)*[\\:\\,\\-—–](\\s|&nbsp\\;)*\\d+)*)[\\]\\)]/ui", $matches[0][$i], $mt);
			$cn = count($mt);
			if ($cn > 0) {
				$addr = bg_bibfers_get_url($mt);
				if (strcasecmp($addr, "#") != 0) {
					$newmt = "<a " .$addr. ">" .$matches[0][$i]. "</a>";
					$txt = str_replace($matches[0][$i], $newmt, $txt);
				}			
			}
		}
	}
	
	return $txt;
}

/******************************************************************************************
	Страница настроек
    отображает содержимое страницы для подменю Bible References
*******************************************************************************************/
function bg_bibfers_options_page() {
// http://azbyka.ru/biblia/?Lk.4:25-5:13,6:1-13&crgli&rus&num=cr


    // имена опций и полей
    $c_lang_name = 'bg_bibfers_c_lang';
    $r_lang_name = 'bg_bibfers_r_lang';
    $g_lang_name = 'bg_bibfers_g_lang';
    $l_lang_name = 'bg_bibfers_l_lang';
    $i_lang_name = 'bg_bibfers_i_lang';
	
    $c_font_name = 'bg_bibfers_c_font';
    $target_window = 'bg_bibfers_target';
    $links_class = 'bg_bibfers_class';

    $hidden_field_name = 'bg_bibfers_submit_hidden';
	
	bg_bibrefs_options_ini (); 			// Параметры по умолчанию
	
    // Читаем существующие значения опций из базы данных
    $c_lang_val = get_option( $c_lang_name );
    $r_lang_val = get_option( $r_lang_name );
    $g_lang_val = get_option( $g_lang_name );
    $l_lang_val = get_option( $l_lang_name );
    $i_lang_val = get_option( $i_lang_name );

    $font_val = get_option( $c_font_name );
    $target_val = get_option( $target_window );
    $class_val = get_option( $links_class );
	
// Проверяем, отправил ли пользователь нам некоторую информацию
// Если "Да", в это скрытое поле будет установлено значение 'Y'
    if( $_POST[ $hidden_field_name ] == 'Y' ) {

	// Сохраняем отправленное значение в БД
		$c_lang_val = $_POST[$c_lang_name];
		update_option( $c_lang_name, $c_lang_val );

		$r_lang_val = $_POST[$r_lang_name];
		update_option( $r_lang_name, $r_lang_val );

		$g_lang_val = $_POST[$g_lang_name];
		update_option( $g_lang_name, $g_lang_val );

		$l_lang_val = $_POST[$l_lang_name];
		update_option( $l_lang_name, $l_lang_val );

		$i_lang_val = $_POST[$i_lang_name];
		update_option( $i_lang_name, $i_lang_val );

		$font_val = $_POST[$c_font_name];
		update_option( $c_font_name, $font_val );

		$target_val = $_POST[$target_window];
		update_option( $target_window, $target_val );

		$class_val = $_POST[$links_class];
		update_option( $links_class, $class_val );

        // Вывести сообщение об обновлении параметров на экран

?>  
<div class="updated"><p><strong><?php _e('Options saved.', 'bg_bibfers' ); ?></strong></p></div>
<?php

    }

    // Теперь отобразим опции на экране редактирования

    echo '<div class="wrap">';

    // заголовок

    echo "<h2>" . __( 'Bg Bible References Plugin Options', 'bg_bibfers' ) . "</h2>";

    // форма опций
    
    ?>
<table width="100%">
<tr><td valign="top">
<!-- Форма настроек -->
<form name="form1" method="post" action="<?php echo str_replace( '%7E', '~', $_SERVER['REQUEST_URI']); ?>">

<table class="form-table">

<tr valign="top">
<th scope="row"><?php _e('Display text of the Bible in languages:', 'bg_bibfers' ); ?></th>
<td>
<input type="hidden" name="<?php echo $hidden_field_name; ?>" value="Y">

<input type="checkbox" id="c_lang" name="<?php echo $c_lang_name ?>" <?php if($c_lang_val=="c") echo "checked" ?> value="c" onclick='c_lang_checked();'> <?php _e('Church Slavic', 'bg_bibfers' ); ?><br />
<input type="checkbox" id="r_lang" name="<?php echo $r_lang_name ?>" <?php if($r_lang_val=="r") echo "checked" ?>  value="r"> <?php _e('Russian', 'bg_bibfers' ); ?><br />
<input type="checkbox" id="g_lang" name="<?php echo $g_lang_name ?>" <?php if($g_lang_val=="g") echo "checked" ?>  value="g"> <?php _e('Greek', 'bg_bibfers' ); ?><br />
<input type="checkbox" id="l_lang" name="<?php echo $l_lang_name ?>" <?php if($l_lang_val=="l") echo "checked" ?>  value="l"> <?php _e('Latin', 'bg_bibfers' ); ?><br />
<input type="checkbox" id="i_lang" name="<?php echo $i_lang_name ?>" <?php if($i_lang_val=="i") echo "checked" ?>  value="i"> <?php _e('Hebrew', 'bg_bibfers' ); ?><br />
</td></tr>
<tr valign="top">
<th scope="row"><?php _e('Font for Church Slavonic text', 'bg_bibfers' ); ?></th>
<td>
<input type="radio" id="ucs" name="<?php echo $c_font_name ?>" <?php if($font_val=="ucs") echo "checked" ?> value="ucs"> <?php _e('Church Slavic font', 'bg_bibfers' ); ?><br />
<input type="radio" id="rus" name="<?php echo $c_font_name ?>" <?php if($font_val=="rus") echo "checked" ?> value="rus"> <?php _e('Russian font ("Old" style)', 'bg_bibfers' ); ?><br />
<input type="radio" id="hip" name="<?php echo $c_font_name ?>" <?php if($font_val=="hip") echo "checked" ?> value="hip"> <?php _e('HIP-standard', 'bg_bibfers' ); ?><br />
<script>
function c_lang_checked() {
	elRadio = document.getElementsByName('<?php echo $c_font_name ?>');
	for (var i = 0; i < elRadio.length; i++) {
		if (document.getElementById('c_lang').checked == true) {elRadio[i].disabled = false;}
		else {elRadio[i].disabled = true;}
	}
}
c_lang_checked();
</script>
</td></tr>
<tr valign="top">
<th scope="row"><?php _e('Open page with Bible text', 'bg_bibfers' ); ?></th>
<td>
<input type="radio" id="blank_window" name="<?php echo $target_window ?>" <?php if($target_val=="_blank") echo "checked" ?> value="_blank"> <?php _e('in new window', 'bg_bibfers' ); ?><br />
<input type="radio" id="self_window" name="<?php echo $target_window ?>" <?php if($target_val=="_self") echo "checked" ?> value="_self"> <?php _e('in current window', 'bg_bibfers' ); ?><br />
</td></tr>
<tr valign="top">
<th scope="row"><?php _e('Reference links class', 'bg_bibfers' ); ?></th>
<td>
<input type="text" id="links_class" name="<?php echo $links_class ?>" size="20" value="<?php echo $class_val ?>"><br />
</td></tr>
<tr valign="top">
<td>
<p class="submit">
<input type="submit" name="Submit" value="<?php _e('Update Options', 'bg_bibfers' ) ?>" />
</p>
</td></tr></table>
</form>
</div>


<!-- Информация о плагине -->
</td><td width="25em">

<div class="bg_bibfers_info_box">

	<h3><?php _e('Thanks for using Bg Biblie References', 'bg_bibfers') ?></h3>
	<p class="bg_bibfers_gravatar"><a href="http://bogaiskov.ru" target="_blank"><?php echo get_avatar("vadim.bogaiskov@gmail.com", '64'); ?></a></p>
	<p><?php _e('Dear brothers and sisters!<br />Thank you for using my plugin!<br />I hope it is useful for you.', 'bg_bibfers') ?></p>
	<p class="bg_bibfers_author"><a href="http://bogaiskov.ru" target="_blank"><?php _e('Vadim Bogaiskov', 'bg_bibfers') ?></a></p>

	<h3><?php _e('I like this plugin<br>– how can I thank you?', 'bg_bibfers') ?></h3>
	<p><?php _e('There are several ways for you to say thanks:', 'bg_bibfers') ?></p>
	<ul>
		<li><?php printf(__('<a href="%1$s" target="_blank">Give a donation</a>  for the construction of the church of Sts. Peter and Fevronia in Marino', 'bg_bibfers'), "http://hpf.ru.com/donate/") ?></li>
		<li><?php printf(__('<a href="%1$s" target="_blank">Give it a nice review</a> over at the WordPress Plugin Directory', 'bg_bibfers'), "http://wordpress.org/support/view/plugin-reviews/bg-biblie-references") ?></li>
		<li><?php printf(__('Share infotmation or make a nice blog post about the plugin', 'bg_bibfers')) ?></li>
	</ul>
	<div class="share42init" align="center" data-url="http://bogaiskov.ru/bg_bibfers/" data-title="<?php _e('Bg Bible References really cool plugin for Orthodox WordPress sites', 'bg_bibfers') ?>"></div>
	<script type="text/javascript" src="<?php printf( plugins_url( 'share42/share42.js' , plugin_basename(__FILE__) ) ) ?>"></script>

	<h3><?php _e('Support', 'bg_bibfers') ?></h3>
	<p><?php printf(__('Please see the <a href="%1$s" target="_blank">support forum</a> or my <a href="%2$s" target="_blank">personal site</a> for help.', 'bg_bibfers'), "http://wordpress.org/support/plugin/bg-biblie-references", "http://bogaiskov.ru/bg_bibfers/") ?></p>
	
	<p class="bg_bibfers_close"><?php _e("God protect you!", 'bg_bibfers') ?></p>
</div>
</td></tr></table>
<?php 

} 
?>