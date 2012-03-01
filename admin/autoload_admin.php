<?php 
add_action('admin_menu', 'smc_wpd_admin_menu');

function smc_wpd_admin_menu() {
	//create new top-level menu
	add_menu_page('WordPress Draugiem', 'WP Draugiem', 'activate_plugins', 'smcwpd', 'smcwpd_settings');
	add_submenu_page( 'smcwpd', __('Help'), __('Help'), 'edit_posts', 'smcwpdhelp', 'smcwpd_help');

	register_setting( 'smc-wpd-settings', 'smc_wpd_ieteikt_all' );
	register_setting( 'smc-wpd-settings', 'smc_wpd_ieteikt_where' );

}


function smcwpd_settings(){
?><div class="wrap">
<h2><?php _e('Settings');?></h2>
<form method="post" action="options.php">
<?php settings_fields( 'smc-wpd-settings' );
$smc_wpd_ieteikt_all = get_option('smc_wpd_ieteikt_all');
$smc_wpd_ieteikt_where = get_option('smc_wpd_ieteikt_where');
// dev
// var_dump($smc_wpd_ieteikt_all); 
?>
<table class="form-table table">
	<tr>
		<th valign="top">Rādīt visās lapās un rakstos</th>
		<td valign="top"><input type="checkbox" id="smc_wpd_ieteikt_all" name="smc_wpd_ieteikt_all" <?php checked($smc_wpd_ieteikt_all,'on') ?> /></td>
	</tr>
	<tr>
		<th valign="top">Sākumā / beigās</th>
		<td valign="top">
<select name="smc_wpd_ieteikt_where">
    <option value="1" <?php selected( $smc_wpd_ieteikt_where, 1 ); ?>>sākums</option>
    <option value="2" <?php selected( $smc_wpd_ieteikt_where, 2 ); ?>>beigas</option>
    <option value="3" <?php selected( $smc_wpd_ieteikt_where, 3 ); ?>>sākums un beigas</option>
</select>
        </td>
	</tr>
 </table>
    <p class="submit">
    <input type="submit" class="button-primary" value="<?php _e('Save Changes') ?>" />
    </p>
</form>
</div><?php } // smcwpd_settings()


function smcwpd_help(){
?><div class="wrap">
<h2><?php _e('Help');?></h2>
<p>Visa palīdzība ir pieejam izmantojot atbalsta forumu vai lasot dokumentāciju.</p>
<p>Spraudņa lapa: <a href="http://mediabox.lv/wordpress-draugiem/?utm_source=<?php echo urlencode(get_home_url());?>&utm_content=SMC-WPD-Help-link-pluginn-page&utm_medium=link&utm_campaign=WordPressDraugiem_<?php echo WPDRAUGIEMV;?>" title="WordPress Draugiem" target="_blank">MediaBox.lv/wordpress-draugiem/</a></p>
<h3>Izstrādātājiem</h3>
<p>Svaigākā darba kopija: <a href="http://e-art.lv/x/wpdgc" target="_blank">http://code.google.com/p/draugiem/source/checkout</a><br />
<code>svn checkout <strong>http:</strong>//draugiem.googlecode.com/svn/trunk/ draugiem</code>
</p>
</div><?php } // jic_settings_page()

// -------------------------------
/*
 * Skati pie rakstiem un lapām
 * @todo ielikt API
*/
add_filter('manage_posts_columns', 'smc_draugiem_ieteikt_kol');
add_filter('manage_pages_columns', 'smc_draugiem_ieteikt_kol');
function smc_draugiem_ieteikt_kol($columns) {
    $columns['smc_draugiem_ieteikt'] = 'Draugiem.lv/say';
    return $columns;
}

add_action('manage_posts_custom_column',  'smc_draugiem_ieteikt_kshow');
add_action('manage_pages_custom_column',  'smc_draugiem_ieteikt_kshow');
function smc_draugiem_ieteikt_kshow($name) {
    global $post;

    switch ($name) {
        case 'smc_draugiem_ieteikt':
		$posturl = urlencode(get_permalink($post->ID));
		$posttitle = urlencode($post->post_title);
		$awesomeblog = urlencode(get_bloginfo('name'));
		
		echo '<iframe height="20" width="84" frameborder="0" src="http://www.draugiem.lv/say/ext/like.php?title='.$posttitle.'&amp;url='.$posturl.'&amp;titlePrefix='.$awesomeblog.'"></iframe>';
    }
}
