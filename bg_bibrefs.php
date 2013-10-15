<?php
/* 
    Plugin Name: Bg Bible References 
    Plugin URI: http://bogaiskov.ru/bg_bibfers/
    Description: Плагин подсвечивает ссылки на текст Библии с помощью гиперссылок на сайт <a href="http://azbyka.ru/">Православной энциклопедии "Азбука веры"</a>. / The plugin will highlight references to the Bible text with links to site of <a href="http://azbyka.ru/">Orthodox encyclopedia "The Alphabet of Faith"</a>.
    Author: Vadim Bogaiskov
    Version: 0.5
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

	if ( !defined('ABSPATH') ) { die( 'Sorry, you are not allowed to access this page directly.' ); }

	define('BG_BIBREFS_VERSION', '0.5');
	define('BG_BIBREFS_URL',     plugins_url('', __FILE__));

	if ( !is_admin() ) {
        wp_register_script('bg_bibrefs.js',  BG_BIBREFS_URL.'/js/bg_bibrefs.js', false, BG_BIBREFS_VERSION, true );
		wp_enqueue_script( 'bg_bibrefs.js');
	}
	
	function bg_bibfers() {
		$content = get_the_content(); 
		$content = "<div id='bg_bibfers_id'>".$content."</div>";
		return $content;
	}

	if ( defined('ABSPATH') && defined('WPINC') ) {
		add_filter('the_content', 'bg_bibfers');
	}
?>