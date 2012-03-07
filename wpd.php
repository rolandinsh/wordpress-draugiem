<?php 
/**
 * Plugin Name: WordPress Draugiem
 * Plugin URI: http://mediabox.lv/wordpress-draugiem/?utm_source=wordpress&utm_medium=wpplugin&utm_campaign=WordPressDraugiem&utm_content=v-1-4-0-wp-draugiem_load_widgets
 * Description: WordPress plugin for Latvian Social Network Draugiem.lv
 * Version: 1.4.0
 * Requires at least: 2.6
 * Author: Rolands Umbrovskis
 * Author URI: http://umbrovskis.com
 * License: GPL
 */



define('WPDRAUGIEMV','1.4.0'); // location general @since 1.0.0
define('WPDRAUGIEM',dirname(__FILE__)); // location general @since 1.0.0
define('WPDRAUGIEMF','wordpress-draugiem'); // location folder @since 1.0.0
define('WPDRAUGIEMURL', plugin_dir_url(__FILE__));
define('WPDRAUGIEMI',WPDRAUGIEMURL.'/img'); // Image location @since 1.0.0
define('WPDWPORG','http://wordpress.org/extend/plugins/'.WPDRAUGIEMF); // Image location @since 1.0.0

// We will use this later ;)
/* SMC WordPress Draugiem Class for later development
* @todo make extendable class (OOP)
*/
class SMC_WordPress_Draugiem{
	function SMC_WordPress_Draugiem(){
			return '';
		}
} 

function smcwpd_set_plugin_meta($links, $file) {
	$plugin = plugin_basename(__FILE__);
	// create link
	if ($file == $plugin) {
		return array_merge( $links, array( 

			'<a href="http://atbalsts.mediabox.lv/diskusija/wordpress-darugiem-atbalsts/">' . __('Support Forum') . '</a>',
			'<a href="http://atbalsts.mediabox.lv/diskusija/wordpress-darugiem-atbalsts/#new-post">' . __('Feature request') . '</a>',
			'<a href="http://atbalsts.mediabox.lv/wiki/WordPress_Draugiem">' . __('Wiki page') . '</a>',
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
	$paradit_smcwpd =0;
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

function smcwp_ieteikt_shortcode_list($atts) {
     extract(shortcode_atts(array(
	      'domain' => get_home_url(),
	      'count' => 5,
	      'id' => 'smc_wpd_recommend_list',
     ), $atts));
	 
	global $post;

	return '<!-- WordPress Draugiem '.WPDRAUGIEMV.' by Rolands Umbrovskis | http://mediabox.lv/wordpress-draugiem/ --><iframe src="http://www.draugiem.lv/say/ext/recommend.php?url='.$domain.'&count='.$count.'" frameborder="0" class="smc_draugiem_recommend_list" id="'.$id.'"></iframe><!-- //WordPress Draugiem -->';
}
add_shortcode('ieteikumusaraksts', 'smcwp_ieteikt_shortcode_list');



include_once(WPDRAUGIEM.'/admin/autoload_admin.php');

 