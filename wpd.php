<?php 
/**
 * Plugin Name: WordPress Draugiem
 * Plugin URI: http://mediabox.lv/wordpress-draugiem/?utm_source=wordpress&utm_medium=wpplugin&utm_campaign=WordPressDraugiem&utm_content=v-1-2-1-wp-draugiem_load_widgets
 * Description: WordPress plugin for Latvian Social Network Draugiem.lv
 * Version: 1.3.0
 * Requires at least: 2.6
 * Author: Rolands Umbrovskis
 * Author URI: http://umbrovskis.com
 * License: GPL
 */



define('WPDRAUGIEMV','1.3.0'); // location general @since 1.0.0
define('WPDRAUGIEM',dirname(__FILE__)); // location general @since 1.0.0
define('WPDRAUGIEMF','wordpress-draugiem'); // location folder @since 1.0.0
define('WPDRAUGIEMURL', plugin_dir_url(__FILE__));
define('WPDRAUGIEMI',WPDRAUGIEMURL.'/img'); // Image location @since 1.0.0

// We will use this later ;)
/* SMC WordPress Draugiem Class for later development
* @todo make extendable class (OOP)
*/
class SMC_WordPress_Draugiem{} 

function smcwpd_set_plugin_meta($links, $file) {
	$plugin = plugin_basename(__FILE__);
	// create link
	if ($file == $plugin) {
		return array_merge( $links, array( 

			'<a href="http://atbalsts.mediabox.lv/diskusija/draugiem-lv-biznesa-lapu-wordpress-spraudnis/#new-post">' . __('Support Forum') . '</a>',
			'<a href="http://atbalsts.mediabox.lv/temats/ieteikumi/#new-post">' . __('Feature request') . '</a>',
			'<a href="http://atbalsts.mediabox.lv/wiki/Draugiem.lv_biznesa_lapu_fanu_Wordpress_spraudnis">' . __('Wiki page') . '</a>',
			//'<a href="http://darbi.mediabox.lv/draugiem-lvlapas-fanu-wordpress-spraudnis/">www</a>',
			'<a href="http://umbrovskis.com/ziedo/">' . __('Donate') . '</a>'
			// ,'<a href="http://umbrovskis.com/">Umbrovskis.com</a>'
		));
	}
	return $links;
}

add_filter( 'plugin_row_meta', 'smcwpd_set_plugin_meta', 10, 2 );

function smc_draugiem_say_content($content){
	global $post;
	$showsmcwpd = get_option('smc_wpd_ieteikt_all');
	$smcwpd_showfield = get_post_meta($post->ID, 'smcwpd_showfield', true);
/*
 * @todo optimizēt!
*/
	if($showsmcwpd!='on' && $smcwpd_showfield=='1'){$paradit_smcwpd=1;}
	if($showsmcwpd=='on' && !$smcwpd_showfield){$paradit_smcwpd=1;}
	if($showsmcwpd=='on' && $smcwpd_showfield=='1'){$paradit_smcwpd=1;}
	if($showsmcwpd=='on' && $smcwpd_showfield=='0'){$paradit_smcwpd=0;}
	
	if($paradit_smcwpd==1):
		if (!is_feed()) :
			$posturl = urlencode(get_permalink($post->ID));
			$posttitle = urlencode($post->post_title);
			$smcwpd_ieteikt_location = get_option('smc_wpd_ieteikt_where');
			$awesomeblog = urlencode(get_bloginfo('name'));
			if($smcwpd_ieteikt_location==='1'){
				return '<!-- WordPress Draugiem '.WPDRAUGIEMV.' by Rolands Umbrovskis | http://mediabox.lv/wordpress-draugiem/ --><p class="smc_draugiem_ieteikt"><iframe height="20" width="84" frameborder="0" src="http://www.draugiem.lv/say/ext/like.php?title='.$posttitle.'&amp;url='.$posturl.'&amp;titlePrefix='.$awesomeblog.'"></iframe></p><!-- //WordPress Draugiem -->'.$content;
			}elseif($smcwpd_ieteikt_location==='2'){
				return $content.'<!-- WordPress Draugiem '.WPDRAUGIEMV.' by Rolands Umbrovskis | http://mediabox.lv/wordpress-draugiem/ --><p class="smc_draugiem_ieteikt"><iframe height="20" width="84" frameborder="0" src="http://www.draugiem.lv/say/ext/like.php?title='.$posttitle.'&amp;url='.$posturl.'&amp;titlePrefix='.$awesomeblog.'"></iframe></p><!-- //WordPress Draugiem -->';
			}
			elseif($smcwpd_ieteikt_location==='3'){
				return '<p class="smc_draugiem_ieteikt"><iframe height="20" width="84" frameborder="0" src="http://www.draugiem.lv/say/ext/like.php?title='.$posttitle.'&amp;url='.$posturl.'&amp;titlePrefix='.$awesomeblog.'"></iframe></p>'.$content.'<!-- WordPress Draugiem '.WPDRAUGIEMV.' by Rolands Umbrovskis | http://mediabox.lv/wordpress-draugiem/ --><p class="smc_draugiem_ieteikt"><iframe height="20" width="84" frameborder="0" src="http://www.draugiem.lv/say/ext/like.php?title='.$posttitle.'&amp;url='.$posturl.'&amp;titlePrefix='.$awesomeblog.'"></iframe></p><!-- //WordPress Draugiem -->';
			}
			else{
				return $content;
			}
			
		endif;
	else:
		return $content;

	endif;
}
add_filter('the_content', 'smc_draugiem_say_content');


