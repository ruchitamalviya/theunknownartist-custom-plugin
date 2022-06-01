(function( $ ) {
	'use strict';

	/**
	 * All of the code for your public-facing JavaScript source
	 * should reside in this file.
	 *
	 * Note: It has been assumed you will write jQuery code here, so the
	 * $ function reference has been prepared for usage within the scope
	 * of this function.
	 *
	 * This enables you to define handlers, for when the DOM is ready:
	 *
	 * $(function() {
	 *
	 * });
	 *
	 * When the window is loaded:
	 *
	 * $( window ).load(function() {
	 *
	 * });
	 *
	 * ...and/or other possibilities.
	 *
	 * Ideally, it is not considered best practise to attach more than a
	 * single DOM-ready or window-load handler for a particular page.
	 * Although scripts in the WordPress core, Plugins and Themes may be
	 * practising this, we should strive to set a better example in our own work.
	 */
	jQuery(document).ready(function(){

		let imagePath = etsDevScriptParam.image_url;
		jQuery('#tab-title-reviews').prepend('<img src="'+imagePath+'/public/img/chat.png" class="chat_pic"/>');
		jQuery('#submit').addClass('ets-custom-submit');
		let currentUrl = window.location.href;
		jQuery('body').addClass('ets-custom-body');
		let productUrl = etsDevScriptParam.product_url;

		if(currentUrl == productUrl){
			jQuery('body').addClass('ets-product-body');
		}
		jQuery("#ets_search_submit").click(function(){			
			berocket_do_action('update_products', 'filter', jQuery(this));
		});
	
		let ets_add_keyword_search_param = function(url){
			let urlArr = url.split('?');
			let paramString = urlArr[1];
			let queryString = new URLSearchParams(paramString);

			for (let pair of queryString.entries()) {
				if (pair[0] == 'query') {
					queryString.delete('query');
				}
			}
			queryString.append('query', jQuery.trim( jQuery(".ets-srh-field").val() ));
			return urlArr[0] + '?' + queryString.toString();	
		}
		if ( typeof(berocket_add_filter) == 'function' ) {
				berocket_add_filter('before_update_products_context_url_filtered', ets_add_keyword_search_param);
		} else {
					jQuery(document).on('berocket_hooks_ready', function() {
					berocket_add_filter('before_update_products_context_url_filtered', ets_add_keyword_search_param);
					});				
		}
		jQuery(document).on('click', '.bapf_reset', function() {
				jQuery('.ets-srh-field').val('');
				let url = window.location.href;
				window.location.href = etsDevScriptParam.shop_url;

	     });
		
		jQuery(document).on('click', '#show_all_terms',function(event) {
			event.preventDefault();
	     });

		jQuery(document).on('keyup', '.review_word_count',function() {
			
			let maxLength = 2000;
			let charValue = jQuery(this).val();
			
			let currentLength = charValue.length;

			if( currentLength > maxLength ) {
				charValue = charValue.substring(0, maxLength);
				console.log(charValue);
			} else {
				jQuery('.review_word_show').text(currentLength);
				console.log(currentLength);
			}
		});

		jQuery(document).on('click', '.load_more_attr',function(e) {
			e.preventDefault();
		 	jQuery('.show_more_attr, .load_more_attr.sh-ls, .load_more_attr.sh-mr').toggle();

		});
		
		jQuery(document).on('click', '.load_more_moattr',function(e) {
			e.preventDefault();
		 	jQuery('.show_more_moattr, .load_more_moattr.sh-mls, .load_more_moattr.sh-mmr').toggle();

		});

		// jQuery('.show_more_moattr').hide();
		// jQuery(document).on('click', '.load_more_moattr',function() {	
		//  	jQuery('.show_more_moattr').toggle();
		//  	jQuery('#tgl').toggleClass(' far fa-angle-up far fa-angle-down');

		// });
		

		jQuery('.single-product .related.products .products').slick({
			infinite: false,
			slidesToShow: 4,
			slidesToScroll:4,
			dots:true,
			responsive: true,
			mobileFirst:false,
			prevArrow: '<button class="slide-arrow prev-arrow custom_prev"><i class="far fa-chevron-left"></i></button>',
			nextArrow: '<button class="slide-arrow next-arrow custom_next"><i class="fal fa-chevron-right"></i></button>',
					
			responsive: [
			       
			        {
			          breakpoint: 600,
			          settings: {
						slidesToShow: 1,
						slidesToScroll: 1,
			          },
			        },
			        {
			      breakpoint: 1000,
				      settings: {
				        slidesToShow: 2,
				        slidesToScroll: 2,
				      },
			  		},
			      ],
			      
			      

 		});

		jQuery('.share-product').on('click', function(){
			jQuery('.share-product-link').toggle();
		});

		// jQuery('#sfsiid_facebook').on('click', function(){
		// 	alert("here");
		// });
		
	});

})( jQuery );
