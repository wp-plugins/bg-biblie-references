<?php 
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
	
	$bg_verses_name = 'bg_bibfers_show_verses';

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
	
    $bg_verses_val = get_option( $bg_verses_name );

// Проверяем, отправил ли пользователь нам некоторую информацию
// Если "Да", в это скрытое поле будет установлено значение 'Y'
    if( isset( $_POST[ $hidden_field_name ] ) && $_POST[ $hidden_field_name ] == 'Y' ) {

	// Сохраняем отправленное значение в БД
		$c_lang_val = ( isset( $_POST[$c_lang_name] ) && $_POST[$c_lang_name] ) ? $_POST[$c_lang_name] : '' ;
		update_option( $c_lang_name, $c_lang_val );

		$r_lang_val = ( isset( $_POST[$r_lang_name] ) && $_POST[$r_lang_name] ) ? $_POST[$r_lang_name] : '' ;
		update_option( $r_lang_name, $r_lang_val );

		$g_lang_val =( isset( $_POST[$g_lang_name] ) && $_POST[$g_lang_name] ) ? $_POST[$g_lang_name] : '' ;
		update_option( $g_lang_name, $g_lang_val );

		$l_lang_val = ( isset( $_POST[$l_lang_name] ) && $_POST[$l_lang_name] ) ? $_POST[$l_lang_name] : '' ;
		update_option( $l_lang_name, $l_lang_val );

		$i_lang_val = ( isset( $_POST[$i_lang_name] ) && $_POST[$i_lang_name] ) ? $_POST[$i_lang_name] : '' ;
		update_option( $i_lang_name, $i_lang_val );

		$font_val = ( isset( $_POST[$c_font_name] ) && $_POST[$c_font_name] ) ? $_POST[$c_font_name] : '' ;
		update_option( $c_font_name, $font_val );

		$target_val = ( isset( $_POST[$target_window] ) && $_POST[$target_window] ) ? $_POST[$target_window] : '' ;
		update_option( $target_window, $target_val );

		$class_val = ( isset( $_POST[$links_class] ) && $_POST[$links_class] ) ? $_POST[$links_class] : '' ;
		update_option( $links_class, $class_val );

		$bg_verses_val = ( isset( $_POST[$bg_verses_name] ) && $_POST[$bg_verses_name] ) ? $_POST[$bg_verses_name] : '' ;
		update_option( $bg_verses_name, $bg_verses_val );

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
<th scope="row"><?php _e('Reference links CSS class', 'bg_bibfers' ); ?></th>
<td>
<input type="text" id="links_class" name="<?php echo $links_class ?>" size="20" value="<?php echo $class_val ?>"><br />
</td></tr>
<tr valign="top">
<th scope="row"><?php _e('Show Bible verses in popup', 'bg_bibfers' ); ?></th>
<td>
<input type="checkbox" id="bg_verses" name="<?php echo $bg_verses_name ?>" <?php if($bg_verses_val=="on") echo "checked" ?>  value="on"> <?php _e('<br><i>(if this option is disabled or data are not received from the server,<br>popup showing the chapter number and verse numbers)</i>', 'bg_bibfers' ); ?> <br />
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
	<script type="text/javascript" src="<?php printf( plugins_url( 'share42/share42.js' , dirname(__FILE__) ) ) ?>"></script>

	<h3><?php _e('Support', 'bg_bibfers') ?></h3>
	<p><?php printf(__('Please see the <a href="%1$s" target="_blank">support forum</a> or my <a href="%2$s" target="_blank">personal site</a> for help.', 'bg_bibfers'), "http://wordpress.org/support/plugin/bg-biblie-references", "http://bogaiskov.ru/bg_bibfers/") ?></p>
	
	<p class="bg_bibfers_close"><?php _e("God protect you!", 'bg_bibfers') ?></p>
</div>
</td></tr></table>
<?php 

} 


