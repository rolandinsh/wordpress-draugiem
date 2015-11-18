<?php

/**
 * Plugin Name: WordPress Draugiem
 * Plugin URI: http://mediabox.lv/wordpress-draugiem/?utm_source=wordpress&utm_medium=wpplugin&utm_campaign=WordPressDraugiem&utm_content=v-3-0-0-wp-draugiem_load_widgets
 * Description: WordPress plugin for Latvian Social Network Draugiem.lv
 * Version: 3.0.0-alpha1
 * Requires at least: 2.7
 * Tested up to: 4.2.2
 * Author: Rolands Umbrovskis
 * Author URI: http://umbrovskis.com
 * License: simplemediacode
 * License URI: http://simplemediacode.com/license/
 */
// refactoring in progress
require_once plugin_dir_path( __FILE__ ) . '/vendor/autoload.php';
new \Rolandinsh\Draugiem\Admin();
new \Rolandinsh\Draugiem\Rwpd();
