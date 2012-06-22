<?php 
/**
 * Plugin Name: WordPress Draugiem
 * Plugin URI: http://mediabox.lv/wordpress-draugiem/?utm_source=wordpress&utm_medium=wpplugin&utm_campaign=WordPressDraugiem&utm_content=v-1-5-1-wp-draugiem_load_widgets
 * Description: WordPress plugin for Latvian Social Network Draugiem.lv
 * Version: 1.5.1
 * Requires at least: 2.6
 * Author: Rolands Umbrovskis
 * Author URI: http://umbrovskis.com
 * License: GPL
 */



define('WPDRAUGIEMV','1.5.1'); // location general @since 1.0.0
define('WPDRAUGIEM',dirname(__FILE__)); // location general @since 1.0.0
define('WPDRAUGIEMF','wordpress-draugiem'); // location folder @since 1.0.0
define('WPDRAUGIEMURL', plugin_dir_url(__FILE__));
define('WPDRAUGIEMI',WPDRAUGIEMURL.'/img'); // Image location @since 1.0.0
define('WPDWPORG','http://wordpress.org/extend/plugins/'.WPDRAUGIEMF); // Image location @since 1.0.0

function wpdraugiem_init() {
  load_plugin_textdomain( 'wpdraugiem', false, dirname( plugin_basename( __FILE__ ) ). '/lang/'); 
}
add_action('init', 'wpdraugiem_init');
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

			'<a href="http://atbalsts.mediabox.lv/diskusija/wordpress-darugiem-atbalsts/">' . __('Support Forum','wpdraugiem') . '</a>',
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
	$paradit_smcwpd = 0;
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
				return '<!-- WordPress Draugiem '.WPDRAUGIEMV.' by Rolands Umbrovskis | http://mediabox.lv/wordpress-draugiem/ -->'."\n".'<p class="smc_draugiem_ieteikt"><iframe height="20" width="84" frameborder="0" src="http://www.draugiem.lv/say/ext/like.php?title='.$posttitle.'&amp;url='.$posturl.'&amp;titlePrefix='.$awesomeblog.'"></iframe></p>'."\n".'<!-- //WordPress Draugiem -->'.$content;
			}elseif($smcwpd_ieteikt_location==='2'){
				return $content.'<!-- WordPress Draugiem '.WPDRAUGIEMV.' by Rolands Umbrovskis | http://mediabox.lv/wordpress-draugiem/ -->'."\n".'<p class="smc_draugiem_ieteikt"><iframe height="20" width="84" frameborder="0" src="http://www.draugiem.lv/say/ext/like.php?title='.$posttitle.'&amp;url='.$posturl.'&amp;titlePrefix='.$awesomeblog.'"></iframe></p>'."\n".'<!-- //WordPress Draugiem -->';
			}
			elseif($smcwpd_ieteikt_location==='3'){
				return '<p class="smc_draugiem_ieteikt"><iframe height="20" width="84" frameborder="0" src="http://www.draugiem.lv/say/ext/like.php?title='.$posttitle.'&amp;url='.$posturl.'&amp;titlePrefix='.$awesomeblog.'"></iframe></p>'.$content."\n".'<!-- WordPress Draugiem '.WPDRAUGIEMV.' by Rolands Umbrovskis | http://mediabox.lv/wordpress-draugiem/ --><p class="smc_draugiem_ieteikt"><iframe height="20" width="84" frameborder="0" src="http://www.draugiem.lv/say/ext/like.php?title='.$posttitle.'&amp;url='.$posturl.'&amp;titlePrefix='.$awesomeblog.'"></iframe></p>'."\n".'<!-- //WordPress Draugiem -->';
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
	
	return '<!-- WordPress Draugiem '.WPDRAUGIEMV.' by Rolands Umbrovskis | http://mediabox.lv/wordpress-draugiem/ -->'."\n".'<iframe height="20" width="84" frameborder="0" src="http://www.draugiem.lv/say/ext/like.php?title='.$posttitle.'&amp;url='.$posturl.'&amp;titlePrefix='.$awesomeblog.'"></iframe>'."\n".'<!-- //WordPress Draugiem -->';
}
add_shortcode('ieteiktdraugiem', 'smcwp_ieteikt_shortcode');

