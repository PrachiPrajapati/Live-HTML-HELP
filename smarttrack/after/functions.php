<?php
//allowing span
function override_mce_options($initArray) 
{
  $opts = '*[*]';
  $initArray['valid_elements'] = $opts;
  $initArray['extended_valid_elements'] = $opts;
  return $initArray;
 }
 add_filter('tiny_mce_before_init', 'override_mce_options'); 

function add_theme_codes() {

 wp_enqueue_style( 'style', 'https://use.typekit.net/nos4abm.css', 'all');
 // if( is_page( 36382 ) ) { 
 // }
 if(!is_home() && !is_front_page() ){
    wp_enqueue_script( 'jquery-3.1', 'https://code.jquery.com/jquery-3.1.1.min.js', array(), false, true);
 }
  // wp_enqueue_script( 'filter-min', get_stylesheet_directory_uri() . '/js/filter.min.js', array(), false, true);
 wp_enqueue_script( 'custom', get_stylesheet_directory_uri() . '/js/custom.js', array(), false, true);
}

add_action( 'wp_enqueue_scripts', 'add_theme_codes' );

 // Remove WP Version From Styles   
   add_filter( 'style_loader_src', 'sdt_remove_ver_css_js', 9999 );
// Remove WP Version From Scripts
   add_filter( 'script_loader_src', 'sdt_remove_ver_css_js', 9999 );

// Function to remove version numbers
	function sdt_remove_ver_css_js( $src ) {
		if ( strpos( $src, 'ver=' ) )
			$src = remove_query_arg( 'ver', $src );
		return $src;
	}

// Johns ACF Stuff 
function get_suitable() {
  ?>
    <div class="rd-ve-icon">
      <img src="../wp-content/uploads/2020/04/car.svg">
      <div class="pc-h-i-name">
        Car
      </div>
    </div>
    <div class="rd-ve-icon">
      <img src="../wp-content/uploads/2020/04/LGV.svg">
      <div class="pc-h-i-name">
      Van
      </div>
    </div>
   <div class="rd-ve-icon">
      <img src="../wp-content/uploads/2020/04/HGV.svg">
      <div class="pc-h-i-name">
      Lorry
      </div>
    </div>
    <div class="rd-ve-icon">
      <img src="../wp-content/uploads/2020/04/motorhome.svg">
      <div class="pc-h-i-name">
        Motorhome
      </div>
    </div>
  <?php
}
add_shortcode( 'get-suitability', 'get_suitable' );

