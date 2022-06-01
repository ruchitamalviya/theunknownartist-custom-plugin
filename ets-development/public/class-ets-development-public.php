<?php

/**
 * The public-facing functionality of the plugin.
 *
 * @link         https://www.expresstechsoftwares.com/
 * @since      1.0.0
 *
 * @package    Ets_Development
 * @subpackage Ets_Development/public
 */

/**
 * The public-facing functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the public-facing stylesheet and JavaScript.
 *
 * @package    Ets_Development
 * @subpackage Ets_Development/public
 * @author     ExpressTech Softwares Solutions Pvt Ltd <www.expresstechsoftwares.com>
 */
class Ets_Development_Public {

	/**
	 * The ID of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $plugin_name    The ID of this plugin.
	 */
	private $plugin_name;

	/**
	 * The version of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $version    The current version of this plugin.
	 */
	private $version;

	/**
	 * Initialize the class and set its properties.
	 *
	 * @since    1.0.0
	 * @param      string    $plugin_name       The name of the plugin.
	 * @param      string    $version    The version of this plugin.
	 */
	public function __construct( $plugin_name, $version ) {

		$this->plugin_name = $plugin_name;
		$this->version = $version;

	}

	public function remove_wooleneter_slick_css() {
		wp_dequeue_style('slick');
	}

	/**
	 * Register the stylesheets for the public-facing side of the site.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_styles() {

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Ets_Development_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Ets_Development_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */
		$version = 1.0;
		wp_enqueue_style( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'css/ets-development-public.css', array(), $this->version, 'all' );
		wp_enqueue_style( $this->plugin_name.'product-css', plugin_dir_url( __FILE__ ) . 'css/ets-development-product-detail-public.css', array(), $this->version, 'all' );
		

		wp_enqueue_style( $this->plugin_name.'-slick-css', plugin_dir_url( __FILE__ ) . 'slick-master/slick/slick.css', array(), $this->version, 'all' );