function smcwp_ieteikt_shortcode_list($atts) {
     extract(shortcode_atts(array(
	      'domain' => get_home_url(),
	      'count' => 5,
	      'id' => 'smc_wpd_recommend_list',
     ), $atts));
	 
	global $post;

	return '<!-- WordPress Draugiem '.WPDRAUGIEMV.' by Rolands Umbrovskis | http://mediabox.lv/wordpress-draugiem/ -->'."\n".'<iframe src="http://www.draugiem.lv/say/ext/recommend.php?url='.$domain.'&count='.$count.'" frameborder="0" class="smc_draugiem_recommend_list" id="'.$id.'"></iframe>'."\n".'<!-- //WordPress Draugiem -->';
}
add_shortcode('ieteikumusaraksts', 'smcwp_ieteikt_shortcode_list');

/* ---------------------- 1.5.0 --------------------------- */

function wpdr_update_olddata(){
	if (is_numeric(get_transient("wpdr_rchck_counts"))){
		/* Ola kala */
	}else{
		wpdr_update_data();
	}
}

function wpdr_update_data(){

	$args = array(
		'posts_per_page' => 500,
		'orderby' => 'date',
		'order' => 'DESC',
		'ignore_sticky_posts' => 1,
		'post_type' => 'any' /* any public */
	);

	$filter_functions_and_cache_times = array(
		'old2d' => (60*60),
		'old2_7d' => (60*60*6),
		'old7_30d' => (60*60*12),
		'old30_180d' => (60*60*48),
		'old180dm' => (60*60*24*7)

	);
	$wpdr_trans_rnd = mt_rand(5,10);
	
	set_transient("wpdr_rchck_counts", 99, 60*$wpdr_trans_rnd);

	$api_hitr = 0;

	foreach ($filter_functions_and_cache_times as $date_range_filter_function=>$cache_time)
	{

		// Set the date range_filter
		add_filter( 'posts_where', $date_range_filter_function );

		$posts_in_range = new WP_Query( $args );
		
		while ( $posts_in_range->have_posts() ) : $posts_in_range->the_post();
			$wpdrtrans_base = "wpdr_trans_" . get_the_ID() . "_";
			if (is_numeric($dr_ieteikumi = get_transient($wpdrtrans_base."_dr_saids"))){
				$post_ieteikti = $dr_ieteikumi;
			}else{
				$api_hitr++;
				$draugiem_api_say_results = wp_remote_get("http://www.draugiem.lv/say/ext/like_count.php?url=" . get_permalink());
				$post_ieteiktic = json_decode($draugiem_api_say_results["body"]);

				$post_ieteikti = $post_ieteiktic->count;

				if (is_numeric($post_ieteikti)){

					$this_cache_time = $cache_time + rand(60*1, 60*25);
					set_transient($wpdrtrans_base."_dr_saids", $post_ieteikti, $this_cache_time);
					update_post_meta(get_the_ID(), "_wpdr_dr_saids", $post_ieteikti);

				}else{
					$post_ieteikti = intval(get_post_meta(get_the_ID(), "_wpdr_dr_saids", true));
					set_transient($wpdrtrans_base."_dr_saids", $post_ieteikti, 60*60*6);
				}
				
			}

			
			$post_totals = 0;
			$post_totals += intval($post_ieteikti);
			update_post_meta(get_the_ID(), "_wpdr_total_shares", $post_totals);

			if ($api_hitr > 14)
				break;
		endwhile;

		wp_reset_postdata();
		
		// Remove the date range filter.
		remove_filter('posts_where', $date_range_filter_function);
		if ($api_hitr > 14)
			break;
	}
}


add_action('wp_footer', 'wpdr_update_olddata');
/* --------------------------- end 1.5.0 --------------------------- */
function wpdr_head_generator(){ echo "\n<!-- WordPress Draugiem ".WPDRAUGIEMV." by Rolands Umbrovskis | http://mediabox.lv/wordpress-draugiem/ -->\n".'<meta name="generator" content="WordPress Draugiem by Rolands Umbrovskis" />'."\n<!-- WordPress Draugiem  ".WPDRAUGIEMV."  by Rolands Umbrovskis -->\n"; }
add_filter('wp_head', 'wpdr_head_generator',2); // location general @since 1.5.1

include_once(WPDRAUGIEM.'/admin/autoload_admin.php');

 