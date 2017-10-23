<?php
/*
** Template to Render Social Icons on Top Bar
*/

for ($i = 1; $i < 8; $i++) : 
	$social = esc_html(get_theme_mod('hanne_social_'.$i));
	if ( ($social != 'none') && ($social != '') ) : ?>
	<a class="" href="<?php echo esc_url( get_theme_mod('hanne_social_url'.$i) ); ?>"><i class="fa fa-fw fa-<?php echo $social; ?>"></i></a>
	<?php endif;

endfor; ?>