<?php

namespace Rolandinsh\Draugiem;

//new Wpd;

/* SMC WordPress Draugiem Class
 * @since 2.0.0
 */
class Wpd
{

    const WPDRAUGIEMV = '3.0.0-alpha1';
    const WPDRAUGIEMF = 'wordpress-draugiem';
    const DRAUGIEMJSAPI = '//www.draugiem.lv/api/api.js';
    const WPDWPORGP = 'http://wordpress.org/extend/plugins/';
    const MEDIABOX_PLUGIN_PAGE = 'https://mediabox.lv/wordpress-draugiem/';

    public function __construct()
    {
        add_action('init', array(&$this, 'init'), 10);
        add_filter('plugin_row_meta', array(&$this, 'smcwpd_set_plugin_meta'), 10, 2);
        add_filter('the_content', array(&$this, 'draugiemSayContent'));
        add_shortcode('ieteiktdraugiem', array(&$this, 'smcwp_ieteikt_shortcode'));
        add_shortcode('ieteikumusaraksts', array(&$this, 'smcwp_ieteikt_shortcode_list'));
        add_action('wp_footer', array(&$this, 'wpdr_update_olddata'));
        add_filter('wp_head', array(&$this, 'headGenerator'), 2); // location general @since 1.5.1
    }

    // Initialize
    public function init()
    {
        load_plugin_textdomain('wpdraugiem', false, dirname(plugin_basename(__FILE__)) . '/lang/');
    }

    public function draugiemjsapi()
    {
        // $ishttpsurl = is_ssl() ? 'https:' : 'http:';  // fix https @since 1.5.4.1
        // return $ishttpsurl . $this::DRAUGIEMJSAPI;
        return $this::DRAUGIEMJSAPI;
    }

    public function smcmarker()
    {
        return 'WordPress Draugiem ' . $this::WPDRAUGIEMV . ' by Rolands Umbrovskis | ' . $this::MEDIABOX_PLUGIN_PAGE;
    }

    public function smcwpd_set_plugin_meta($links, $file)
    {
        $plugin = plugin_basename(__FILE__);
        if ($file == $plugin) {
            return array_merge($links, array(
                '<a href="' . $this::MEDIABOX_PLUGIN_PAGE . '">www</a>',
                '<a href="https://umbrovskis.lv/labi-darbi/">' . __('Labs darbs?') . '</a>'
            ));
        }
        return $links;
    }

