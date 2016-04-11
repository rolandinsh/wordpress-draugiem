<?php
/**
 * Plugin Name: WordPress Draugiem
 * Plugin URI: http://mediabox.lv/wordpress-draugiem/?utm_source=wordpress&utm_medium=wpplugin&utm_campaign=WordPressDraugiem&utm_content=v-2-1-2-wp-draugiem_load_widgets
 * Description: WordPress plugin for Latvian Social Network Draugiem.lv
 * Version: 2.1.2
 * Requires at least: 2.7
 * Tested up to: 4.4.2
 * Author: Rolands Umbrovskis
 * Author URI: https://umbrovskis.com/
 * License: simplemediacode
 * License URI: https://simplemediacode.com/license/
 */
define('WPDRAUGIEMV', '2.1.2'); // location general @since 1.0.0
define('WPDRAUGIEM', dirname(__FILE__)); // location general @since 1.0.0
define('WPDRAUGIEMF', 'wordpress-draugiem'); // location folder @since 1.0.0
define('WPDRAUGIEMURL', plugin_dir_url(__FILE__));
define('WPDRAUGIEMI', WPDRAUGIEMURL . '/img'); // Image location @since 1.0.0
define('WPDWPORG', 'http://wordpress.org/extend/plugins/' . WPDRAUGIEMF); // Image location @since 1.0.0

if (!defined('DRAUGIEMJSAPI')) {
    $ishttpsurl = is_ssl() ? 'https:' : 'http:';  // fix https @since 1.5.4.1
    define('DRAUGIEMJSAPI', $ishttpsurl . '//www.draugiem.lv/api/api.js');
} // unified constants across plugins @since 1.5.4


new WpDraugiem();
$smc_wp_draugiem = new WpDraugiem;
/* SMC WordPress Draugiem Class
 * @since 2.0.0
 */

class WpDraugiem
{

    public function __construct()
    {
        add_action('init', array('WpDraugiem', 'init'), 10);
        add_filter('plugin_row_meta', array('WpDraugiem', 'smcwpd_set_plugin_meta'), 10, 2);
        add_filter('the_content', array('WpDraugiem', 'smc_draugiem_say_content'));
        add_shortcode('ieteiktdraugiem', array('WpDraugiem', 'smcwp_ieteikt_shortcode'));
        add_shortcode('ieteikumusaraksts', array('WpDraugiem', 'smcwp_ieteikt_shortcode_list'));
        add_action('wp_footer', array('WpDraugiem', 'wpdr_update_olddata'));
        add_filter('wp_head', array('WpDraugiem', 'wpdr_head_generator'), 2); // location general @since 1.5.1
    }

    // Initialize
    public function init()
    {
        load_plugin_textdomain('wpdraugiem', false, dirname(plugin_basename(__FILE__)) . '/lang/');
    }

    public function smcwpd_set_plugin_meta($links, $file)
    {
        $plugin = plugin_basename(__FILE__);
        if ($file == $plugin) {
            return array_merge($links, array(
                '<a href="https://mediabox.lv/wordpress-draugiem/">www</a>',
                '<a href="https://umbrovskis.lv/labi-darbi/">' . __('Labs darbs?') . '</a>'
            ));
        }
        return $links;
    }

