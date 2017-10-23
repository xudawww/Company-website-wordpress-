<?php
/**
 * @package Ion
 */
?><!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
<meta charset="<?php bloginfo( 'charset' ); ?>" />

<title><?php wp_title( '|', true, 'right' ); ?></title>
<link rel="profile" href="http://gmpg.org/xfn/11" />
<link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>" />
<meta name="apple-mobile-web-app-capable" content="yes">
<?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>

	<?php do_action('appp_after_body'); ?>

<div id="body-container">

		<div id="menu-content" class="menu-content pane menu-animated">

			<div id="page" class="hfeed site">
				<?php do_action( 'appp_before' ); ?>

				<div id="main" <?php body_class( 'site-main' ); ?>>