    function draugiemSayContent($content)
    {
        global $post;
        $showsmcwpd = get_option('smc_wpd_ieteikt_all');
        $smcwpd_showfield = get_post_meta($post->ID, 'smcwpd_showfield', true);
        $smcwpd_ieteikt_look = get_option('smc_wpd_ieteikt_look');
        /*
         * @todo optimize draugiemSayContent()!
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
                $smcmark = $this->smcmarker();
                if ($smcwpd_ieteikt_location === '1') {
                    if ($smcwpd_ieteikt_look == '2') {
                        return '<!-- ' . $smcmark . ' -->'
                                . "\n" . '<div class="smc_draugiem_ieteikt"><div id="draugiemLike-'
                                . $post->ID . '"></div><script type="text/javascript">var p = {layout:"bubble",link:"'
                                . $posturlr . '", title:"' . $posttitlee . '", titlePrefix:"'
                                . $awesomebloge . '"}; new DApi.Like(p).append(\'draugiemLike-'
                                . $post->ID . '\');</script></div>' . "\n" . '<!-- // ' . $smcmark . ' end -->'
                                . $content;
                    } elseif ($smcwpd_ieteikt_look == '3') {
                        return '<!-- ' . $smcmark . ' -->' . "\n" . '<div class="smc_draugiem_ieteikt"><div id="draugiemLike-'
                                . $post->ID . '"></div><script type="text/javascript">var p = {layout:"icon",link:"'
                                . $posturlr . '", title:"' . $posttitlee . '", titlePrefix:"'
                                . $awesomebloge . '"}; new DApi.Like(p).append(\'draugiemLike-'
                                . $post->ID . '\');</script></div>' . "\n" . '<!-- // ' . $smcmark . ' end -->' . $content;
                    } else {
                        return '<!-- ' . $smcmark . ' -->' . "\n"
                                . '<div class="smc_draugiem_ieteikt"><iframe height="20" width="84" frameborder="0" src="http://www.draugiem.lv/say/ext/like.php?title='
                                . $posttitle . '&amp;url=' . $posturl . '&amp;titlePrefix=' . $awesomeblog . '"></iframe></div>' . "\n"
                                . '<!-- // ' . $smcmark . ' end -->' . "\n" . $content;
                    }
                } elseif ($smcwpd_ieteikt_location === '2') {
                    if ($smcwpd_ieteikt_look == '2') {
                        return $content . "\n" . '<!-- ' . $smcmark . ' -->'
                                . "\n" . '<div class="smc_draugiem_ieteikt"><div id="draugiemLike-' . $post->ID . '"></div><script type="text/javascript">var p = {layout:"bubble",link:"' . $posturlr . '", title:"' . $posttitlee . '", titlePrefix:"' . esc_attr($awesomebloge) . '"}; new DApi.Like(p).append(\'draugiemLike-' . $post->ID . '\');</script></div>' . "\n" . '<!-- // ' . $smcmark . ' end -->';
                    } elseif ($smcwpd_ieteikt_look == '3') {
                        return '<!-- ' . $smcmark . ' -->' . "\n" . '<div class="smc_draugiem_ieteikt"><div id="draugiemLike-' . $post->ID . '"></div><script type="text/javascript">var p = {layout:"icon",link:"' . $posturlr . '", title:"' . $posttitlee . '", titlePrefix:"' . $awesomebloge . '"}; new DApi.Like(p).append(\'draugiemLike-' . $post->ID . '\');</script></div>' . "\n" . '<!-- // ' . $smcmark . ' end -->' . $content;
                    } else {
                        return $content . "\n" . '<!-- ' . $smcmark . ' -->' . "\n" . '<div class="smc_draugiem_ieteikt"><iframe height="20" width="84" frameborder="0" src="http://www.draugiem.lv/say/ext/like.php?title=' . $posttitle . '&amp;url=' . $posturl . '&amp;titlePrefix=' . $awesomeblog . '"></iframe></div>' . "\n" . '<!-- // ' . $smcmark . ' end -->';
                    }
                } elseif ($smcwpd_ieteikt_location === '3') {
                    if ($smcwpd_ieteikt_look == '2') {
                        return '<div class="smc_draugiem_ieteikt"><div id="draugiemLike-' . $post->ID . '-1"></div><script type="text/javascript">var p = {layout:"bubble",link:"' . $posturlr . '", title:"' . $posttitlee . '", titlePrefix:"' . $awesomebloge . '"}; new DApi.Like(p).append(\'draugiemLike-' . $post->ID . '-1\');</script></div>' . $content . "\n"
                                . '<!-- ' . $smcmark . ' --><div class="smc_draugiem_ieteikt"><div id="draugiemLike-' . $post->ID . '-2"></div><script type="text/javascript">var p = {layout:"bubble",link:"' . $posturlr . '", title:"' . $posttitlee . '", titlePrefix:"' . $awesomebloge . '"}; new DApi.Like(p).append(\'draugiemLike-' . $post->ID . '-2\');</script></div>' . "\n" . '<!-- // ' . $smcmark . ' end -->';
                    } elseif ($smcwpd_ieteikt_look == '3') {
                        return '<!-- ' . $smcmark . ' -->' . "\n" . '<div class="smc_draugiem_ieteikt"><div id="draugiemLike-' . $post->ID . '"></div><script type="text/javascript">var p = {layout:"icon",link:"' . $posturlr . '", title:"' . $posttitlee . '", titlePrefix:"' . $awesomebloge . '"}; new DApi.Like(p).append(\'draugiemLike-' . $post->ID . '\');</script></div>' . "\n" . '<!-- // ' . $smcmark . ' end -->' . $content;
                    } else {
                        return '<div class="smc_draugiem_ieteikt"><iframe height="20" width="84" frameborder="0" src="http://www.draugiem.lv/say/ext/like.php?title='
                                . $posttitle . '&amp;url=' . $posturl . '&amp;titlePrefix=' . $awesomeblog . '"></iframe></div>' . $content . "\n"
                                . '<!-- ' . $smcmark . ' --><div class="smc_draugiem_ieteikt"><iframe height="20" width="84" frameborder="0" src="http://www.draugiem.lv/say/ext/like.php?title=' . $posttitle . '&amp;url=' . $posturl . '&amp;titlePrefix=' . $awesomeblog . '"></iframe></div>' . "\n" . '<!-- // ' . $smcmark . ' end -->';
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

        return '<!-- ' . $this->smcmarker() . ' -->'
                . "\n" . '<iframe height="20" width="84" frameborder="0" src="'
                . $draugiemlikeurl . '?title=' . $posttitle . '&amp;url='
                . $posturl . '&amp;titlePrefix=' . $awesomeblog . '"></iframe>'
                . "\n" . '<!-- //' . $this->smcmarker() . ' end -->';
    }

    function smcwp_ieteikt_shortcode_list($atts)
    {
        extract(shortcode_atts(array(
            'domain' => get_home_url(),
            'count' => 5,
            'id' => 'smc_wpd_recommend_list',
                        ), $atts));

        global $post;

        return '<!-- ' . $this->smcmarker() . ' -->' . "\n"
                . '<iframe src="http://www.draugiem.lv/say/ext/recommend.php?url='
                . $domain . '&count=' . $count . '" frameborder="0" class="smc_draugiem_recommend_list" id="'
                . $id . '"></iframe>' . "\n"
                . '<!-- //' . $this->smcmarker() . ' end -->';
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
            'posts_per_page' => apply_filters('wpdr_update_data_posts_per_page',  500 ),
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

    function headGenerator()
    {
        echo "\n<!-- " . $this->smcmarker() . " -->\n"
        . '<meta name="generator" content="WordPress Draugiem by Rolands Umbrovskis" />'
        . "\n<!-- " . $this->smcmarker() . " -->\n";
    }

}
