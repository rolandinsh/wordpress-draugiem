<?php

/**
 * Plugin Name: WordPress Draugiem
 * Plugin URI: https://mediabox.lv/wordpress-draugiem/?utm_source=wordpress&utm_medium=wpplugin&utm_campaign=WordPressDraugiem&utm_content=v-2-1-4-wp-draugiem_load_widgets
 * Description: WordPress plugin for Latvian Social Network Draugiem.lv
 * Version: 2.1.3
 * Requires at least: 2.7
 * Tested up to: 4.5
 * Author: Rolands Umbrovskis
 * Author URI: https://umbrovskis.com
 * License: simplemediacode
 * License URI: http://simplemediacode.com/license/
 */
define('WPDRAUGIEMV', '2.1.3'); // location general @since 1.0.0
define('WPDRAUGIEM', dirname(__FILE__)); // location general @since 1.0.0
define('WPDRAUGIEMF', 'wordpress-draugiem'); // location folder @since 1.0.0
define('WPDRAUGIEMURL', plugin_dir_url(__FILE__));
define('WPDRAUGIEMI', WPDRAUGIEMURL . '/img'); // Image location @since 1.0.0
define('WPDWPORG', 'http://wordpress.org/extend/plugins/' . WPDRAUGIEMF); // Image location @since 1.0.0

if (!defined('DRAUGIEMJSAPI')) {

    define('DRAUGIEMJSAPI', 'https//www.draugiem.lv/api/api.js');
} // unified constants across plugins @since 1.5.4

new SMC_WordPress_Draugiem();
$smc_wp_draugiem = new SMC_WordPress_Draugiem();
/* SMC WordPress Draugiem Class
 * @since 2.0.0
 */

class SMC_WordPress_Draugiem
{

    public function __construct()
    {
        add_action('init', array('SMC_WordPress_Draugiem', 'init'), 10);
        add_filter('plugin_row_meta', array('SMC_WordPress_Draugiem', 'smcwpd_set_plugin_meta'), 10, 2);
        add_filter('the_content', array('SMC_WordPress_Draugiem', 'smc_draugiem_say_content'));
        add_shortcode('ieteiktdraugiem', array('SMC_WordPress_Draugiem', 'smcwp_ieteikt_shortcode'));
        add_shortcode('ieteikumusaraksts', array('SMC_WordPress_Draugiem', 'smcwp_ieteikt_shortcode_list'));
        add_action('wp_footer', array('SMC_WordPress_Draugiem', 'wpdr_update_olddata'));
        add_filter('wp_head', array('SMC_WordPress_Draugiem', 'wpdr_head_generator'), 2); // location general @since 1.5.1
    }

    // Initialize
    public static function init()
    {
        load_plugin_textdomain('wpdraugiem', false, dirname(plugin_basename(__FILE__)) . '/lang/');
    }

    public function smcwpd_set_plugin_meta($links, $file)
    {
        $plugin = plugin_basename(__FILE__);
        if ($file == $plugin) {
            return array_merge($links, array(
                '<a href="https://mediabox.lv/wordpress-draugiem/">www</a>',
                '<a href="https://umbrovskis.lv/">' . __('Labs darbs?') . '</a>'
            ));
        }
        return $links;
    }

    public function smcStrings($position = 'top')
    {
        switch ($position) {
            case 'top':
                $positioncontent = '<!-- WordPress Draugiem ' . WPDRAUGIEMV . ' by Rolands Umbrovskis | https://mediabox.lv/wordpress-draugiem/ -->';
                break;

            default:
                $positioncontent = '<!-- //WordPress Draugiem -->';
                break;
        }
        return $positioncontent;
    }