/*/ cust-products-filter shortcode /*/ 
add_shortcode( 'cust-products-filter', 'productsFilterFucntion' );
function productsFilterFucntion() {
  if(is_admin()){
      return "connected...";
  }
  ob_start();
  $categories = get_terms( 'category', array( 'hide_empty' => true, ) );
  $termsIds = array();
  foreach( $categories as $cat): $showcon = get_field('show_on_filter', 'category_'.$cat->term_id );
    if( $showcon && ($showcon == 1 || $showcon == '1' ) ) { 
      $termsIds[] = $cat->term_id;
    }
  endforeach;
  $productsargs = array(
    'post_type' => 'post',
    'posts_per_page' => -1,
    'post_status' => 'publish',
    'category__in' => $termsIds,
  );
  $products = new WP_Query( $productsargs );
  /*/ If post avalible to show /*/ 
  if ( $products->have_posts() ) { ?>
    <div  data-js="hero-demo">
      <h5 class="cat-list-title"><?php _e('Device Type', 'Smartrack');?></a></h5>
      <div class="ui-group">
        <div class="filters button-group js-radio-button-group device-type">
          <button class="button is-checked get-color-class " data-filter=".show-filter-items" data-item="all"><?php _e('ALL', 'Smartrack');?></a></button>
          <!-- Device Type category to show -->
          <?php #$categories = get_terms( 'category', array( 'hide_empty' => true, ) ); ?>
          <?php if( $categories ):
            foreach( $categories as $cat): $showcon = get_field('show_on_filter', 'category_'.$cat->term_id );
              if( $showcon && ($showcon == 1 || $showcon == '1' ) ) { ?>
                <button class="button get-color-class" data-color="<?php echo get_field('device_color', 'category_'.$cat->term_id )?:'#AC006C';?>" data-filter=".show-filter-items" data-item=".<?php echo $cat->slug;?>" data-item=".<?php echo $tag->slug;?>"><?php echo $cat->name;?></button>
              <?php }
            endforeach; ?>
          <?php endif; ?>
        </div>
      </div>
      <h5 class="cat-list-title"><?php _e('Vehicle Type', 'Smartrack');?></h5>
      <div class="ui-group">
        <div class="filters button-group js-radio-button-group vehicle-type">
          <button class="button is-checked get-color-class  is-checked" data-image="defualt-filter-img" data-filter=".show-filter-items" data-item="all"><?php _e('ALL', 'Smartrack');?></a></button>
          <!-- Vehicle Type category to show -->
          <?php $tages = get_terms( 'post_tag', array( 'hide_empty' => true, 'supress_filters' => true ) );
          if( $tages ):
            foreach( $tages as $tag): $showcon = get_field('show_on_filter', 'post_tag_'.$tag->term_id );
              if( $showcon && ($showcon == 1 || $showcon == '1' ) ) { ?>
                <button class="button get-color-class" data-image="filter-img-<?php echo $tag->term_id;?>" data-color="<?php echo get_field('tag_color', 'post_tag_'.$tag->term_id )?:'#AC006C';?>" data-filter=".show-filter-items" data-item="<?php echo $tag->slug;?>" ><?php echo $tag->name;?></button>
              <?php }
            endforeach; ?>
          <?php endif; ?>
        </div>
      </div>
      <!-- show post to show -->
      <ul class="grid all-item-class">
        <?php while ( $products->have_posts() ) : $products->the_post(); $postId = get_the_ID(); /* start while loop */
          ob_start(); the_content(); $postContent = ob_get_clean(); // get content
          $postColor = get_field('featured_color') ?:'#AC006C'; // get color
          $image = wp_get_attachment_image_src( get_post_thumbnail_id( get_the_ID() ), 'full' ); // fetured image
          $term_obj_list = get_the_terms( get_the_ID(), 'post_tag' ); // get tags for class
          // if post dont have any tags
          if($term_obj_list){
            $termslist = wp_list_pluck($term_obj_list, 'slug'); // get slug for
            $termsIds = wp_list_pluck($term_obj_list, 'term_id'); // get slug for
          } else {
            $termslist =  $termsNamelist = array('no','data');
            $termsIds = array( 0, );
          }
          // if this post have fix color class
          $fixColor = get_field('fix_color')?:'';
          if( $fixColor && ( $fixColor == '1' || $fixColor == 1) ){
            $fixColor = "nofilter";
          }
          // get category for filter 
          $categoriesList = get_the_terms( get_the_ID(), 'category' );  $categoriesList = wp_list_pluck($categoriesList, 'slug'); ?>
            <li class="element-item <?php echo join(' ', $termslist); ?> " data-category=".<?php echo join(",.",$categoriesList);?>">
             <div>
              <img src="<?php echo $image[0];?>" alt="banner" class="filter-imgs defualt-filter-img">
              <?php $filterImage = get_field( 'vehicle_type_images' );
              	foreach ( $termsIds as $value ) { 
              		if( $filterImage && is_array($filterImage) ): $data = true;
              			foreach ($filterImage as $tagsDetail ) {
              				if( $tagsDetail['vehicle_type'] == $value ) : $data = false; ?>
              					<img src="<?php echo $tagsDetail['image']?:$image[0];?>" alt="banner" class="filter-imgs filter-img-<?php echo $value; ?>" style="display: none;">
              					<?php break;
              				endif; ?>
              			<?php }
              			if( $data ){ ?>
              	 			<img src="<?php echo $image[0];?>" alt="banner" class="filter-imgs filter-img-<?php echo $value; ?>" style="display: none;">	
              			<?php } ?>
              		<?php else: ?>
              			<img src="<?php echo $image[0];?>" alt="banner" class="filter-imgs filter-img-<?php echo $value; ?>" style="display: none;">
              		<?php endif;
              	} ?>
              <div class="shape put-bg-color-class <?php echo $fixColor;?> show-filter-items" defualt-color="<?php echo $postColor;?>" defualt-color="<?php echo $postColor;?>" style="background-color: <?php echo $postColor;?>;"></div>
              <h3><?php echo get_the_title(); ?></h3>
              <div class="filter-desc-sec <?php echo $fixColor;?>" defualt-color="<?php echo $postColor;?>">
                <?php echo $postContent;  /* post conetnt */?>
              </div>
             </div>
              <a href="<?php echo get_field('button_url',$postId )?:'javascript:void(0);';?>" class="view-product-btn put-bg-color-class <?php echo $fixColor;?>" defualt-color="<?php echo $postColor;?>" style="background-color:<?php echo $postColor;?>"><?php _e('VIEW PRODUCT', 'Smartrack');?></a> 
            </li>
        <?php endwhile; /* end while loop */?>
      </ul>
      <div class="not-found-filter" style="display: none;"><h3 style="text-align: center; margin-bottom: 30px;"><?php _e('No Product Found!', 'Smartrack'); ?></h3></div>           
    </div>
  <?php } else {
      echo __( 'No Product Found!', 'Smartrack' );
  }
  wp_reset_postdata();
  return ob_get_clean();
}