    function smc_draugiem_say_content($content)
    {
        global $post;
        $showsmcwpd = get_option('smc_wpd_ieteikt_all');
        $smcwpd_showfield = get_post_meta($post->ID, 'smcwpd_showfield', true);
        $smcwpd_ieteikt_look = get_option('smc_wpd_ieteikt_look');
        /*
         * @todo optimizēt smc_draugiem_say_content()!
         */
        $paradit_smcwpd = 0;
        if ($showsmcwpd != 'on' && $smcwpd_showfield == '1') {
            $paradit_smcwpd = 1;
        }
        if ($showsmcwpd == 'on' && !$smcwpd_showfield) {
            $paradit_smcwpd = 1;
        }
        if ($showsmcwpd == 'on' && $smcwpd_showfield == '1') {
            $paradit_smcwpd = 1;
        }
        if ($showsmcwpd == 'on' && $smcwpd_showfield == '0') {
            $paradit_smcwpd = 0;
        }
        if (!is_feed()) :
            if ($paradit_smcwpd == 1):
                $posturl = urlencode(get_permalink($post->ID));
                $posturlr = get_permalink($post->ID);
                $posttitle = urlencode($post->post_title);
                $posttitlee = addcslashes($post->post_title, '"');
                $smcwpd_ieteikt_location = get_option('smc_wpd_ieteikt_where');
                $awesomeblog = urlencode(get_bloginfo('name'));
                $awesomebloge = addcslashes(get_bloginfo('name'), '"');
                if ($smcwpd_ieteikt_location === '1') {
                    if ($smcwpd_ieteikt_look == '2') {
                        return '<!-- WordPress Draugiem ' . WPDRAUGIEMV . ' by Rolands Umbrovskis | http://mediabox.lv/wordpress-draugiem/ -->' . "\n" . '<div class="smc_draugiem_ieteikt"><div id="draugiemLike-' . $post->ID . '"></div><script type="text/javascript">var p = {layout:"bubble",link:"' . $posturlr . '", title:"' . $posttitlee . '", titlePrefix:"' . $awesomebloge . '"}; new DApi.Like(p).append(\'draugiemLike-' . $post->ID . '\');</script></div>' . "\n" . '<!-- //WordPress Draugiem -->' . $content;
                    } elseif ($smcwpd_ieteikt_look == '3') {
                        return '<!-- WordPress Draugiem ' . WPDRAUGIEMV . ' by Rolands Umbrovskis | http://mediabox.lv/wordpress-draugiem/ -->' . "\n" . '<div class="smc_draugiem_ieteikt"><div id="draugiemLike-' . $post->ID . '"></div><script type="text/javascript">var p = {layout:"icon",link:"' . $posturlr . '", title:"' . $posttitlee . '", titlePrefix:"' . $awesomebloge . '"}; new DApi.Like(p).append(\'draugiemLike-' . $post->ID . '\');</script></div>' . "\n" . '<!-- //WordPress Draugiem -->' . $content;
                    } else {
                        return '<!-- WordPress Draugiem ' . WPDRAUGIEMV . ' by Rolands Umbrovskis | http://mediabox.lv/wordpress-draugiem/ -->' . "\n" . '<div class="smc_draugiem_ieteikt"><iframe height="20" width="84" frameborder="0" src="http://www.draugiem.lv/say/ext/like.php?title=' . $posttitle . '&amp;url=' . $posturl . '&amp;titlePrefix=' . $awesomeblog . '"></iframe></div>' . "\n" . '<!-- //WordPress Draugiem -->' . "\n" . $content;
                    }
                } elseif ($smcwpd_ieteikt_location === '2') {
                    if ($smcwpd_ieteikt_look == '2') {
                        return $content . "\n" . '<!-- WordPress Draugiem ' . WPDRAUGIEMV . ' by Rolands Umbrovskis | http://mediabox.lv/wordpress-draugiem/ -->' . "\n" . '<div class="smc_draugiem_ieteikt"><div id="draugiemLike-' . $post->ID . '"></div><script type="text/javascript">var p = {layout:"bubble",link:"' . $posturlr . '", title:"' . $posttitlee . '", titlePrefix:"' . esc_attr($awesomebloge) . '"}; new DApi.Like(p).append(\'draugiemLike-' . $post->ID . '\');</script></div>' . "\n" . '<!-- //WordPress Draugiem -->';
                    } elseif ($smcwpd_ieteikt_look == '3') {
                        return '<!-- WordPress Draugiem ' . WPDRAUGIEMV . ' by Rolands Umbrovskis | http://mediabox.lv/wordpress-draugiem/ -->' . "\n" . '<div class="smc_draugiem_ieteikt"><div id="draugiemLike-' . $post->ID . '"></div><script type="text/javascript">var p = {layout:"icon",link:"' . $posturlr . '", title:"' . $posttitlee . '", titlePrefix:"' . $awesomebloge . '"}; new DApi.Like(p).append(\'draugiemLike-' . $post->ID . '\');</script></div>' . "\n" . '<!-- //WordPress Draugiem -->' . $content;
                    } else {
                        return $content . "\n" . '<!-- WordPress Draugiem ' . WPDRAUGIEMV . ' by Rolands Umbrovskis | http://mediabox.lv/wordpress-draugiem/ -->' . "\n" . '<div class="smc_draugiem_ieteikt"><iframe height="20" width="84" frameborder="0" src="http://www.draugiem.lv/say/ext/like.php?title=' . $posttitle . '&amp;url=' . $posturl . '&amp;titlePrefix=' . $awesomeblog . '"></iframe></div>' . "\n" . '<!-- //WordPress Draugiem -->';
                    }
                } elseif ($smcwpd_ieteikt_location === '3') {
                    if ($smcwpd_ieteikt_look == '2') {
                        return '<div class="smc_draugiem_ieteikt"><div id="draugiemLike-' . $post->ID . '-1"></div><script type="text/javascript">var p = {layout:"bubble",link:"' . $posturlr . '", title:"' . $posttitlee . '", titlePrefix:"' . $awesomebloge . '"}; new DApi.Like(p).append(\'draugiemLike-' . $post->ID . '-1\');</script></div>' . $content . "\n" . '<!-- WordPress Draugiem ' . WPDRAUGIEMV . ' by Rolands Umbrovskis | http://mediabox.lv/wordpress-draugiem/ --><div class="smc_draugiem_ieteikt"><div id="draugiemLike-' . $post->ID . '-2"></div><script type="text/javascript">var p = {layout:"bubble",link:"' . $posturlr . '", title:"' . $posttitlee . '", titlePrefix:"' . $awesomebloge . '"}; new DApi.Like(p).append(\'draugiemLike-' . $post->ID . '-2\');</script></div>' . "\n" . '<!-- //WordPress Draugiem -->';
                    } elseif ($smcwpd_ieteikt_look == '3') {
                        return '<!-- WordPress Draugiem ' . WPDRAUGIEMV . ' by Rolands Umbrovskis | http://mediabox.lv/wordpress-draugiem/ -->' . "\n" . '<div class="smc_draugiem_ieteikt"><div id="draugiemLike-' . $post->ID . '"></div><script type="text/javascript">var p = {layout:"icon",link:"' . $posturlr . '", title:"' . $posttitlee . '", titlePrefix:"' . $awesomebloge . '"}; new DApi.Like(p).append(\'draugiemLike-' . $post->ID . '\');</script></div>' . "\n" . '<!-- //WordPress Draugiem -->' . $content;
                    } else {
                        return '<div class="smc_draugiem_ieteikt"><iframe height="20" width="84" frameborder="0" src="http://www.draugiem.lv/say/ext/like.php?title=' . $posttitle . '&amp;url=' . $posturl . '&amp;titlePrefix=' . $awesomeblog . '"></iframe></div>' . $content . "\n" . '<!-- WordPress Draugiem ' . WPDRAUGIEMV . ' by Rolands Umbrovskis | http://mediabox.lv/wordpress-draugiem/ --><div class="smc_draugiem_ieteikt"><iframe height="20" width="84" frameborder="0" src="http://www.draugiem.lv/say/ext/like.php?title=' . $posttitle . '&amp;url=' . $posturl . '&amp;titlePrefix=' . $awesomeblog . '"></iframe></div>' . "\n" . '<!-- //WordPress Draugiem -->';
                    }
                } else {
                    return $content;
                }

            else:
                return $content;
            endif;
        else:
            return $content;
        endif;
    }

