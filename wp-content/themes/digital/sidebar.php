<div id="sidebar">
<?php if (of_get_option('digital_popular' ) =='1' ) {get_template_part('/includes/popular'); } ?>
	<?php if (!dynamic_sidebar('digsidebar') ) : ?>				
		<?php endif; ?>	</div>	<!-- end div #sidebar -->

		