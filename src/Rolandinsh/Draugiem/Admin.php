<?php

namespace Rolandinsh\Draugiem;

class WpdAdmin
{

    public function __construct()
    {
        parent::__construct();
        add_action('init', array(&$this, 'coreinit'));
    }

}

function smc_wpd_admin_menu()
{
    //create new top-level menu
    add_menu_page(__('WordPress Draugiem', 'wpdraugiem'), __('WP Draugiem', 'wpdraugiem'), 'activate_plugins', 'smcwpd', 'smcwpd_settings');
    add_submenu_page('smcwpd', __('Help'), __('Help'), 'edit_posts', 'smcwpdhelp', 'smcwpd_help');

    register_setting('smc-wpd-settings', 'smc_wpd_ieteikt_all');
    register_setting('smc-wpd-settings', 'smc_wpd_ieteikt_where');
    register_setting('smc-wpd-settings', 'smc_wpd_ieteikt_look');
}

function smcwpd_settings()
{
    settings_fields('smc-wpd-settings');
    $smc_wpd_ieteikt_all = get_option('smc_wpd_ieteikt_all');
    $smc_wpd_ieteikt_where = get_option('smc_wpd_ieteikt_where');
    $smc_wpd_ieteikt_look = get_option('smc_wpd_ieteikt_look');
    ?><div class="wrap">
      <h2><?php _e('Settings'); ?></h2>
      <form method="post" action="options.php">
        <table class="form-table table">
          <tr>
            <th valign="top"><?php _e('Show on all pages and posts', 'wpdraugiem'); ?></th>
            <td valign="top"><input type="checkbox" id="smc_wpd_ieteikt_all" name="smc_wpd_ieteikt_all" <?php checked($smc_wpd_ieteikt_all, 'on') ?> /></td>
            <td valign="top"><?php _e('Appearance', 'wpdraugiem'); ?></td>
          </tr>
          <tr>
            <th valign="top"><?php _e('Start / End', 'wpdraugiem'); ?></th>
            <td valign="top">
              <select name="smc_wpd_ieteikt_where">
                <option value="1" <?php selected($smc_wpd_ieteikt_where, 1); ?>><?php _e('Start', 'wpdraugiem'); ?></option>
                <option value="2" <?php selected($smc_wpd_ieteikt_where, 2); ?>><?php _e('End', 'wpdraugiem'); ?></option>
                <option value="3" <?php selected($smc_wpd_ieteikt_where, 3); ?>><?php _e('Start and End', 'wpdraugiem'); ?></option>
              </select>
            </td>
            <td valign="top">
              <select name="smc_wpd_ieteikt_look">
                <option value="1" <?php selected($smc_wpd_ieteikt_look, 1); ?>><?php _e('Standart', 'wpdraugiem'); ?></option>
                <option value="2" <?php selected($smc_wpd_ieteikt_look, 2); ?>><?php _e('Bubble', 'wpdraugiem'); ?></option>
                <option value="3" <?php selected($smc_wpd_ieteikt_look, 3); ?>><?php _e('Icon', 'wpdraugiem'); ?></option>
              </select>
            </td>
          </tr>
          <tr>
            <td colspan="3">
              <p>MediaBox.lv - WordPress mājas lapu izstrāde</p>

              <div class="g-plusone" data-size="tall" data-annotation="inline" data-href="http://mediabox.lv/"></div>

              <iframe height="20" width="84" frameborder="0" src="http://www.draugiem.lv/say/ext/like.php?title=<?php echo urlencode('MediaBox.lv - WordPress mājas lapu izstrāde | Umbrovskis.com'); ?>&amp;url=<?php echo urlencode('http://mediabox.lv/') ?>&amp;titlePrefix=<?php echo urlencode(get_bloginfo('name')); ?>"></iframe>
            </td>
          </tr>
        </table>
        <p class="submit">
          <input type="submit" class="button-primary" value="<?php _e('Save Changes') ?>" />
        </p>
      </form>

      <hr />


      <style type="text/css">
        #mc_embed_signup form {display:block; position:relative; text-align:left; padding:10px 0 10px 3%}
        #mc_embed_signup h2 {font-weight:bold; padding:0; margin:15px 0; font-size:1.4em;}
        #mc_embed_signup input {border:1px solid #999; -webkit-appearance:none;}
        #mc_embed_signup input[type=checkbox]{-webkit-appearance:checkbox;}
        #mc_embed_signup input[type=radio]{-webkit-appearance:radio;}
        #mc_embed_signup input:focus {border-color:#333;}
        #mc_embed_signup .button {clear:both; background-color: #aaa; border: 0 none; border-radius:4px; color: #FFFFFF; cursor: pointer; display: inline-block; font-size:15px; font-weight: bold; height: 32px; line-height: 32px; margin: 0 5px 10px 0; padding: 0 22px; text-align: center; text-decoration: none; vertical-align: top; white-space: nowrap; width: auto;}
        #mc_embed_signup .button:hover {background-color:#777;}
        #mc_embed_signup .small-meta {font-size: 11px;}
        #mc_embed_signup .nowrap {white-space:nowrap;}

        #mc_embed_signup .mc-field-group {clear:left; position:relative; width:96%; padding-bottom:3%; min-height:50px;}
        #mc_embed_signup .size1of2 {clear:none; float:left; display:inline-block; width:46%; margin-right:4%;}
        * html #mc_embed_signup .size1of2 {margin-right:2%; /* Fix for IE6 double margins. */}
        #mc_embed_signup .mc-field-group label {display:block; margin-bottom:3px;}
        #mc_embed_signup .mc-field-group input {display:block; width:100%; padding:8px 0; text-indent:2%;}
        #mc_embed_signup .mc-field-group select {display:inline-block; width:99%; padding:5px 0; margin-bottom:2px;}

        #mc_embed_signup .datefield, #mc_embed_signup .phonefield-us{padding:5px 0;}
        #mc_embed_signup .datefield input, #mc_embed_signup .phonefield-us input{display:inline; width:60px; margin:0 2px; letter-spacing:1px; text-align:center; padding:5px 0 2px 0;}
        #mc_embed_signup .phonefield-us .phonearea input, #mc_embed_signup .phonefield-us .phonedetail1 input{width:40px;}
        #mc_embed_signup .datefield .monthfield input, #mc_embed_signup .datefield .dayfield input{width:30px;}
        #mc_embed_signup .datefield label, #mc_embed_signup .phonefield-us label{display:none;}

        #mc_embed_signup .indicates-required {text-align:right; font-size:11px; margin-right:4%;}
        #mc_embed_signup .asterisk {color:#c60; font-size:200%;}
        #mc_embed_signup .mc-field-group .asterisk {position:absolute; top:25px; right:10px;}        
        #mc_embed_signup .clear {clear:both;}

        #mc_embed_signup .mc-field-group.input-group ul {margin:0; padding:5px 0; list-style:none;}
        #mc_embed_signup .mc-field-group.input-group ul li {display:block; padding:3px 0; margin:0;}
        #mc_embed_signup .mc-field-group.input-group label {display:inline;}
        #mc_embed_signup .mc-field-group.input-group input {display:inline; width:auto; border:none;}

        #mc_embed_signup div#mce-responses {float:left; top:-1.4em; padding:0em .5em 0em .5em; overflow:hidden; width:90%;margin: 0 5%; clear: both;}
        #mc_embed_signup div.response {margin:1em 0; padding:1em .5em .5em 0; font-weight:bold; float:left; top:-1.5em; z-index:1; width:80%;}
        #mc_embed_signup #mce-error-response {display:none;}
        #mc_embed_signup #mce-success-response {color:#529214; display:none;}
        #mc_embed_signup label.error {display:block; float:none; width:auto; margin-left:1.05em; text-align:left; padding:.5em 0;}

        #mc-embedded-subscribe {clear:both; width:auto; display:block; margin:1em 0 1em 5%;}
        #mc_embed_signup #num-subscribers {font-size:1.1em;}
        #mc_embed_signup #num-subscribers span {padding:.5em; border:1px solid #ccc; margin-right:.5em; font-weight:bold;}

        #mc_embed_signup{background:#fff; clear:left; font:14px Helvetica,Arial,sans-serif; }</style>
      <div id="mc_embed_signup">
        <form action="http://mediabox.us4.list-manage.com/subscribe/post?u=1abe03127f696c94c3027715d&amp;id=b0234d4827" method="post" id="mc-embedded-subscribe-form" name="mc-embedded-subscribe-form" class="validate" target="_blank" novalidate>

          <table class="form-table table">

            <tr>
              <td valign="top" colspan="2"><h2>Saņem autora jaunumus</h2>
                <div class="indicates-required"><span class="asterisk">*</span> apzīmē obligātos laukumus</div>
                <div class="mc-field-group">
                  <label for="mce-EMAIL">e-pasta adrese  <span class="asterisk">*</span></label>
                  <input type="email" value="" name="EMAIL" class="required email" id="mce-EMAIL">
                </div></td>
            </tr>
            <tr>
              <td valign="top"><div class="mc-field-group input-group"><strong>Interesē </strong>
                  <ul>
                    <li><input type="checkbox" value="1" name="group[13853][1]" id="mce-group[13853]-13853-0"><label for="mce-group[13853]-13853-0">jauni produkti un pakalpojumi</label></li>
                    <li><input type="checkbox" value="2" name="group[13853][2]" id="mce-group[13853]-13853-1"><label for="mce-group[13853]-13853-1">jaunas iespējas</label></li>
                  </ul>
                </div></td>
              <td valign="top">
                <div class="mc-field-group input-group">
                  <strong>e-pasta formāts</strong>
                  <ul>
                    <li><input type="radio" value="html" name="EMAILTYPE" id="mce-EMAILTYPE-0"><label for="mce-EMAILTYPE-0">html</label></li>
                    <li><input type="radio" value="text" name="EMAILTYPE" id="mce-EMAILTYPE-1"><label for="mce-EMAILTYPE-1">teksts</label></li>
                    <li><input type="radio" value="mobile" name="EMAILTYPE" id="mce-EMAILTYPE-2"><label for="mce-EMAILTYPE-2">mobilajam telefonam</label></li>
                  </ul>
                </div></td>
            </tr>
          </table>
          <div id="mce-responses" class="clear">
            <div class="response" id="mce-error-response" style="display:none"></div>
            <div class="response" id="mce-success-response" style="display:none"></div>
          </div>	<div class="clear"><input type="submit" value="Abonēt" name="subscribe" id="mc-embedded-subscribe" class="button-primary"></div>
        </form>
      </div>


      <script type="text/javascript" src="https://apis.google.com/js/plusone.js">{
              lang: 'lv'
          }</script>
    </div><?php
}