    /*
     * Draugiem ieteikt pogas īsais kods 
     * @since 1.3.0
     */

    function smcwp_ieteikt_shortcode($atts)
    {

        extract(shortcode_atts(array(
            'postid' => null,
                        ), $atts)
        );

        if ($postid == null) {
            global $post;
            $postdata = get_post((int) $post->ID);
        } else {
            $postdata = get_post((int) $postid);
        }

        $posturl = apply_filters('smcwp_ieteikt_posturl', urlencode(get_permalink($postdata->ID)));
        $posttitle = apply_filters('smcwp_ieteikt_posttitle', urlencode($postdata->post_title));
        $awesomeblog = apply_filters('smcwp_ieteikt_sitename', urlencode(get_bloginfo('name')));
        $draugiemlikeurl = apply_filters('smcwp_ieteikt_draugiemlikeurl', 'http://www.draugiem.lv/say/ext/like.php');

        return '<!-- WordPress Draugiem ' . WPDRAUGIEMV . ' by Rolands Umbrovskis | http://mediabox.lv/wordpress-draugiem/ -->'
                . "\n" . '<iframe height="20" width="84" frameborder="0" src="'
                . $draugiemlikeurl . '?title=' . $posttitle . '&amp;url='
                . $posturl . '&amp;titlePrefix=' . $awesomeblog . '"></iframe>'
                . "\n" . '<!-- //WordPress Draugiem -->';
    }

