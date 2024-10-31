<?php if(preg_match('#' . basename(__FILE__) . '#', $_SERVER['PHP_SELF'])) { die('You are not allowed to call this page directly.'); } ?>
<?php if ( ! empty( $_POST ) && ! wp_verify_nonce( $_REQUEST['wp_create_nonce'], 'wp_create_nonce_form_add' ) )  { die('<p>Security check failed.</p>'); } ?>
<div class="wrap">
<?php
$popunderpopup_errors = array();
$popunderpopup_success = '';
$popunderpopup_error_found = FALSE;

// Preset the form fields
$form = array(
	'id' => '',
	'url' => '',
	'width' => '',
	'height' => '',
	'expiration' => '',
	'starttime' => '',
	'group' => '',
	'timeout' => ''
);

// Form submitted, check the data
if (isset($_POST['popunderpopup_form_submit']) && $_POST['popunderpopup_form_submit'] == 'yes')
{
	//	Just security thingy that wordpress offers us
	check_admin_referer('popunderpopup_form_add');
	
	$form['url'] = isset($_POST['url']) ? sanitize_text_field($_POST['url']) : '';
	$form['url'] = esc_url_raw( $form['url'] );
	if ($form['url'] == '')
	{
		$popunderpopup_errors[] = __('Enter popunder popup url. url must start with either http or https.', 'popunder-popup');
		$popunderpopup_error_found = TRUE;
	}

	$form['width'] 		= isset($_POST['width']) ? sanitize_text_field($_POST['width']) : '';
	if(!is_numeric($form['width'])) { $form['width'] = 60; }
	
	$form['height'] 	= isset($_POST['height']) ? sanitize_text_field($_POST['height']) : '';
	if(!is_numeric($form['height'])) { $form['height'] = 60; }
	
	$form['expiration'] = isset($_POST['expiration']) ? sanitize_text_field($_POST['expiration']) : '';
	if (!preg_match("/\d{4}\-\d{2}-\d{2}/", $form['expiration'])) 
	{
		$popunderpopup_errors[] = __('Please enter popunder expiration date in format YYYY-MM-DD.', 'popunder-popup');
		$popunderpopup_error_found = TRUE;
	}
	
	$form['starttime'] 	= isset($_POST['starttime']) ? sanitize_text_field($_POST['starttime']) : '';
	if (!preg_match("/\d{4}\-\d{2}-\d{2}/", $form['starttime'])) 
	{
		$popunderpopup_errors[] = __('Please enter popunder start date in format YYYY-MM-DD.', 'popunder-popup');
		$popunderpopup_error_found = TRUE;
	}
	
	$form['group'] 		= isset($_POST['group']) ? sanitize_text_field($_POST['group']) : '';
	
	$form['timeout'] 	= isset($_POST['timeout']) ? sanitize_text_field($_POST['timeout']) : '';
	if(!is_numeric($form['timeout'])) { $form['timeout'] = 4000; }


	//	No errors found, we can add this Group to the table
	if ($popunderpopup_error_found == FALSE)
	{
		$action = popunderpopup_cls_dbquery::popup_act($form, "ins");
		if($action == "sus")
		{
			$popunderpopup_success = __('New details was successfully added.', 'popunder-popup');
		}
		elseif($action == "err")
		{
			$popunderpopup_success = __('Oops unexpected error occurred.', 'popunder-popup');
			$popunderpopup_error_found = TRUE;
		}

		// Reset the form fields
		$form = array(
			'id' => '',
			'url' => '',
			'width' => '',
			'height' => '',
			'expiration' => '',
			'starttime' => '',
			'group' => '',
			'timeout' => ''
		);
	}
}