function smc_draugiem_say_head(){
	global $post;
	$showsmcwpdh = get_option('smc_wpd_ieteikt_all');
	$smcwpd_showfieldh = get_post_meta($post->ID, 'smcwpd_showfield', true);
/*
 * @todo optimizēt!
*/
	if($showsmcwpdh!='on' && $smcwpd_showfieldh=='1'){$paradit_smcwpdh=1;}
	if($showsmcwpdh=='on' && !$smcwpd_showfieldh){$paradit_smcwpdh=1;}
	if($showsmcwpdh=='on' && $smcwpd_showfieldh=='1'){$paradit_smcwpdh=1;}
	if($showsmcwpdh=='on' && $smcwpd_showfieldh=='0'){$paradit_smcwpdh=0;}
	if(is_singular() && $paradit_smcwpdh==1){
		if(has_post_thumbnail($post->ID)) {
			$smc_draugiem_head_img = wp_get_attachment_image_src( get_post_thumbnail_id( $post->ID ),'thumbnail');
			echo '<meta name="dr:say:img" content="'.esc_attr( $smc_draugiem_head_img[0] ).'" />';
		}
		echo '<meta name="dr:say:title" content="'.esc_attr( $post->post_title ).'" />';
	}

}
add_filter('wp_head', 'smc_draugiem_say_head',2);

// --------------------------------------------------------------------------------
/* Define the custom box */

add_action( 'add_meta_boxes', 'smc_wpd_add_pmetbox' );
add_action( 'save_post', 'smc_wpd_save_postmetadata' );

/* Adds a box to the main column on the Post and Page edit screens */
function smc_wpd_add_pmetbox() {
    add_meta_box('smcwpd_metabox_section','WordPress Draugiem','smc_wpd_metawrapbox','post','side');
    add_meta_box('smcwpd_metabox_section','WordPress Draugiem','smc_wpd_metawrapbox','page','side');
}

/* Prints the box content */
function smc_wpd_metawrapbox( $post ) {
	$smcwpd_showfieldv = get_post_meta($post->ID, 'smcwpd_showfield', true);
	wp_nonce_field( plugin_basename( __FILE__ ), 'wpd_noncex' );
	echo '<label for="smcwpd_showfield">Rādīt šajā lapā</label> ';
	echo '<input type="checkbox" id="smcwpd_showfield" name="smcwpd_showfield" value="1" '.checked( $smcwpd_showfieldv, 1 ).' />';
	
}

function smc_wpd_save_postmetadata( $post_id ) {
  if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) 
      return;

  if ( !wp_verify_nonce( $_POST['wpd_noncex'], plugin_basename( __FILE__ ) ) )
      return;

  if ('page' == $_POST['post_type']){
    if(!current_user_can('edit_page',$post_id))
        return;
  }
  else{
	  if(!current_user_can('edit_post', $post_id) )
        return;
  }

  $smcwpd_postdata = $_POST['smcwpd_showfield'];
  
  update_post_meta($post_id, 'smcwpd_showfield', $smcwpd_postdata); // location general @since 1.2.1


  //
}

/*
 * Draugiem ieteikt pogas īsais kods 
 * @since 1.3.0
*/
function smcwp_ieteikt_shortcode() {
	global $post;
	
	$posturl = urlencode(get_permalink($post->ID));
	$posttitle = urlencode($post->post_title);
	$awesomeblog = urlencode(get_bloginfo('name'));
	
	return '<!-- WordPress Draugiem '.WPDRAUGIEMV.' by Rolands Umbrovskis | http://mediabox.lv/wordpress-draugiem/ --><iframe height="20" width="84" frameborder="0" src="http://www.draugiem.lv/say/ext/like.php?title='.$posttitle.'&amp;url='.$posturl.'&amp;titlePrefix='.$awesomeblog.'"></iframe><!-- //WordPress Draugiem -->';
}
add_shortcode('ieteiktdraugiem', 'smcwp_ieteikt_shortcode');


include_once(WPDRAUGIEM.'/admin/autoload_admin.php');

 