    public static function smc_draugiem_say_content($content = '')
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
        $wpdrx = new SMC_WordPress_Draugiem();
        $topcomments = $wpdrx->smcStrings('top');
        $bottomcomments = $wpdrx->smcStrings('bottom');
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
                        return $topcomments . "\n" . '<div class="smc_draugiem_ieteikt"><div id="draugiemLike-' . $post->ID . '"></div><script type="text/javascript">var p = {layout:"bubble",link:"' . $posturlr . '", title:"' . $posttitlee . '", titlePrefix:"' . $awesomebloge . '"}; new DApi.Like(p).append(\'draugiemLike-' . $post->ID . '\');</script></div>' . "\n" . $bottomcomments . $content;
                    } elseif ($smcwpd_ieteikt_look == '3') {
                        return $topcomments . "\n" . '<div class="smc_draugiem_ieteikt"><div id="draugiemLike-' . $post->ID . '"></div><script type="text/javascript">var p = {layout:"icon",link:"' . $posturlr . '", title:"' . $posttitlee . '", titlePrefix:"' . $awesomebloge . '"}; new DApi.Like(p).append(\'draugiemLike-' . $post->ID . '\');</script></div>' . "\n" . $bottomcomments . $content;
                    } else {
                        return $topcomments . "\n" . '<div class="smc_draugiem_ieteikt"><iframe height="20" width="84" frameborder="0" src="https://www.draugiem.lv/say/ext/like.php?title=' . $posttitle . '&amp;url=' . $posturl . '&amp;titlePrefix=' . $awesomeblog . '"></iframe></div>' . "\n" . $bottomcomments . "\n" . $content;
                    }
                } elseif ($smcwpd_ieteikt_location === '2') {
                    if ($smcwpd_ieteikt_look == '2') {
                        return $content . "\n" . $topcomments . "\n" . '<div class="smc_draugiem_ieteikt"><div id="draugiemLike-' . $post->ID . '"></div><script type="text/javascript">var p = {layout:"bubble",link:"' . $posturlr . '", title:"' . $posttitlee . '", titlePrefix:"' . esc_attr($awesomebloge) . '"}; new DApi.Like(p).append(\'draugiemLike-' . $post->ID . '\');</script></div>' . "\n" . $bottomcomments;
                    } elseif ($smcwpd_ieteikt_look == '3') {
                        return $topcomments . "\n" . '<div class="smc_draugiem_ieteikt"><div id="draugiemLike-' . $post->ID . '"></div><script type="text/javascript">var p = {layout:"icon",link:"' . $posturlr . '", title:"' . $posttitlee . '", titlePrefix:"' . $awesomebloge . '"}; new DApi.Like(p).append(\'draugiemLike-' . $post->ID . '\');</script></div>' . "\n" . $bottomcomments . $content;
                    } else {
                        return $content . "\n" . $topcomments . "\n" . '<div class="smc_draugiem_ieteikt"><iframe height="20" width="84" frameborder="0" src="https://www.draugiem.lv/say/ext/like.php?title=' . $posttitle . '&amp;url=' . $posturl . '&amp;titlePrefix=' . $awesomeblog . '"></iframe></div>' . "\n" . $bottomcomments;
                    }
                } elseif ($smcwpd_ieteikt_location === '3') {
                    if ($smcwpd_ieteikt_look == '2') {
                        return '<div class="smc_draugiem_ieteikt"><div id="draugiemLike-' . $post->ID . '-1"></div><script type="text/javascript">var p = {layout:"bubble",link:"' . $posturlr . '", title:"' . $posttitlee . '", titlePrefix:"' . $awesomebloge . '"}; new DApi.Like(p).append(\'draugiemLike-' . $post->ID . '-1\');</script></div>' . $content . "\n" . $topcomments . '<div class="smc_draugiem_ieteikt"><div id="draugiemLike-' . $post->ID . '-2"></div><script type="text/javascript">var p = {layout:"bubble",link:"' . $posturlr . '", title:"' . $posttitlee . '", titlePrefix:"' . $awesomebloge . '"}; new DApi.Like(p).append(\'draugiemLike-' . $post->ID . '-2\');</script></div>' . "\n" . $bottomcomments;
                    } elseif ($smcwpd_ieteikt_look == '3') {
                        return $topcomments . "\n" . '<div class="smc_draugiem_ieteikt"><div id="draugiemLike-' . $post->ID . '"></div><script type="text/javascript">var p = {layout:"icon",link:"' . $posturlr . '", title:"' . $posttitlee . '", titlePrefix:"' . $awesomebloge . '"}; new DApi.Like(p).append(\'draugiemLike-' . $post->ID . '\');</script></div>' . "\n" . $bottomcomments . $content;
                    } else {
                        return '<div class="smc_draugiem_ieteikt"><iframe height="20" width="84" frameborder="0" src="https://www.draugiem.lv/say/ext/like.php?title=' . $posttitle . '&amp;url=' . $posturl . '&amp;titlePrefix=' . $awesomeblog . '"></iframe></div>' . $content . "\n" . $topcomments . '<div class="smc_draugiem_ieteikt"><iframe height="20" width="84" frameborder="0" src="https://www.draugiem.lv/say/ext/like.php?title=' . $posttitle . '&amp;url=' . $posturl . '&amp;titlePrefix=' . $awesomeblog . '"></iframe></div>' . "\n" . $bottomcomments;
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
        $draugiemlikeurl = apply_filters('smcwp_ieteikt_draugiemlikeurl', 'https://www.draugiem.lv/say/ext/like.php');
        $wpdrx = new SMC_WordPress_Draugiem();
        $topcomments = $wpdrx->smcStrings('top');
        $bottomcomments = $wpdrx->smcStrings('bottom');
        return $topcomments
                . "\n" . '<iframe height="20" width="84" frameborder="0" src="'
                . $draugiemlikeurl . '?title=' . $posttitle . '&amp;url='
                . $posturl . '&amp;titlePrefix=' . $awesomeblog . '"></iframe>'
                . "\n" . $bottomcomments;
    }

    function smcwp_ieteikt_shortcode_list($atts)
    {
        extract(shortcode_atts(array(
            'domain' => get_home_url(),
            'count' => 5,
            'id' => 'smc_wpd_recommend_list',
                        ), $atts));

        global $post;
        $wpdrx = new SMC_WordPress_Draugiem();
        $topcomments = $wpdrx->smcStrings('top');
        $bottomcomments = $wpdrx->smcStrings('bottom');
        return $topcomments . "\n" . '<iframe src="https://www.draugiem.lv/say/ext/recommend.php?url=' . $domain . '&count=' . $count . '" frameborder="0" class="smc_draugiem_recommend_list" id="' . $id . '"></iframe>' . "\n" . $bottomcomments;
    }

    public static function wpdr_update_olddata()
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
                    $draugiem_api_say_results = wp_remote_get("https://www.draugiem.lv/say/ext/like_count.php?url=" . get_permalink());
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

    public static function wpdr_head_generator()
    {
        $wpdrx = new SMC_WordPress_Draugiem();
        $topcomments = $wpdrx->smcStrings('top');
        echo "\n" . $topcomments . "\n" . '<meta name="generator" content="https://mediabox.lv/?utm_campaign=' . WPDRAUGIEMF . '" />' . "\n";
    }

}

include_once(WPDRAUGIEM . '/admin/autoload_admin.php');