if ($popunderpopup_error_found == TRUE && isset($popunderpopup_errors[0]) == TRUE)
{
	?>
	<div class="error fade">
		<p><strong><?php echo $popunderpopup_errors[0]; ?></strong></p>
	</div>
	<?php
}
if ($popunderpopup_error_found == FALSE && strlen($popunderpopup_success) > 0)
{
	?>
	<div class="updated fade">
		<p><strong><?php echo $popunderpopup_success; ?> <a href="<?php echo POPUNDER_ADMINURL; ?>"><?php _e('Click here', 'popunder-popup'); ?></a> 
		<?php _e('to view the details', 'popunder-popup'); ?></strong></p>
	</div>
	<?php
}
?>
<div class="form-wrap">
	<div id="icon-edit" class="icon32 icon32-posts-post"><br></div>
	<h2><?php _e(POPUNDER_PLUGIN_DISPLAY, 'popunder-popup'); ?></h2>
	<form name="popunderpopup_form" method="post" action="#" onsubmit="return _popunderpopup_submit()"  >
      <h3><?php _e('Add details', 'popunder-popup'); ?></h3>
      
		<label for="tag-a"><?php _e('Popunder url', 'popunder-popup'); ?></label>
		<input name="url" type="text" id="url" value="" size="70" maxlength="255" />
		<p><?php _e('Enter popunder popup url. url must start with either http or https.', 'popunder-popup'); ?><br />Example: http://www.gopiplus.com</p>
		
		<label for="tag-a"><?php _e('Start date', 'popunder-popup'); ?></label>
		<input name="starttime" type="text" id="starttime" value="2017-01-01" maxlength="10" />
		<p><?php _e('Please enter popunder start date in format YYYY-MM-DD', 'popunder-popup'); ?></p>			
		
		<label for="tag-a"><?php _e('Expiration date', 'popunder-popup'); ?></label>
		<input name="expiration" type="text" id="expiration" value="9999-12-31" maxlength="10" />
		<p><?php _e('Please enter popunder expiration date in format YYYY-MM-DD', 'popunder-popup'); ?></p>	
		
		<label for="tag-a"><?php _e('Category', 'popunder-popup'); ?></label>
		<select name="group" id="group">
			<?php for($i=1; $i<=10; $i++) { ?>
				<option value='Category<?php echo $i; ?>'>Category<?php echo $i; ?></option>
			<?php } ?>
		</select>
		<p><?php _e('Select category for this popunder.', 'popunder-popup'); ?></p>
		
		<label for="tag-a"><?php _e('Width', 'popunder-popup'); ?></label>
		<select name="width" id="width">
			<option value='30'>30%</option>
			<option value='35'>35%</option>
			<option value='40'>40%</option>
			<option value='45'>45%</option>
			<option value='50'>50%</option>
			<option value='55'>55%</option>
			<option value='60' selected="selected">60%</option>
			<option value='65'>65%</option>
			<option value='70'>70%</option>
			<option value='75'>75%</option>
			<option value='80'>80%</option>
			<option value='85'>85%</option>
			<option value='90'>90%</option>
			<option value='95'>95%</option>
		</select>
		<p><?php _e('Select width percentage for popup window.', 'popunder-popup'); ?></p>
		
		<label for="tag-a"><?php _e('Height', 'popunder-popup'); ?></label>
		<select name="height" id="height">
			<option value='30'>30%</option>
			<option value='35'>35%</option>
			<option value='40'>40%</option>
			<option value='45'>45%</option>
			<option value='50'>50%</option>
			<option value='55'>55%</option>
			<option value='60' selected="selected">60%</option>
			<option value='65'>65%</option>
			<option value='70'>70%</option>
			<option value='75'>75%</option>
			<option value='80'>80%</option>
			<option value='85'>85%</option>
			<option value='95'>95%</option>
		</select>
		<p><?php _e('Select height percentage for popup window.', 'popunder-popup'); ?></p>
			  
      <input name="id" id="id" type="hidden" value="">
      <input type="hidden" name="popunderpopup_form_submit" value="yes"/>
	  <input type="hidden" name="timeout" id="timeout" value="4000"/>
      <p class="submit">
        <input name="publish" lang="publish" class="button" value="<?php _e('Submit', 'popunder-popup'); ?>" type="submit" />
        <input name="publish" lang="publish" class="button" onclick="_popunderpopup_redirect()" value="<?php _e('Cancel', 'popunder-popup'); ?>" type="button" />
        <input name="Help" lang="publish" class="button" onclick="_popunderpopup_help()" value="<?php _e('Help', 'popunder-popup'); ?>" type="button" />
      </p>
	  <?php wp_nonce_field('popunderpopup_form_add'); ?>
	  <?php $nonce = wp_create_nonce( 'wp_create_nonce_form_add' ); ?>
	  <input type="hidden" name="wp_create_nonce" id="wp_create_nonce" value="<?php echo $nonce; ?>"/>
    </form>
</div>
<p class="description"><?php echo POPUNDER_OFFICIAL; ?></p>
</div>