<div class="gap"></div>
<div id="pagenavi" class="clearfix">
	<?php if('digital_pagination') { digital_pagination(); } else { ?>
		<?php next_posts_link('<span class="alignleft">&nbsp; &laquo; Older posts</span>') ?>
		<?php previous_posts_link('<span class="alignright">Newer posts &raquo; &nbsp;</span>') ?>
	<?php } ?>
</div> <!-- end div #pagenavi --><p></p>
<div class="gap"></div>

<div id="footerads">
<?php if ( of_get_option('digital_ad1') <> "" ) { echo stripslashes(of_get_option('digital_ad1')); } ?>
</div>