    function smcwp_ieteikt_shortcode_list($atts)
    {
        extract(shortcode_atts(array(
            'domain' => get_home_url(),
            'count' => 5,
            'id' => 'smc_wpd_recommend_list',
                        ), $atts));

        global $post;

        return '<!-- WordPress Draugiem ' . WPDRAUGIEMV . ' by Rolands Umbrovskis | http://mediabox.lv/wordpress-draugiem/ -->' . "\n" . '<iframe src="http://www.draugiem.lv/say/ext/recommend.php?url=' . $domain . '&count=' . $count . '" frameborder="0" class="smc_draugiem_recommend_list" id="' . $id . '"></iframe>' . "\n" . '<!-- //WordPress Draugiem -->';
    }

    function wpdr_update_olddata()
    {
        global $smc_wp_draugiem;
        if (is_numeric(get_transient("wpdr_rchck_counts"))) {
            /* Ola kala */
        } else {
            $smc_wp_draugiem->wpdr_update_data();
        }
    }

    function wpdr_update_data()
    {

        $args = array(
            'posts_per_page' => 500,
            'orderby' => 'date',
            'order' => 'DESC',
            'ignore_sticky_posts' => 1,
            'post_type' => 'any' /* any public */
        );

        $filter_functions_and_cache_times = array(
            'old2d' => (60 * 60),
            'old2_7d' => (60 * 60 * 6),
            'old7_30d' => (60 * 60 * 12),
            'old30_180d' => (60 * 60 * 48),
            'old180dm' => (60 * 60 * 24 * 7)
        );
        $wpdr_trans_rnd = mt_rand(5, 10);

        set_transient("wpdr_rchck_counts", 99, 60 * $wpdr_trans_rnd);

        $api_hitr = 0;

        foreach ($filter_functions_and_cache_times as $date_range_filter_function => $cache_time) {

            // Set the date range_filter
            add_filter('posts_where', $date_range_filter_function);

            $posts_in_range = new WP_Query($args);

            while ($posts_in_range->have_posts()) : $posts_in_range->the_post();
                $wpdrtrans_base = "wpdr_trans_" . get_the_ID() . "_";
                if (is_numeric($dr_ieteikumi = get_transient($wpdrtrans_base . "_dr_saids"))) {
                    $post_ieteikti = $dr_ieteikumi;
                } else {
                    $api_hitr++;
                    $draugiem_api_say_results = wp_remote_get("http://www.draugiem.lv/say/ext/like_count.php?url=" . get_permalink());
                    /*
                      If there are no likes/shares
                      @since 1.5.6
                     */
                    if (!is_wp_error($draugiem_api_say_results)) {
                        $post_ieteiktic = json_decode($draugiem_api_say_results["body"]);
                        $post_ieteikti = $post_ieteiktic->count;
                        if (is_numeric($post_ieteikti)) {
                            $this_cache_time = $cache_time + rand(60 * 1, 60 * 25);
                            set_transient($wpdrtrans_base . "_dr_saids", $post_ieteikti, $this_cache_time);
                            update_post_meta(get_the_ID(), "_wpdr_dr_saids", $post_ieteikti);
                        } else {
                            $post_ieteikti = intval(get_post_meta(get_the_ID(), "_wpdr_dr_saids", true));
                            set_transient($wpdrtrans_base . "_dr_saids", $post_ieteikti, 60 * 60 * 6);
                        }

                        $post_totals = 0;
                        $post_totals += intval($post_ieteikti);
                        update_post_meta(get_the_ID(), "_wpdr_total_shares", $post_totals);
                    }
                }

                if ($api_hitr > 14) {
                    break;
                };
            endwhile;

            wp_reset_postdata();

            // Remove the date range filter.
            remove_filter('posts_where', $date_range_filter_function);
            if ($api_hitr > 14) {
                break;
            };
        }
    }

    function wpdr_head_generator()
    {
        echo "\n<!-- WordPress Draugiem " . WPDRAUGIEMV . " by Rolands Umbrovskis | http://mediabox.lv/wordpress-draugiem/ -->\n" . '<meta name="generator" content="WordPress Draugiem by Rolands Umbrovskis" />' . "\n<!-- WordPress Draugiem  " . WPDRAUGIEMV . "  by Rolands Umbrovskis -->\n";
    }

}

/* --------------------------- end 1.5.0 --------------------------- */

include_once(WPDRAUGIEM . '/admin/autoload_admin.php');