		wp_enqueue_style( $this->plugin_name.'-slick-theme-css', plugin_dir_url( __FILE__ ) . 'slick-master/slick/slick-theme.css', array(), $this->version, 'all' );

	}
 	public function ets_wp_fontawasome() {
    wp_enqueue_style( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'css/font-awesome.min.css', array(), $this->version, 'all' );
	}


	public function remove_wooleneter_slick_js() {
		wp_dequeue_script('slick');
	}
	

	/**
	 * Register the JavaScript for the public-facing side of the site.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_scripts() {
		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Ets_Development_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Ets_Development_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */
		$version = 1.0;
		wp_enqueue_script( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'js/ets-development-public.js', array( 'jquery' ), $this->version, false );
		$script_param = array(
			'shop_url' => wc_get_page_permalink( 'shop' ),
			'admin_ajax'   => admin_url( 'admin-ajax.php' ),
			'image_url'    => ETS_DEVELOPMENT_PLUGIN_URL,
			'product_url' =>  get_permalink($product_id),
		);
		wp_localize_script($this->plugin_name, 'etsDevScriptParam',$script_param);
		wp_enqueue_script( $this->plugin_name.'-slick-js', plugin_dir_url( __FILE__ ) . 'slick-master/slick/slick.js', array('jquery'), $this->version, 'all' );
		
	}

	public function ets_add_shop_short_description() {
		the_excerpt();
	}
	
	public function ets_remove_cart_button() {
	
	if (is_shop()) {
			return false;
		}
		return true;	    
	}

	public function ets_show_empty_terms($get_terms_args, $instance, $args)
	{
		$get_terms_args['hide_empty'] = false;
		return $get_terms_args;
	}
	public function ets_custom_search() {
		global $avia_config; 

		$search_params = apply_filters('avf_frontend_search_form_param', array(
		'placeholder'    => __('Search','avia_framework'),
		'search_id'       => 's',
		'form_action'  => get_site_url().'/shop/' ,
		'ajax_disable'  => true
		)); 
		$disable_ajax = $search_params['ajax_disable'] == false ? "" : "av_disable_ajax_search";
		?>	
		<div class="search_container">
		<input type="search" id="woocommerce-product-search-field-<?php echo isset( $index ) ? absint( $index ) : 0; ?>" class="ets-srh-field search-field" placeholder="<?php echo esc_attr__( "I'm searching for..&hellip;", 'woocommerce' ); ?>" value="" name="search" /><i class="fas fa-search" id="search_icon"></i>
		<button type="submit" name="ets_text_submit" id="ets_search_submit" class="button" >Search</button> <button type="submit" name="ets_mobile_btn" id="ets_mobile_btn" class="button" ><i class="fal fa-search fa-2x"></i></button></div>
		<?php
	}
	public function ets_before_filter_query( $query )	{
		$search_term = '';
		if( isset( $_GET['query'] ) &&  $_GET['query'] ) {	
			$search_term = $_GET['query'];
			$query->set("s", $search_term);				
		}
		return $query;	
	}
	public function ets_add_shopping_bag()	{
		 echo '<i class="fal fa-shopping-bag ets_bag"></i>';
	}
	//remove quantity
	public function remove_all_quantity_fields( $return, $product ) {
		return true;
	}
	//remove addtional tab
	public function ets_remove_product_tabs( $tabs ) {
		unset( $tabs['description'] );
		unset( $tabs['test_tab'] );
		unset( $tabs['wcfm_policies_tab'] );
		unset( $tabs['wcfm_enquiry_tab'] );
    	unset( $tabs['additional_information'] ); 
    	return $tabs;
	}
	public function ets_add_long_description() {
		 global $product;
		 ?>
	        <div itemprop="description" class="long_description">
	        	 <?php echo "<h6 class='about_art'>About this artwork</h6>";?>
	            <?php echo apply_filters( 'the_content', $product->get_description() ) ?>
	        </div>
		<?php
	}
	
	public function ets_save_review_setting( $product_id ) {
		$product = wc_get_product( $product_id );
		$product->set_reviews_allowed(true);
		$product->save();
	 } 
	// add slider product thumbnail
	 public function ets_add_product_carousel( $options )  {
		$options['directionNav'] = true;   		
		return $options;
	}
	//change review tab title
	public function rename_review_tabs($tabs) {
		if ( isset( $tabs['reviews'] ) ) {
			$tabs['reviews']['title'] = 'Comments';	
		}
		return $tabs;
	}
	//get shipping attribute
	public function ets_get_shipping_attribute() {
		global $product;
		$shipping = $product->get_attribute( 'pa_shipping-locations');
		$shipping_lable = wc_attribute_label('pa_shipping-locations');
		echo '<div class="ship_attri"><p class="ship_title">'.$shipping_lable.'</p><p class="ship_value">'.$shipping.'</p></div>';
	}
	//add artist work
	public function ets_add_artist_work(){?>
		
		
		<div class="custom_vector">
			<div class="cstm-sprt pull-left">
				<img src="<?php echo ETS_DEVELOPMENT_PLUGIN_URL.'public/img/Vector3x.png'?>" class="custom_work"/>
				<p class="artist_work_head"><?php _e('This artist does custom work', 'ets-development'); ?></p>				
			</div>
			<div class="shr-n-rpt pull-left">
				<div class="custom_shareicon share-product">
					<img src="<?php echo ETS_DEVELOPMENT_PLUGIN_URL.'public/img/arrow1.png'?>" class="custom_arrow"/>
					<span class="share_text"><?php _e('Share', 'ets-development'); ?></span>
					<div class="share-product-link">
						<?php echo do_shortcode('[DISPLAY_ULTIMATE_SOCIAL_ICONS ]');?>
					</div>
				</div>
				
				<div class="custom_report"><img src="<?php echo ETS_DEVELOPMENT_PLUGIN_URL.'public/img/delete.png'?>" class="custom_delete"/><span class="delete_text"><?php _e('Report', 'ets-development'); ?></span>
				</div>
			</div>
		</div>
		

		<?php
	}
	//add artist work for mobile
	public function ets_add_artist_work_mobile(){?>
		<div class="mobile_vector">
					<div class="cstm-mosprt">
						<img src="<?php echo ETS_DEVELOPMENT_PLUGIN_URL.'public/img/Vector3x.png'?>" class="custom_mobile_work"/>
						<p class="artist_mowork_head"><?php _e('This artist does custom work', 'ets-development'); ?></p>				
					</div>
					<div class="shrmo-n-rpt pull-left">
						<div class="custom_sharemobile share-product">
							<img src="<?php echo ETS_DEVELOPMENT_PLUGIN_URL.'public/img/arrow1.png'?>" class="custom_moarrow"/>
							<span class="share_motext"><?php _e('Share', 'ets-development'); ?></span>
							<div class="share-product-link">
								<?php echo do_shortcode('[DISPLAY_ULTIMATE_SOCIAL_ICONS ]');?>
							</div>
						</div>
						
						<div class="custom_moreport"><img src="<?php echo ETS_DEVELOPMENT_PLUGIN_URL.'public/img/delete.png'?>" class="custom_modelete"/><span class="delete_motext"><?php _e('Report', 'ets-development'); ?></span>
						</div>
					</div>
				</div>

		<!-- <div class="mobile_vector">
				<img src="<?php echo ETS_DEVELOPMENT_PLUGIN_URL.'public/img/Vector3x.png'?>" class="custom_mobile_work"/><p class="artist_mowork_head">This artist does custom work</p>
			<div class="custom_sharemobile share-product">
				<img src="<?php echo ETS_DEVELOPMENT_PLUGIN_URL.'public/img/arrow1.png'?>" class="custom_moarrow"/>
				<span class="share_motext">Share</span>
				<div class="share-product-link">
					<?php echo do_shortcode('[DISPLAY_ULTIMATE_SOCIAL_ICONS ]');?>
				</div>
			</div>
			<div class="custom_moreport">
				<img src="<?php echo ETS_DEVELOPMENT_PLUGIN_URL.'public/img/delete.png'?>" class="custom_modelete"/>
				<span class="delete_motext">Report</span>
			</div>
		</div> -->
		<?php
			global $product;
			$product_id = $product->get_id();
			$product = wc_get_product($product_id); 
			$product_title = $product->get_name();	
			$seller = get_post_field( 'post_author', $product->get_id());
	        $author  = get_user_by( 'id', $seller );

			?>
			<div class="ets_product_title">
				<p><?php echo $product_title; ?></p>
			</div>
			<?php
			echo "<div class='vendor_mobilename'>
				<p class='vendor_moname'>".$author->display_name."</p>
			</div>";
			?>
			
	
	
	<?php
	}

	public function ets_remove_white_list_single_page($show)
	{
		if (is_product() && is_single()) {
			$show = false;
			return $show;
		}
		return $show;
	}
	
	public function add_wishlist(){?>
	<div class="single_wish_icon">	
		 <?php echo do_shortcode('[yith_wcwl_add_to_wishlist]')?>
	</div>
	
	 	<?php
	}	
	//get artist name
	public function ets_add_artist_name()	{
		global $product;
		$seller = get_post_field( 'post_author', $product->get_id());
        $author  = get_user_by( 'id', $seller );
		echo "<h6 class='vendor_name'>".$author->display_name."</h6>";
	}
	//change review btn text
	public function ets_review_publish_btn($comment_form)	{
		$comment_form['label_submit'] = 'Publish';
		return $comment_form;
	}
	
	public function ets_add_realted_product(){
		global $product;
		if( ! is_a( $product, 'WC_Product' ) ){
		    $product = wc_get_product(get_the_id());
		}

		woocommerce_related_products( array(
		    'posts_per_page' => 4,
		    'columns'        => 4,
		    'orderby'        => 'rand'
		) );
	}

	public function display_some_product_attributes() {
		global $product;
	    $defined_attributes = array('artistic-techniques', 'framing');
	    $attributes = $product->get_attributes();
	     
	    if ( ! $attributes ) {
	        return;
	    }

	    $out = '<section class="show_two_attr"><ul class="taste-attributes">';

	    foreach ( $attributes as $attribute ) {
	        // Get the product attribute slug from the taxonomy
	        $attribute_slug = str_replace( 'pa_', '', $attribute->get_name() );

	        // skip all non desired product attributes
	        if ( ! in_array($attribute_slug, $defined_attributes) ) {
	            continue;
	        }

	        $name = $attribute->get_name();

	        if ( $attribute->is_taxonomy() ) {

	            $tax_label = $attribute->get_taxonomy_object()->attribute_label;

	            $out .= sprintf('<li class="ets-att-%s">', esc_attr( $name ));
	            $out .= sprintf('<p class="attribute-label">%s</p>', esc_html( $tax_label ));
	            $tax_terms = array();

	            $terms = $attribute->get_terms();
	            foreach ( $terms as $term ) {
	                $single_term = esc_html( $term->name );
	                array_push( $tax_terms, $single_term );
	            }

	            $out .= sprintf('<span class="attribute-value">%s</span>', implode(', ', $tax_terms));	
	        }
	    }

	    $out .= sprintf('</ul>');
	    echo $out;

	   
	    $defined_attributes = array('display', 'frame-type','high-resolution','length-unit','packaging','panting-techniques','paper','printmaking-techniques','reproduction','revision','sculptures-techniques','style','support-or-surface','theme','year-of-creation','art-type','artist-location','digital-painting-color');
	    $attributes = $product->get_attributes();
	     
	    if ( ! $attributes ) {
	        return;
	    }

	    $out = '<div class="show_more_attr" style="display:none;"><ul class="taste-attributes">';
	    foreach ( $attributes as $attribute ) {
	        // Get the product attribute slug from the taxonomy
	        $attribute_slug = str_replace( 'pa_', '', $attribute->get_name() );
	        // skip all non desired product attributes
	        if ( ! in_array($attribute_slug, $defined_attributes) ) {
	            continue;
	        }
	        $name = $attribute->get_name();

	        if ( $attribute->is_taxonomy() ) {

	            $tax_label = $attribute->get_taxonomy_object()->attribute_label;

	            $out .= sprintf('<li class="ets-att-%s">', esc_attr( $name ));
	            $out .= sprintf('<p class="attribute-label">%s</p>', esc_html( $tax_label ));
	            $tax_terms = array();

	            $terms = $attribute->get_terms();
	            foreach ( $terms as $term ) {
	                $single_term = esc_html( $term->name );
	                array_push( $tax_terms, $single_term );
	            }

	            $out .= sprintf('<span class="attribute-value">%s</span>', implode(', ', $tax_terms));	
	        }
	    }

	    $out .= '</ul></div>';
	    $out .= sprintf(
	    	'<a href="#" class="load_more_attr sh-mr">%s<i id="tgl" class="far fa-angle-down"></i></a>
	    	<a href="#" class="load_more_attr sh-ls" style="display:none;">%s<i id="tgl" class="far fa-angle-up"></i></a>',
	    	__('Load More', 'ets-development'),
	    	__('Show Less', 'ets-development')
	    );
	    $out .= '</section>';

	    echo $out;
	}

	public function ets_review_avtar(){
		 echo get_avatar($comment, apply_filters( 'woocommerce_review_gravatar_size', '60' ), '' );?>
		<p class="meta">
			<strong class="woocommerce-review__author"><?php comment_author(); ?> </strong>
		</p>
	<?php
	}
	
	public function ets_add_mobile_product_attr(){
		global $product;
	    $defined_attributes = array('artistic-techniques', 'framing');
	    $attributes = $product->get_attributes();
	     
	    if ( ! $attributes ) {
	        return;
	    }

	    $out = '<section class="show_two_moattr"><ul class="taste-attributes">';

	    foreach ( $attributes as $attribute ) {
	        // Get the product attribute slug from the taxonomy
	        $attribute_slug = str_replace( 'pa_', '', $attribute->get_name() );

	        // skip all non desired product attributes
	        if ( ! in_array($attribute_slug, $defined_attributes) ) {
	            continue;
	        }

	        $name = $attribute->get_name();

	        if ( $attribute->is_taxonomy() ) {

	            $tax_label = $attribute->get_taxonomy_object()->attribute_label;

	            $out .= sprintf('<li class="ets-moatt-%s">', esc_attr( $name ));
	            $out .= sprintf('<p class="attribute-label">%s</p>', esc_html( $tax_label ));
	            $tax_terms = array();

	            $terms = $attribute->get_terms();
	            foreach ( $terms as $term ) {
	                $single_term = esc_html( $term->name );
	                array_push( $tax_terms, $single_term );
	            }

	            $out .= sprintf('<span class="attribute-value">%s</span>', implode(', ', $tax_terms));	
	        }
	    }

	    $out .= sprintf('</ul>');
	    echo $out;

	   
	    $defined_attributes = array('display', 'frame-type','high-resolution','length-unit','packaging','panting-techniques','paper','printmaking-techniques','reproduction','revision','sculptures-techniques','style','support-or-surface','theme','year-of-creation','art-type','artist-location','digital-painting-color');
	    $attributes = $product->get_attributes();
	     
	    if ( ! $attributes ) {
	        return;
	    }

	    $out = '<div class="show_more_moattr" style="display:none;"><ul class="taste-attributes">';
	    foreach ( $attributes as $attribute ) {
	        // Get the product attribute slug from the taxonomy
	        $attribute_slug = str_replace( 'pa_', '', $attribute->get_name() );
	        // skip all non desired product attributes
	        if ( ! in_array($attribute_slug, $defined_attributes) ) {
	            continue;
	        }
	        $name = $attribute->get_name();

	        if ( $attribute->is_taxonomy() ) {

	            $tax_label = $attribute->get_taxonomy_object()->attribute_label;

	            $out .= sprintf('<li class="ets-moatt-%s">', esc_attr( $name ));
	            $out .= sprintf('<p class="attribute-label">%s</p>', esc_html( $tax_label ));
	            $tax_terms = array();

	            $terms = $attribute->get_terms();
	            foreach ( $terms as $term ) {
	                $single_term = esc_html( $term->name );
	                array_push( $tax_terms, $single_term );
	            }

	            $out .= sprintf('<span class="attribute-value">%s</span>', implode(', ', $tax_terms));	
	        }
	    }

	    $out .= '</ul></div>';
	    $out .= sprintf(
	    	'<a href="#" class="load_more_moattr sh-mmr">%s<i id="tgl" class="far fa-angle-down"></i></a>
	    	<a href="#" class="load_more_moattr sh-mls" style="display:none;">%s<i id="tgl" class="far fa-angle-up"></i></a>',
	    	__('Load More', 'ets-development'),
	    	__('Show Less', 'ets-development')
	    );
	    $out .= '</section>';

	    echo $out;

	}
}
