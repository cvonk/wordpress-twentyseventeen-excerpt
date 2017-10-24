<?php ?>
<script>

var cvonk_multicat_js_run = true;

 // Adds a Theme Option, that let you pick categories to show as thumbnails intead of cards in category view.
 //
 // see: https://themefoundation.com/wordpress-theme-customizer/
 //      https://themefoundation.com/customizer-multiple-category-control/
 //      https://wordpress.stackexchange.com/questions/41548/get-categories-hierarchical-order-like-wp-list-categories-with-name-slug-li
 //
window.addEventListener("load", function() {
     
     // keep code from running twice due to live preview window.load firing in addition to the main customizer window.
     if( true == cvonk_multicat_js_run ) {
         cvonk_multicat_js_run = false;
     } else {
         return;
     }

     // used to get the current value of our hidden field
     var api = wp.customize;
     
     // checks/unchecks category checkboxes based on saved data
     jQuery('.cvonk-hidden-categories').each(function(){
	 
         var id = jQuery(this).prop('id');
         var categoryString = api.instance(id).get();
         var categoryArray = categoryString.split(',');
	 
         jQuery('#' + id).closest('li').find('.cvonk-category-checkbox').each(function() {
	     
             var elementID = jQuery(this).prop('id').split('-');
	     
             if( jQuery.inArray( elementID[1], categoryArray ) < 0 ) {
                 jQuery(this).prop('checked', false);
             } else {
                 jQuery(this).prop('checked', true);
             }
         });     
     });
     
     // listen to checkboxes
     jQuery('.cvonk-category-checkbox').live('change', function(){
	 
         var id = jQuery(this).closest('li').find('.cvonk-hidden-categories').prop('id');
         var elementID = jQuery(this).prop('id').split('-');
	 
         if( jQuery(this).prop('checked' ) == true ) {
             addCategory(elementID[1], id);
         } else {
             removeCategory(elementID[1], id);
         }
	 
     });
     
     // add category ID to hidden input
     function addCategory( catID, controlID ) {
	 
         var categoryString = api.instance(controlID).get();
         var categoryArray = categoryString.split(',');
	 
         if ( '' == categoryString ) {
             var delimiter = '';
         } else {
             var delimiter = ',';
         }
	 // update hidden field value
         if( jQuery.inArray( catID, categoryArray ) < 0 ) {
             api.instance(controlID).set( categoryString + delimiter + catID );
         }
     }
     
     // remove category ID from hidden input
     function removeCategory( catID, controlID ) {
	 
         var categoryString = api.instance(controlID).get();
         var categoryArray = categoryString.split(',');
         var catIndex = jQuery.inArray( catID, categoryArray );
	 
         if( catIndex >= 0 ) {
	     
             categoryArray.splice(catIndex, 1);  // remove element from array
	     
             // creates new category string based on remaining array elements
             var newCategoryString = '';
             jQuery.each( categoryArray, function() {
                 if ( '' == newCategoryString ) {
                     var delimiter = '';
                 } else {
                     var delimiter = ',';
                 }
                 newCategoryString = newCategoryString + delimiter + this;
             });
	     
             // updates hidden field value
             api.instance(controlID).set( newCategoryString );
         }
     }
 }, false);
</script>
<?php


function enqueue_child_theme_styles() {
    wp_enqueue_style( 'parent-style', get_template_directory_uri().'/style.css' );
}
add_action( 'wp_enqueue_scripts', 'enqueue_child_theme_styles', PHP_INT_MAX);


function cvonk_walk_category_tree( $cat, $lvl ) {
    
    $next = get_categories('hide_empty=false&orderby=name&order=ASC&parent=' . $cat);
    
    if( $next ) {

	foreach( $next as $cat ) {

	    echo '<label><input type="checkbox" name="category-' . $cat->term_id . 
		 '" id="category-' . $cat->term_id . '" class="cvonk-category-checkbox"> ' .
		 str_repeat('-&nbsp;', $lvl) . $cat->cat_name . '</label><br>';
	    
	    cvonk_walk_category_tree( $cat->term_id, $lvl + 1 );
	}
    }
    echo "\n";
}

function cvonk_customize_register( $wp_customize ) {
    
    // Class adds multiple category selection support to the theme customizer via checkboxes
    // The category IDs are saved in the database as a comma separated string.
    //
    class MultipleCategories_Control extends WP_Customize_Control {

	public function render_content() {
            echo '<span class="customize-control-title">' . esc_html( $this->label ) . '</span>';
	    echo '<span class="description customize-control-description">' . esc_html( $this->description ) . '</span>';

	    cvonk_walk_category_tree( 0, 0 ); // the function call; 0 for all categories; or cat ID  
	    
	    // hidden input field stores the saved category list.
	    echo '<input type="hidden" id="' . $this->id . '"';
	    echo 'class="cvonk-hidden-categories"' . $this->link() .
		 'value="' . sanitize_text_field( $this->value() ) . '">';	    
	}
    }

    $wp_customize->add_setting( 'cvonk_thumb_categories' );
    
    $wp_customize->add_control( new MultipleCategories_Control( $wp_customize, 'cvonk_thumb_categories', array(
	'label' => 'Categories shown as thumbnails',
	'description' => __( 'Selected categories will be shown as thumbnails instead of cards in the category view.', 'twentyseventeen-child-cvonk' ),
        'section' => 'theme_options',
        'settings' => 'cvonk_thumb_categories' ) ) );
}
add_action( 'customize_register', 'cvonk_customize_register' );

?>
