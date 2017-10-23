<?php

function digital_backg() {
	?>
	<style type="text/css">
	<?php if ( get_header_image() ) : ?>	
		#header{background-image:url("<?php esc_url(header_image());?>"); display: flex;background-repeat: round;}
		<?php endif; ?>
		
		<?php if(of_get_option('digital_thumbadj')=='off'){ ?>
			.thumbnail img{width: auto;} <?php }
else { echo '.thumbnail img{width: 100% !important;}';}			?>
		
		    </style>
<?php };
add_action('wp_head', 'digital_backg');


function digital_tiltechange() {
if (of_get_option('digital_latestchange') != '') {
		echo '' . esc_attr(of_get_option('digital_latestchange')) . '' . "\n";
	}
else {echo __('Categorie 1','digital') . "\n";
}	
}
function digital_tiltechange2() {
if (of_get_option('digital_latestchange2') != '') {
		echo '' . esc_attr(of_get_option('digital_latestchange2')) . '' . "\n";
	}
else {echo __('Categorie 2','digital') . "\n";
}	
}
	


/* ----------------------------------------------------------------------------------- */
/* Breadcrumbs
  /*----------------------------------------------------------------------------------- */

function digital_breadcrumbs() {
    $delimiter = '&raquo;';
    $home = __('Home','digital'); // text for the 'Home' link
    $before = '<span class="current">'; // tag before the current crumb
    $after = '</span>'; // tag after the current crumb
    echo '<div id="crumbs">';
    global $post;
    $homeLink = esc_url(home_url('/'));
    echo '<a href="' . $homeLink . '">' . $home . '</a> ' . $delimiter . ' ';

    if (is_category()) {
        global $wp_query;
        $cat_obj = $wp_query->get_queried_object();
        $thisCat = $cat_obj->term_id;
        $thisCat = get_category($thisCat);
        $parentCat = get_category($thisCat->parent);
        if ($thisCat->parent != 0)
            echo(get_category_parents($parentCat, TRUE, ' ' . $delimiter . ' '));
        echo $before . 'Archive by category "' . single_cat_title('', false) . '"' . $after;
    } elseif (is_day()) {
        echo '<a href="' . get_year_link(get_the_time('Y')) . '">' . get_the_time('Y') . '</a> ' . $delimiter . ' ';
        echo '<a href="' . get_month_link(get_the_time('Y'), get_the_time('m')) . '">' . get_the_time('F') . '</a> ' . $delimiter . ' ';
        echo $before . get_the_time('d') . $after;
    } elseif (is_month()) {
        echo '<a href="' . get_year_link(get_the_time('Y')) . '">' . get_the_time('Y') . '</a> ' . $delimiter . ' ';
        echo $before . get_the_time('F') . $after;
    } elseif (is_year()) {
        echo $before . get_the_time('Y') . $after;
    } elseif (is_single() && !is_attachment()) {
        if (get_post_type() != 'post') {
            $post_type = get_post_type_object(get_post_type());
            $slug = $post_type->rewrite;
            echo '<a href="' . $homeLink . '/' . $slug['slug'] . '/">' . $post_type->labels->singular_name . '</a> ' . $delimiter . ' ';
            echo $before . get_the_title() . $after;
        } else {
            $cat = get_the_category();
            $cat = $cat[0];
            echo get_category_parents($cat, TRUE, ' ' . $delimiter . ' ');
            echo $before . get_the_title() . $after;
        }
    } elseif (is_attachment()) {
        $parent = get_post($post->post_parent);
        //$cat = get_the_category($parent->ID); $cat = $cat[0];
        //echo get_category_parents($cat, TRUE, ' ' . $delimiter . ' ');
        echo '<a href="' . esc_url(get_permalink($parent)) . '">' . esc_attr($parent->post_title) . '</a> ' . $delimiter . ' ';
        echo $before . get_the_title() . $after;
    } elseif (is_page() && !$post->post_parent) {
        echo $before . get_the_title() . $after;
    } elseif (is_page() && $post->post_parent) {
        $parent_id = $post->post_parent;
        $breadcrumbs = array();
        while ($parent_id) {
            $page = get_page($parent_id);
            $breadcrumbs[] = '<a href="' . get_permalink($page->ID) . '">' . esc_html(get_the_title($page->ID)) . '</a>';
            $parent_id = $page->post_parent;
        }
        $breadcrumbs = array_reverse($breadcrumbs);
        foreach ($breadcrumbs as $crumb)
            echo $crumb . ' ' . $delimiter . ' ';
        echo $before . esc_html(get_the_title()) . $after;
    } elseif (is_search()) {
        echo $before . __('Search results for','digital') . get_search_query() . $after;
    } elseif (is_tag()) {
        echo $before . __('Posts tagged','digital') . single_tag_title('', false) . $after;
    } elseif (is_author()) {
        global $author;
        $userdata = get_userdata($author);
        echo $before . __('Articles posted by ','digital') . esc_attr($userdata->display_name) . $after;
    } elseif (is_404()) {
        echo $before . __('Error 404','digital') . $after;
    }

    if (get_query_var('paged')) {
        if (is_category() || is_day() || is_month() || is_year() || is_search() || is_tag() || is_author())
            echo ' (';
        echo __('Page','digital') . ' ' . get_query_var('paged','digital');
        if (is_category() || is_day() || is_month() || is_year() || is_search() || is_tag() || is_author())
            echo ')';
    }

    echo '</div>';
}
?>