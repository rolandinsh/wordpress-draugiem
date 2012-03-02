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
<h2>Lietošana</h2>
<p><strong>[ieteikumusaraksts]</strong>: ir 3 <em>neobligāti</em> parametri:</p>
<ol>
	<li><strong>domain</strong> - kurai lapai vēlaties rādīt ieteikumu sarakstu. Noklusētā vērtība ir tavs blogs (<em><?php echo get_home_url();?></em>). Ja vēlies norādīt citu lapu vai domēnu, tad jāieraksta attiecīgā adrese,piem., <code>[ieteikumusaraksts domain="http://rolandinsh.lv"]</code></li>
	<li><strong>count</strong> - cik ierakstus rādīt. Noklusētā vērtība ir 5. Ja vēlies norādīt citu skaitu, tad jāieraksta attiecīgi cits cipars,piem., <code>[ieteikumusaraksts count="5"]</code></li>
	<li><strong>id</strong> - lietot nepieciešams, ja vienā lapā ir vairāk par vienu ieteikumu sarakstu. Noklusētā vērtība ir <code>smc_wpd_recommend_list</code>. Ja vēlies norādīt citu unikālo ID, tad jāieraksta,piem., <code>[ieteikumusaraksts id="man_cits_id"]</code></li>
</ol>
<p>Ja ir vēlma mainīt vairākus parametru, tos var apvienot, piem., <code>[ieteikumusaraksts domain="http://rolandinsh.lv" count="5"]</code> vai <code>[ieteikumusaraksts domain="http://rolandinsh.lv" count="5" id="man_cits_id"]</code> vai <code>[ieteikumusaraksts count="5" id="man_cits_id"]</code></p>

<h2>Izstrādātājiem</h2>
<p><strong>SVN</strong></p>
<p>Svaigākā darba kopija: <a href="http://e-art.lv/x/wpdgc" target="_blank">http://code.google.com/p/draugiem/source/checkout</a><br />
<code>svn checkout <strong>http:</strong>//draugiem.googlecode.com/svn/trunk/ draugiem</code>
</p>
<p><strong>GIT</strong></p>
<p>Svaigākā darba kopija: <a href="http://e-art.lv/x/wpdgitp" target="_blank">https://github.com/rolandinsh/wordpress-draugiem</a><br />
<code>git://github.com/rolandinsh/wordpress-draugiem.git</code>
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
// -----------------------------------


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
// <iframe src="http://www.draugiem.lv/say/ext/recommend.php?url=...&count=..." frameborder="0"></iframe>

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