// smcwpd_settings()

function smcwpd_help()
{
    ?><div class="wrap">
      <h2><?php _e('Help'); ?></h2>
      <p>Visa palīdzība ir pieejam izmantojot atbalsta forumu vai lasot dokumentāciju.</p>
      <p>Spraudņa lapa: <a href="http://mediabox.lv/wordpress-draugiem/?utm_source=<?php echo urlencode(get_home_url()); ?>&utm_content=SMC-WPD-Help-link-pluginn-page&utm_medium=link&utm_campaign=WordPressDraugiem_<?php echo WPDRAUGIEMV; ?>" title="WordPress Draugiem" target="_blank">MediaBox.lv/wordpress-draugiem/</a></p>
      <h2>Lietošana</h2>
      <p><strong>[ieteikumusaraksts]</strong>: ir 3 <em>neobligāti</em> parametri:</p>
      <ol>
        <li><strong>domain</strong> - kurai lapai vēlaties rādīt ieteikumu sarakstu. Noklusētā vērtība ir tavs blogs (<em><?php echo get_home_url(); ?></em>). Ja vēlies norādīt citu lapu vai domēnu, tad jāieraksta attiecīgā adrese,piem., <code>[ieteikumusaraksts domain="http://rolandinsh.lv"]</code></li>
        <li><strong>count</strong> - cik ierakstus rādīt. Noklusētā vērtība ir 5. Ja vēlies norādīt citu skaitu, tad jāieraksta attiecīgi cits cipars,piem., <code>[ieteikumusaraksts count="5"]</code></li>
        <li><strong>id</strong> - lietot nepieciešams, ja vienā lapā ir vairāk par vienu ieteikumu sarakstu. Noklusētā vērtība ir <code>smc_wpd_recommend_list</code>. Ja vēlies norādīt citu unikālo ID, tad jāieraksta,piem., <code>[ieteikumusaraksts id="man_cits_id"]</code></li>
      </ol>
      <p>Ja ir vēlma mainīt vairākus parametru, tos var apvienot, piem., <code>[ieteikumusaraksts domain="http://rolandinsh.lv" count="5"]</code> vai <code>[ieteikumusaraksts domain="http://rolandinsh.lv" count="5" id="man_cits_id"]</code> vai <code>[ieteikumusaraksts count="5" id="man_cits_id"]</code></p>

      <h2>Izstrādātājiem</h2>
      <p><strong>GIT</strong></p>
      <p>Svaigākā darba kopija: <a href="http://go.mediabox.lv/wpdgitp" target="_blank">https://github.com/rolandinsh/wordpress-draugiem</a><br />
        <code>git://github.com/rolandinsh/wordpress-draugiem.git</code>

    </div><?php
}

