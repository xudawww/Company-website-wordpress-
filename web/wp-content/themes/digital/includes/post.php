<?php if(has_post_thumbnail()) : ?>
<div class="thumbnail">
		<a href="<?php the_permalink(); ?>" title="<?php the_title(); ?>">
		
		<?php if ( has_post_thumbnail() ) {the_post_thumbnail('defaultthumb'); } 
		elseif (of_get_option( 'digital_defaulthumb')) { 
		echo'<img src="' . of_get_option( 'digital_defaulthumb').'" />' ; }
		else { 
		echo '<img src="'.get_template_directory_uri().'/images/thumb.jpg" />'. "\n"; }
	  ?></a>


<a href="<?php the_permalink(); ?>"><div class="info"></div></a></div>
<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
		<h2 class="entry-title"><a href="<?php the_permalink(); ?>" title="<?php the_title(); ?>"><?php the_title(); ?></a></h2>
			<div class="entry"><?php digital_excerpt('digital_excerptlength_index', 'digital_excerptmore'); ?></div>
			             </article>
<?php else : ?>
<div class="thumbnail">
<a href="<?php the_permalink(); ?>" title="<?php the_title(); ?>">
<?php if ( has_post_thumbnail() ) {the_post_thumbnail('defaultthumb'); } 
		elseif (of_get_option( 'digital_defaulthumb')) { 
		echo'<img src="' . of_get_option( 'digital_defaulthumb').'" />' ; }
		else { 
		echo '<img src="'.get_template_directory_uri().'/images/thumb.jpg" />'. "\n"; }
	  ?></a>

 </a> <a href="<?php the_permalink(); ?>"><div class="info"></div></a>  </div>
<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
		<h2 class="entry-title"><a href="<?php the_permalink(); ?>" title="<?php the_title(); ?>"><?php the_title(); ?></a></h2>
		<div class="entry"><?php digital_excerpt('digital_excerptlength_index', 'digital_excerptmore'); ?></div>
	</article>
<?php endif; ?>





