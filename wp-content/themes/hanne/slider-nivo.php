<?php
/* The Template to Render the Slider
*
*/
$count_x = $count = esc_html(rt_slider::fetch('count')); ?>

<div class="container slider-container">
	<div class="slider-wrapper theme-default">
            <div id="nivoSlider" class="nivoSlider">
            <?php
            for ( $i = 1; $i <= $count; $i++ ) :

				$url = esc_url( rt_slider::fetch('url', $i ));
				$img = esc_url( rt_slider::fetch('img', $i ));
				
				if ($img) :
				?>
				
	            <a href="<?php echo $url; ?>"><img src="<?php echo $img ?>" title="#caption_<?php echo $i ?>" /></a>
	            
             <?php
	            endif;
	        endfor; ?>
               
            </div>
            
            <?php
            for ( $i = 1; $i <= $count_x; $i++ ) :

				$title = esc_html( rt_slider::fetch('title', $i ) );
				$desc = esc_html( rt_slider::fetch('desc', $i) );
				$button = esc_html(rt_slider::fetch('cta_button', $i));
				$url = esc_url ( rt_slider::fetch('url', $i ) );
				
				
				?>
	            <div id="caption_<?php echo $i ?>" class="nivo-html-caption">
	                <a href="<?php echo $url ?>">
		                <?php if ($title) : ?>
		                <div class="slide-title"><?php echo $title ?></div>
		                <?php endif;
			            if ($desc) : ?>
		                <div class="slide-desc"><span><?php echo $desc ?></span></div>
		                <?php endif; ?>
		                <?php if ($button != "") { ?><div class="slide-cta"><span><?php echo $button ?></span></div><?php } ?>
	                </a>
	            </div>
            <?php endfor; ?>
            
        </div>
</div> 