/*
 * Shares with Draugiem API
 */

add_filter('manage_posts_columns', 'smc_draugiem_ieteiktcounter_kol');
add_filter('manage_pages_columns', 'smc_draugiem_ieteiktcounter_kol');

function smc_draugiem_ieteiktcounter_kol($columns)
{
    $columns['smc_draugiem_ieteiktcount'] = __('Draugiem.lv/say', 'wpdraugiem'); // __('WPDR counter','wpdraugiem')
    return $columns;
}

add_action('manage_posts_custom_column', 'smc_draugiem_ieteiktcounter_kshow');
add_action('manage_pages_custom_column', 'smc_draugiem_ieteiktcounter_kshow');

function smc_draugiem_ieteiktcounter_kshow($name)
{
    global $post;

    switch ($name) {
        case 'smc_draugiem_ieteiktcount':
            $smc_dr_ieteiktcount = get_post_meta($post->ID, '_wpdr_total_shares', true);
            echo $smc_dr_ieteiktcount;
    }
}

function add_day_filter($where = '', $from_x_days_back, $to_x_days_back)
{
    $days_into_past = $from_x_days_back;
    $where .= " AND post_date >= '" . date('Y-m-d', strtotime('-' . $to_x_days_back . ' days')) . "'" . " AND post_date <= '" . date('Y-m-d', strtotime('-' . $days_into_past . ' days')) . "'";
    return $where;
}

