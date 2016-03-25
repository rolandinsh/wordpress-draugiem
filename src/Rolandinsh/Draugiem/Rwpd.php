<?php

namespace Rolandinsh\Draugiem;

class Rwpd
{

   public $version = '3.0.0';
   public $draugiem_js_api = '//www.draugiem.lv/api/api.js';

    const WPDRAUGIEMV = '3.0.0-alpha1';
    const WPDRAUGIEMF = 'wordpress-draugiem';
    const WPDWPORGP = 'http://wordpress.org/extend/plugins/';
    const MEDIABOX_PLUGIN_PAGE = 'http://mediabox.lv/wordpress-draugiem/';
    
    public function __construct()
    {
        add_action('init', array(&$this, 'init'), 10);
    }
    // Initialize
    public function init()
    {
        load_plugin_textdomain('wpdraugiem', false, dirname(plugin_basename(__FILE__)) . '/lang/');
    }
    public function draugiemjsapi(){
        $ishttpsurl = is_ssl() ? 'https:' : 'http:';  // fix https @since 1.5.4.1
        return $ishttpsurl . $this->draugiem_js_api;
    }
}

$smc_wp_draugiem = new Wpd();
define('WPDRAUGIEMV', $smc_wp_draugiem::WPDRAUGIEMV); // location general @since 1.0.0
define('WPDRAUGIEM', dirname(__FILE__)); // location general @since 1.0.0
define('WPDRAUGIEMF', $smc_wp_draugiem::WPDRAUGIEMF); // location folder @since 1.0.0
define('WPDRAUGIEMURL', plugin_dir_url(__FILE__));
define('WPDRAUGIEMI', WPDRAUGIEMURL . '/img'); // Image location @since 1.0.0
define('WPDWPORG', $smc_wp_draugiem::WPDWPORGP . WPDRAUGIEMF); // @todo refactor

if (!defined('DRAUGIEMJSAPI')) {
    define('DRAUGIEMJSAPI', $smc_wp_draugiem->draugiemjsapi());
}
