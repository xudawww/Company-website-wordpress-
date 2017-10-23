</div></div> 
<div id="bottom-menu">
<div id="bottom-menu-inner" class="clearfix">
<div id="bottom-menu-1">
<?php if (!dynamic_sidebar('digbottom1') ) : ?>
		<?php endif; ?>
</div> <!-- end div #bottom-menu-left -->
<div id="bottom-menu-2">
	<?php if (!dynamic_sidebar('digbottom2') ) : ?>
			<?php endif; ?>
</div> <!-- end div #bottom-menu-center -->
<div id="bottom-menu-4">
	<?php if ( !dynamic_sidebar('digbottom3') ) : ?>
	<?php endif; ?>
</div> </div> </div>

	<div id="footer">
	<div id="footer-inner" class="clearfix">
			<a href="<?php echo esc_url( home_url('/'));?>" title="<?php bloginfo('name');?>" ><?php bloginfo('name');?></a> <?php _e('Copyright &#169; | ', 'digital'); ?> <?php echo date('Y');?> <a href="<?php echo esc_url( __( 'http://www.insertcart.com/product/digital-wp-theme/', 'digital' ) ); ?>" title="<?php esc_attr_e( 'Digital', 'digital' ); ?>"><?php printf( __( 'Digital Theme %s', 'digital' ),''); ?></a>
	</div> <!-- end div #footer-inner -->
	</div> <!-- end div #footer -->
	<!-- END FOOTER -->
		
