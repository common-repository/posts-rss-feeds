<?php
if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

global $wpdb;

if($cbprf_setting_submit != '' && wp_verify_nonce($cbprf_setting_submit, 'cbprf_setting_submit')) {
	
	//sanitize all post values
	$cbprf_setting_submit= sanitize_text_field( $_POST['cbprf_setting_submit'] );
	$post_type_to_feed = sanitize_text_field( $_POST['post_type_to_feed'] );
	$post_cont_in_feed = sanitize_text_field( $_POST['post_cont_in_feed'] );
	$saved = sanitize_text_field( $_POST['saved'] );

    if(isset($post_type_to_feed) ) {
		update_option('post_type_to_feed', $post_type_to_feed);
    }
	if(isset($post_cont_in_feed) ) {
		update_option('post_cont_in_feed', $post_cont_in_feed);
    }
	if($saved==true) {
		$message='saved';
	} 
}

if ( $message == 'saved' ) {
	echo ' <div class="added-success"><p><strong>Settings Saved.</strong></p></div>';
}
?>
   
<div class="wrap netgo-feed-post-setting">
    <form method="post" id="wpffSettingForm" action="">
	<h2><?php _e('Posts RSS Feeds Setting', '');?></h2>
		<table class="form-table">
			<tr valign="top">
				<th scope="row" style="width: 370px;">
					<label for="post_type_to_feed"><?php _e('Post Type to feed','');?></label>
				</th>
				<td>
					<select style="width:150px" id="all-post-type" name="post_type_to_feed">
						<?php 
						$nottoshowarr=array('attachment','revision' , 'nav_menu_item');
						$post_types = get_post_types( '', 'names' ); 
						foreach ( $post_types as $post_type ) {
						if ( !in_array($post_type, $nottoshowarr)) {
						?>
						  <option <?php if(get_option('post_type_to_feed') == $post_type){ ?>selected="selected" <?php } ?> value="<?php echo $post_type;?>"><?php echo $post_type;?></option>
						<?php
						} 
						}
						?>
					</select>
				</td>
			</tr>
			<tr valign="top">
				<th scope="row" style="width: 370px;">
					<label for="post_cont_in_feed"><?php _e('Post count in feed','');?></label>
				</th>
				<td>
				<input type="text" name="post_cont_in_feed" size="5" value="<?php if(get_option('post_cont_in_feed') != ''){ echo get_option('post_cont_in_feed');} else{ ?>-1<?php }  ?>" />
				&nbsp;
				<label>To show all items in feed, put post count as " -1 "</label>
				</td>
			</tr>
			
		   <tr>
		     <td>
				 <p class="submit">
				<input type="hidden" name="saved" value="saved"/>
				<input type="submit" name="wpcpf_setting_submit" class="button-primary" value="Save Changes" />
				  <?php if(function_exists('wp_nonce_field')) wp_nonce_field('cbprf_setting_submit', 'cbprf_setting_submit'); ?>
				</p>
			 </td>
           </tr>		   
		</table>
		
      
    </form>
</div>

