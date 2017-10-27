<?php

function cvonk_thumb_enqueue_parent_theme_styles() {
    wp_enqueue_style( 'parent-style', get_template_directory_uri().'/style.css' );
}
add_action( 'wp_enqueue_scripts', 'cvonk_thumb_enqueue_parent_theme_styles');


/**
 * Category Excerpt, outputs excerpt for current post
 * @link https://codepen.io/cvonk/full/KXGvRe/
 *
 * Called directly from category.php, or using AJAX as part of Load More
 */
function cvonk_thumb_category_excerpt() {
    $this_category = get_the_category()[0]->slug;

    $thumbnail_categories = explode(',', get_theme_mod('cvonk_thumb_categories'));
    $style = "style1";
    foreach($thumbnail_categories as $thumb_category_id) {
	$thumb_category = &get_category((int)$thumb_category_id);
	if( !strcasecmp($thumb_category->slug, $this_category)) {
	    $style = "style2";
	}
    }
    echo '<article class="post ' . $style . ' mask-triangle zoom-rotate-photo">';
    echo '  <div class="picture-container">';
    echo '    <a href="' . get_the_permalink() . '" rel="bookmark" title="Permanent link">';
    if (has_post_thumbnail()) {
	the_post_thumbnail($size="400 400");
    }
    echo '    <svg name="spinner" class="spinner" viewBox="0 0 66 66" xmlns="http://www.w3.org/2000/svg">';
    echo '      <circle class="path" fill="none" stroke-width="6" stroke-linecap="round" cx="33" cy="33" r="30"></circle>';
    echo '    </svg></a></div>';
    echo '  <div class="article-text">';
    echo '    <a href="' . get_the_permalink() . '" rel="bookmark" title="Permanent link">' . get_the_title() . '</a>';
    echo '    <span>' . preg_replace('|<a.*?/a>|', '', get_the_excerpt()) . '</span></div>';
    echo '  <div class="article-footer">By ' . get_the_author() . '  |  ';
    edit_post_link();
    echo '  </div></article>';
}


/**
 * Load More, JavaScript
 * @link https://www.billerickson.net/infinite-scroll-in-wordpress/
 */
function cvonk_thumb_loadmore_js() {
    if ( get_theme_mod('cvonk_thumb_loadmore')) {
	global $wp_query;
	$args = array(
	    'nonce' => wp_create_nonce( 'cvonk-thumb-loadmore-nonce' ),
	    'url'   => admin_url( 'admin-ajax.php' ),
	    'query' => $wp_query->query,
	);

	wp_enqueue_script( 'cvonk-thumb-loadmore', get_stylesheet_directory_uri() . '/js/load-more.js', array( 'jquery' ), '1.0', true );
	wp_localize_script( 'cvonk-thumb-loadmore', 'cvonk_thumb_loadmore', $args );
    }
}
add_action( 'wp_enqueue_scripts', 'cvonk_thumb_loadmore_js' );


/**
 * Load More, Asynchronous JavaScript
 * @link https://www.billerickson.net/infinite-scroll-in-wordpress/
 */
function cvonk_thumb_loadmore_ajax() {
    check_ajax_referer( 'cvonk-thumb-loadmore-nonce', 'nonce' );

    $args = isset( $_POST['query'] ) ? $_POST['query'] : array();
    $args['post_type'] = isset( $args['post_type'] ) ? $args['post_type'] : 'post';
    $args['paged'] = $_POST['page'];
    $args['post_status'] = 'publish';

    $query = new WP_Query( $args );
    ob_start();
    if( $query->have_posts() ) {
	while( $query->have_posts() ) {
	    $query->the_post();
	    cvonk_thumb_category_excerpt();
	}
    }
    wp_reset_postdata();
    $data = ob_get_clean();
    wp_send_json_success( $data );
}
if ( get_theme_mod('cvonk_thumb_loadmore')) { // announce ourselves to AJAX query
    add_action( 'wp_ajax_cvonk_thumb_loadmore_ajax', 'cvonk_thumb_loadmore_ajax' );
    add_action( 'wp_ajax_nopriv_cvonk_thumb_loadmore_ajax', 'cvonk_thumb_loadmore_ajax' );
}


function cvonk_thumb_walk_category_tree( $cat, $lvl ) {
    $next = get_categories('hide_empty=false&orderby=name&order=ASC&parent=' . $cat);
    if( $next ) {
	foreach( $next as $cat ) {
	    echo '<label><input type="checkbox" name="category-' . $cat->term_id . 
		 '" id="category-' . $cat->term_id . '" class="cvonk-category-checkbox"> ' .
		 str_repeat('-&nbsp;', $lvl) . $cat->cat_name . '</label><br>';

	    cvonk_thumb_walk_category_tree( $cat->term_id, $lvl + 1 );
	}
    }
    echo "\n";
}

/**
 * Add theme options
 *
 * @link https://themefoundation.com/wordpress-theme-customizer/
 * @link https://themefoundation.com/customizer-multiple-category-control/
 * @link https://wordpress.stackexchange.com/questions/41548/get-categories-hierarchical-order-like-wp-list-categories-with-name-slug-li
 */
function cvonk_thumb_customize_register( $wp_customize ) {

    // Class adds multiple category selection support to the theme customizer via checkboxes
    // The category IDs are saved as a comma separated string.

    class MultipleCategories_Control extends WP_Customize_Control {

	public function render_content() {

	    // Loads theme-customizer.js javascript file.
	    echo '<script src="' . get_stylesheet_directory_uri() . '/js/multiple-categories.js"></script>';

	    echo '<span class="customize-control-title">' . esc_html( $this->label ) . '</span>';
	    echo '<span class="description customize-control-description">' . esc_html( $this->description ) . '</span>';

	    cvonk_thumb_walk_category_tree( 0, 0 );  // 0 for all categories  

	    // hidden input field stores the saved category list.
	    echo '<input type="hidden" id="' . $this->id . '"';
	    echo 'class="cvonk-hidden-categories"' . $this->link() .
		 'value="' . sanitize_text_field( $this->value() ) . '">';	    
	}
    }

    // option to show category items as thumbnails    
    $wp_customize->add_setting( 'cvonk_thumb_categories' );
    $wp_customize->add_control( new MultipleCategories_Control( $wp_customize, 'cvonk_thumb_categories', array(
	'label' => __('Categories shown as thumbnails', 'twentyseventeen-child-cvonk' ),
	'description' => __( 'Selected categories will be shown as thumbnails instead of cards in the category view.', 'twentyseventeen-child-cvonk' ),
  	'section' => 'theme_options',
	'settings' => 'cvonk_thumb_categories' ) )
    );

    // option to categories as infinite page (AKA load-more)
    $wp_customize->add_setting( 'cvonk_thumb_loadmore', array(
	'default'           => true,
	'transport'         => 'postMessage',
    ) );
    $wp_customize->add_control( 'cvonk_thumb_loadmore', array(
	'label'       => __('All on one page', 'twentyseventeen-child-cvonk' ),
	'section'     => 'theme_options',
	'settings'    => 'cvonk_thumb_loadmore',
	'type'        => 'checkbox',
	'description' => __( 'Shows all the items on one page, loading them on demand.', 'twentyseventeen-child-cvonk' ),
	'active_callback' => 'twentyseventeen_is_view_with_layout_option',
    ) );
}
add_action( 'customize_register', 'cvonk_thumb_customize_register' );

?>
