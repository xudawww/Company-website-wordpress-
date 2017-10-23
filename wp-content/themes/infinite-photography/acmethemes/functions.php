<?php
/**
 * Callback functions for comments
 *
 * @since infinite-photography 1.0.0
 *
 * @param $comment
 * @param $args
 * @param $depth
 * @return void
 *
 */
if ( !function_exists('infinite_photography_commment_list') ) :

    function infinite_photography_commment_list($comment, $args, $depth) {
        extract($args, EXTR_SKIP);
        if ('div' == $args['style']) {
            $tag = 'div';
            $add_below = 'comment';
        }
        else {
            $tag = 'li';
            $add_below = 'div-comment';
        }
        ?>
        <<?php echo $tag ?>
        <?php comment_class(empty($args['has_children']) ? '' : 'parent') ?> id="comment-<?php comment_ID() ?>">
        <?php if ('div' != $args['style']) : ?>
            <div id="div-comment-<?php comment_ID() ?>" class="comment-body clearfix">
        <?php endif; ?>
        <div class="comment-author vcard">
            <?php if ($args['avatar_size'] != 0) echo get_avatar($comment, '64'); ?>
            <?php printf(__('<cite class="fn">%s</cite>', 'infinite-photography' ), get_comment_author_link()); ?>
        </div>
        <?php if ($comment->comment_approved == '0') : ?>
            <em class="comment-awaiting-moderation"><?php _e('Your comment is awaiting moderation.', 'infinite-photography'); ?></em>
            <br/>
        <?php endif; ?>
        <div class="comment-meta commentmetadata">
            <a href="<?php echo esc_url(get_comment_link($comment->comment_ID)); ?>">
                <i class="fa fa-clock-o"></i>
                <?php
                /* translators: 1: date, 2: time */
                printf(__('%1$s at %2$s', 'infinite-photography'), get_comment_date(), get_comment_time()); ?>
            </a>
            <?php edit_comment_link(__('(Edit)', 'infinite-photography'), '  ', ''); ?>
        </div>
        <?php comment_text(); ?>
        <div class="reply">
            <?php comment_reply_link( array_merge($args, array('add_below' => $add_below, 'depth' => $depth, 'max_depth' => $args['max_depth'] ) ) ); ?>
        </div>
        <?php if ('div' != $args['style']) : ?>
            </div>
        <?php endif; ?>
        <?php
    }
endif;

/**
 * Select sidebar according to the options saved
 *
 * @since infinite-photography 1.0.0
 *
 * @param null
 * @return string
 *
 */
/**
 * Select sidebar according to the options saved
 *
 * @since SuperMag 1.0.0
 *
 * @param null
 * @return string
 *
 */
if ( !function_exists('infinite_photography_sidebar_selection') ) :
	function infinite_photography_sidebar_selection( ) {
		wp_reset_postdata();
		$infinite_photography_customizer_all_values = infinite_photography_get_theme_options();
		global $post;
		if(
			isset( $infinite_photography_customizer_all_values['infinite-photography-sidebar-layout'] ) &&
			(
				'left-sidebar' == $infinite_photography_customizer_all_values['infinite-photography-sidebar-layout'] ||
				'both-sidebar' == $infinite_photography_customizer_all_values['infinite-photography-sidebar-layout'] ||
				'no-sidebar' == $infinite_photography_customizer_all_values['infinite-photography-sidebar-layout']
			)
		){
			$infinite_photography_body_global_class = $infinite_photography_customizer_all_values['infinite-photography-sidebar-layout'];
		}
		else{
			$infinite_photography_body_global_class= 'right-sidebar';
		}

		if( is_front_page() ){
			if( isset( $infinite_photography_customizer_all_values['infinite-photography-front-page-sidebar-layout'] ) ){
				if(
					'right-sidebar' == $infinite_photography_customizer_all_values['infinite-photography-front-page-sidebar-layout'] ||
					'left-sidebar' == $infinite_photography_customizer_all_values['infinite-photography-front-page-sidebar-layout'] ||
					'both-sidebar' == $infinite_photography_customizer_all_values['infinite-photography-front-page-sidebar-layout'] ||
					'no-sidebar' == $infinite_photography_customizer_all_values['infinite-photography-front-page-sidebar-layout']
				){
					$infinite_photography_body_classes = $infinite_photography_customizer_all_values['infinite-photography-front-page-sidebar-layout'];
				}
				else{
					$infinite_photography_body_classes = $infinite_photography_body_global_class;
				}
			}
			else{
				$infinite_photography_body_classes= $infinite_photography_body_global_class;
			}
		}
        elseif (is_singular() && isset( $post->ID )) {
			$post_class = get_post_meta( $post->ID, 'infinite_photography_sidebar_layout', true );
			if ( 'default-sidebar' != $post_class ){
				if ( $post_class ) {
					$infinite_photography_body_classes = $post_class;
				} else {
					$infinite_photography_body_classes = $infinite_photography_body_global_class;
				}
			}
			else{
				$infinite_photography_body_classes = $infinite_photography_body_global_class;
			}

		}
        elseif ( is_archive() ) {
			if( isset( $infinite_photography_customizer_all_values['infinite-photography-archive-sidebar-layout'] ) ){
				$infinite_photography_archive_sidebar_layout = $infinite_photography_customizer_all_values['infinite-photography-archive-sidebar-layout'];
				if(
					'right-sidebar' == $infinite_photography_archive_sidebar_layout ||
					'left-sidebar' == $infinite_photography_archive_sidebar_layout ||
					'both-sidebar' == $infinite_photography_archive_sidebar_layout ||
					'no-sidebar' == $infinite_photography_archive_sidebar_layout
				){
					$infinite_photography_body_classes = $infinite_photography_archive_sidebar_layout;
				}
				else{
					$infinite_photography_body_classes = $infinite_photography_body_global_class;
				}
			}
			else{
				$infinite_photography_body_classes= $infinite_photography_body_global_class;
			}
		}
		else {
			$infinite_photography_body_classes = $infinite_photography_body_global_class;
		}
		return $infinite_photography_body_classes;
	}
endif;

/**
 * Return content of fixed lenth
 *
 * @since infinite-photography 1.0.0
 *
 * @param string $infinite_photography_content
 * @param int $length
 * @return string
 *
 */
if ( ! function_exists( 'infinite_photography_words_count' ) ) :
    function infinite_photography_words_count( $infinite_photography_content = null, $length = 16 ) {

        $length = absint( $length );
        $source_content = preg_replace( '`\[[^\]]*\]`', '', $infinite_photography_content );
        $trimmed_content = wp_trim_words( $source_content, $length, '...' );
        return $trimmed_content;

    }
endif;

/**
 * BreadCrumb Settings
 */
if( ! function_exists( 'infinite_photography_breadcrumbs' ) ):
	function infinite_photography_breadcrumbs() {
		if ( ! function_exists( 'breadcrumb_trail' ) ) {
			require infinite_photography_file_directory('acmethemes/library/breadcrumbs/breadcrumbs.php');
		}
		$breadcrumb_args = array(
			'container'   => 'div',
			'show_browse' => false,
			'show_on_front'   => false
		);
		echo "<div class='breadcrumbs clearfix'><div id='infinite-photography-breadcrumbs'>";
		breadcrumb_trail( $breadcrumb_args );
		echo "</div></div>";
	}
endif;