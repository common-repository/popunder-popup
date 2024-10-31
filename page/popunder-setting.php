<?php if(preg_match('#' . basename(__FILE__) . '#', $_SERVER['PHP_SELF'])) { die('You are not allowed to call this page directly.'); } ?>
<div class="wrap">
  <div class="form-wrap">
    <div id="icon-edit" class="icon32 icon32-posts-post"></div>
    <h2><?php _e(POPUNDER_PLUGIN_DISPLAY, 'popunder-popup'); ?></h2>
    <?php
	$popunderpopup_session = get_option('popunderpopup_session');

	if (isset($_POST['popunderpopup_form_submit']) && $_POST['popunderpopup_form_submit'] == 'yes')
	{
		//	Just security thingy that wordpress offers us
		check_admin_referer('popunderpopup_form_setting');
			
		$popunderpopup_session = stripslashes(sanitize_text_field($_POST['popunderpopup_session']));	
		if($popunderpopup_session != "YES" && $popunderpopup_session != "NO")
		{
			$popunderpopup_session = "YES";
		}
		
		update_option('popunderpopup_session', $popunderpopup_session );
		?>
		<div class="updated fade">
			<p><strong><?php _e('Details was successfully updated.', 'popunder-popup'); ?></strong></p>
		</div>
		<?php
	}
	?>
	<script language="JavaScript" src="<?php echo POPUNDER_URL; ?>page/setting.js"></script>
	<h3><?php _e('Session Setting', 'popunder-popup'); ?></h3>
	<form name="popunderpopup_form_setting" method="post" action="#" onsubmit="return _popunderpopup_submit_setting()">
		<label for="tag-title"><?php _e('Session option (Global setting)', 'popunder-popup'); ?></label>
		<select name="popunderpopup_session" id="popunderpopup_session">
            <option value=''>Select</option>
			<option value='NO' <?php if($popunderpopup_session == 'NO') { echo 'selected' ; } ?>>NO</option>
            <option value='YES' <?php if($popunderpopup_session == 'YES') { echo 'selected' ; } ?>>YES</option>
          </select>
		<p><?php _e('Select YES to show popunder once per session, Meaning, popup never appear again if user navigate to another page.', 'popunder-popup'); ?></p>
				
		<div style="height:10px;"></div>
		<input type="hidden" name="popunderpopup_form_submit" value="yes"/>
		<input name="popunderpopup_submit" id="popunderpopup_submit" class="button" value="<?php _e('Submit', 'popunder-popup'); ?>" type="submit" />
		<input name="publish" lang="publish" class="button" onclick="_popunderpopup_redirect()" value="<?php _e('Cancel', 'popunder-popup'); ?>" type="button" />
		<input name="Help" lang="publish" class="button" onclick="_popunderpopup_help()" value="<?php _e('Help', 'popunder-popup'); ?>" type="button" />
		<?php wp_nonce_field('popunderpopup_form_setting'); ?>
	</form>
  </div>
  <br />
  <p class="description"><?php echo POPUNDER_OFFICIAL; ?></p>
</div>