// function rd_change_cat_label() {
//     global $submenu;
//     $submenu['edit.php'][15][0] = 'Device Type'; // Rename categories to Authors
// }
// add_action( 'admin_menu', 'rd_change_cat_label' );

// function rd_change_cat_object() {
//     global $wp_taxonomies;
//     $labels = &$wp_taxonomies['category']->labels;
//     $labels->name = 'Device Type';
//     $labels->singular_name = 'Device Type';
//     $labels->add_new = 'Add Device Type';
//     $labels->add_new_item = 'Add Device Type';
//     $labels->edit_item = 'Edit Device Type';
//     $labels->new_item = 'Device Type';
//     $labels->view_item = 'View Device Type';
//     $labels->search_items = 'Search Device Types';
//     $labels->not_found = 'No Device Types found';
//     $labels->not_found_in_trash = 'No Device Types found in Trash';
//     $labels->all_items = 'All Device Types';
//     $labels->menu_name = 'Device Type';
//     $labels->name_admin_bar = 'Device Type';
// }
// add_action( 'init', 'rd_change_cat_object' );

// function rd_change_tag_object() {
//     global $wp_taxonomies;
//     $labels = &$wp_taxonomies['post_tag']->labels;
//     $labels->name = 'Vehicle Type';
//     $labels->singular_name = 'Vehicle Type';
//     $labels->add_new = 'Add Vehicle Type';
//     $labels->add_new_item = 'Add Vehicle Type';
//     $labels->edit_item = 'Edit Vehicle Type';
//     $labels->new_item = 'Vehicle Type';
//     $labels->view_item = 'View Vehicle Type';
//     $labels->search_items = 'Search Vehicle Types';
//     $labels->not_found = 'No Vehicle Types found';
//     $labels->not_found_in_trash = 'No Vehicle Types found in Trash';
//     $labels->all_items = 'All Vehicle Types';
//     $labels->menu_name = 'Vehicle Type';
//     $labels->name_admin_bar = 'Vehicle Type';
// }
// add_action( 'init', 'rd_change_tag_object' );