function old2d($where = '')
{
    $where .= " AND post_date > '" . date('Y-m-d', strtotime('-2 days')) . "'";
    return $where;
}

function old2_7d($where = '')
{
    $where .= " AND post_date >= '" . date('Y-m-d', strtotime('-7 days')) . "'" . " AND post_date <= '" . date('Y-m-d', strtotime('-2 days')) . "'";
    return $where;
}

function old7_30d($where = '')
{
    return add_day_filter($where, 8, 30);
}

function old30_180d($where = '')
{
    return add_day_filter($where, 31, 180);
}

function old180dm($where = '')
{
    return add_day_filter($where, 181, 3600); // 10 year default
}

// -----------------------------------


function smc_draugiem_say_head()
{
    global $post;
    $showsmcwpdh = get_option('smc_wpd_ieteikt_all');
    $smcwpd_showfieldh = get_post_meta($post->ID, 'smcwpd_showfield', true);
    /*
     * @todo optimizēt!
     */
    $paradit_smcwpdh = 0;
    if ($showsmcwpdh != 'on' && $smcwpd_showfieldh == '1') {
        $paradit_smcwpdh = 1;
    }
    if ($showsmcwpdh == 'on' && !$smcwpd_showfieldh) {
        $paradit_smcwpdh = 1;
    }
    if ($showsmcwpdh == 'on' && $smcwpd_showfieldh == '1') {
        $paradit_smcwpdh = 1;
    }
    if ($showsmcwpdh == 'on' && $smcwpd_showfieldh == '0') {
        $paradit_smcwpdh = 0;
    }
    if (is_singular() && $paradit_smcwpdh == 1) {
        if (has_post_thumbnail($post->ID)) {
            $smc_draugiem_head_img = wp_get_attachment_image_src(get_post_thumbnail_id($post->ID), 'thumbnail');
            echo '<meta name="dr:say:img" content="' . esc_attr($smc_draugiem_head_img[0]) . '" />';
        }
        echo '<meta name="dr:say:title" content="' . esc_attr($post->post_title) . '" />';
    }
}

add_filter('wp_head', 'smc_draugiem_say_head', 2);
// <iframe src="http://www.draugiem.lv/say/ext/recommend.php?url=...&count=..." frameborder="0"></iframe>

/* Define the custom box */

add_action('add_meta_boxes', 'smc_wpd_add_pmetbox');
add_action('save_post', 'smc_wpd_save_postmetadata');

/* Adds a box to the main column on the Post and Page edit screens */

function smc_wpd_add_pmetbox()
{
    add_meta_box('smcwpd_metabox_section', __('WordPress Draugiem', 'wpdraugiem'), 'smc_wpd_metawrapbox', 'post', 'side');
    add_meta_box('smcwpd_metabox_section', __('WordPress Draugiem', 'wpdraugiem'), 'smc_wpd_metawrapbox', 'page', 'side');
}

/* Prints the box content */

function smc_wpd_metawrapbox($post)
{
    $smcwpd_showfieldv = get_post_meta($post->ID, 'smcwpd_showfield', true);
    wp_nonce_field(plugin_basename(__FILE__), 'wpd_noncex');
    echo '<label for="smcwpd_showfield">' . __('Show on this page', 'wpdraugiem') . '</label> ';
    echo '<input type="checkbox" id="smcwpd_showfield" name="smcwpd_showfield" value="1" ' . checked($smcwpd_showfieldv, 1) . ' />';
}

function smc_wpd_save_postmetadata($post_id)
{
    if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE)
        return;

    if (!wp_verify_nonce($_POST['wpd_noncex'], plugin_basename(__FILE__)))
        return;

    if ('page' == $_POST['post_type']) {
        if (!current_user_can('edit_page', $post_id))
            return;
    }
    else {
        if (!current_user_can('edit_post', $post_id))
            return;
    }

    $smcwpd_postdata = $_POST['smcwpd_showfield'];
    update_post_meta($post_id, 'smcwpd_showfield', $smcwpd_postdata); // location general @since 1.2.1
//
}

/* ------------------------------ 1.5.3 ------------------------------- */
if (!function_exists('smc_is_login_page')) {

    function smc_is_login_page()
    {
        return in_array($GLOBALS['pagenow'], array('wp-login.php', 'wp-register.php'));
    }

}
if (!function_exists('smc_draugiem_say_headinit')) {

    function smc_draugiem_say_headinit()
    {
        if (!is_admin() && !smc_is_login_page()) {
            wp_register_script('draugiem_api', DRAUGIEMJSAPI, array(), '1152', false);
            wp_enqueue_script('draugiem_api');
        }
    }

    add_action('init', 'smc_draugiem_say_headinit');
}
