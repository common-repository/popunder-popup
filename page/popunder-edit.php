<?php if(preg_match('#' . basename(__FILE__) . '#', $_SERVER['PHP_SELF'])) { die('You are not allowed to call this page directly.'); } ?>
<?php if ( ! empty( $_POST ) && ! wp_verify_nonce( $_REQUEST['wp_create_nonce'], 'wp_create_nonce_form_edit' ) )  { die('<p>Security check failed.</p>'); } ?>
<div class="wrap">
<?php
$did = isset($_GET['did']) ? sanitize_text_field($_GET['did']) : '0';
if(!is_numeric($did)) { die('<p>Are you sure you want to do this?</p>'); }

// First check if ID exist with requested ID
$result = '0';
$result = popunderpopup_cls_dbquery::popup_count($did);

if ($result != '1')
{
	?><div class="error fade"><p><strong><?php _e('Oops, selected details doesnt exist.', 'popunder-popup'); ?></strong></p></div><?php
}
else
{
	$popunderpopup_errors = array();
	$popunderpopup_success = '';
	$popunderpopup_error_found = FALSE;
	
	$data = array();
	$data = popunderpopup_cls_dbquery::popup_select($did);
	
	// Preset the form fields
	$form = array(
		'id' => $data[0]['id'],
		'url' => $data[0]['url'],
		'width' => $data[0]['width'],
		'height' => $data[0]['height'],
		'expiration' => $data[0]['expiration'],
		'starttime' => $data[0]['starttime'],
		'group' => $data[0]['group'],
		'timeout' => $data[0]['timeout'],
	);
}
// Form submitted, check the data
if (isset($_POST['popunderpopup_form_submit']) && $_POST['popunderpopup_form_submit'] == 'yes')
{
	//	Just security thingy that wordpress offers us
	check_admin_referer('popunderpopup_form_edit');
	
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
	
	$form['id'] 		= isset($_POST['id']) ? sanitize_text_field($_POST['id']) : '';

	//	No errors found, we can add this Group to the table
	if ($popunderpopup_error_found == FALSE)
	{	
		$action = popunderpopup_cls_dbquery::popup_act($form, "ups");
		if($action == "sus")
		{
			$popunderpopup_success = __('Details was successfully updated.', 'popunder-popup');
		}
		elseif($action == "err")
		{
			$popunderpopup_success = __('Oops unexpected error occurred.', 'popunder-popup');
			$popunderpopup_error_found = TRUE;
		}
	}
}

if ($popunderpopup_error_found == TRUE && isset($popunderpopup_errors[0]) == TRUE)
{
	?><div class="error fade"><p><strong><?php echo $popunderpopup_errors[0]; ?></strong></p></div><?php
}
if ($popunderpopup_error_found == FALSE && strlen($popunderpopup_success) > 0)
{
	?>
	<div class="updated fade">
		<p><strong><?php echo $popunderpopup_success; ?> 
		<a href="<?php echo POPUNDER_ADMINURL; ?>"><?php _e('Click here', 'popunder-popup'); ?></a> 
		<?php _e('to view the details', 'popunder-popup'); ?></strong></p>
	</div>
	<?php
}
?>
<script type="text/javascript" src="<?php echo POPUNDER_URL; ?>page/setting.js"></script>
<div class="form-wrap">
	<div id="icon-edit" class="icon32 icon32-posts-post"><br></div>
	<h2><?php _e(POPUNDER_PLUGIN_DISPLAY, 'popunder-popup'); ?></h2>
	<form name="popunderpopup_form" method="post" action="#" onsubmit="return _popunderpopup_submit()"  >
      <h3><?php _e('Update details', 'popunder-popup'); ?></h3>
	  
		<label for="tag-a"><?php _e('Popunder url', 'popunder-popup'); ?></label>
		<input name="url" type="text" id="url" value="<?php echo esc_html($form['url']); ?>" size="70" maxlength="255" />
		<p><?php _e('Enter popunder popup url. url must start with either http or https.', 'popunder-popup'); ?><br />Example: http://www.gopiplus.com</p>
		
		<label for="tag-a"><?php _e('Start date', 'popunder-popup'); ?></label>
		<input name="starttime" type="text" id="starttime" value="<?php echo esc_html(substr($form['starttime'],0,10)); ?>" maxlength="10" />
		<p><?php _e('Please enter popunder start date in format YYYY-MM-DD', 'popunder-popup'); ?></p>			
		
		<label for="tag-a"><?php _e('Expiration date', 'popunder-popup'); ?></label>
		<input name="expiration" type="text" id="expiration" value="<?php echo esc_html(substr($form['expiration'],0,10)); ?>" maxlength="10" />
		<p><?php _e('Please enter popunder expiration date in format YYYY-MM-DD', 'popunder-popup'); ?></p>	
		
		<label for="tag-a"><?php _e('Category', 'popunder-popup'); ?></label>
		<?php
		$thisselected = "";
		?>
		<select name="group" id="group">
			<?php 
			for($i=1; $i<=10; $i++) 
			{ 
				if($form['group'] == "Category".$i) 
				{ 
					$thisselected = "selected='selected'" ; 
				}
				?><option value='Category<?php echo $i; ?>' <?php echo $thisselected; ?>>Category<?php echo $i; ?></option><?php
				$thisselected = "";
			} 
			?>
		</select>
		<p><?php _e('Select category for this popunder.', 'popunder-popup'); ?></p>
		
		<label for="tag-a"><?php _e('Width', 'popunder-popup'); ?></label>
		<select name="width" id="width">
			<option value='30' <?php if($form['width'] == '30') { echo "selected='selected'" ; } ?>>30%</option>
			<option value='35' <?php if($form['width'] == '35') { echo "selected='selected'" ; } ?>>35%</option>
			<option value='40' <?php if($form['width'] == '40') { echo "selected='selected'" ; } ?>>40%</option>
			<option value='45' <?php if($form['width'] == '45') { echo "selected='selected'" ; } ?>>45%</option>
			<option value='50' <?php if($form['width'] == '50') { echo "selected='selected'" ; } ?>>50%</option>
			<option value='55' <?php if($form['width'] == '55') { echo "selected='selected'" ; } ?>>55%</option>
			<option value='60' <?php if($form['width'] == '60') { echo "selected='selected'" ; } ?>>60%</option>
			<option value='65' <?php if($form['width'] == '65') { echo "selected='selected'" ; } ?>>65%</option>
			<option value='70' <?php if($form['width'] == '70') { echo "selected='selected'" ; } ?>>70%</option>
			<option value='75' <?php if($form['width'] == '75') { echo "selected='selected'" ; } ?>>75%</option>
			<option value='80' <?php if($form['width'] == '80') { echo "selected='selected'" ; } ?>>80%</option>
			<option value='85' <?php if($form['width'] == '85') { echo "selected='selected'" ; } ?>>85%</option>
			<option value='90' <?php if($form['width'] == '90') { echo "selected='selected'" ; } ?>>90%</option>
			<option value='95' <?php if($form['width'] == '95') { echo "selected='selected'" ; } ?>>95%</option>
		</select>
		<p><?php _e('Select your width percentage for popup window.', 'popunder-popup'); ?></p>
		
		<label for="tag-a"><?php _e('Height', 'popunder-popup'); ?></label>
		<select name="height" id="height">
			<option value='30' <?php if($form['height'] == '30') { echo "selected='selected'" ; } ?>>30%</option>
			<option value='35' <?php if($form['height'] == '35') { echo "selected='selected'" ; } ?>>35%</option>
			<option value='40' <?php if($form['height'] == '40') { echo "selected='selected'" ; } ?>>40%</option>
			<option value='45' <?php if($form['height'] == '45') { echo "selected='selected'" ; } ?>>45%</option>
			<option value='50' <?php if($form['height'] == '50') { echo "selected='selected'" ; } ?>>50%</option>
			<option value='55' <?php if($form['height'] == '55') { echo "selected='selected'" ; } ?>>55%</option>
			<option value='60' <?php if($form['height'] == '60') { echo "selected='selected'" ; } ?>>60%</option>
			<option value='65' <?php if($form['height'] == '65') { echo "selected='selected'" ; } ?>>65%</option>
			<option value='70' <?php if($form['height'] == '70') { echo "selected='selected'" ; } ?>>70%</option>
			<option value='75' <?php if($form['height'] == '75') { echo "selected='selected'" ; } ?>>75%</option>
			<option value='80' <?php if($form['height'] == '80') { echo "selected='selected'" ; } ?>>80%</option>
			<option value='85' <?php if($form['height'] == '85') { echo "selected='selected'" ; } ?>>85%</option>
			<option value='90' <?php if($form['height'] == '90') { echo "selected='selected'" ; } ?>>90%</option>
			<option value='95' <?php if($form['height'] == '95') { echo "selected='selected'" ; } ?>>95%</option>
		</select>
		<p><?php _e('Select your height percentage for popup window.', 'popunder-popup'); ?></p>
		  
      <input name="id" id="id" type="hidden" value="<?php echo $form['id']; ?>">
	  <input type="hidden" name="timeout" id="timeout" value="4000"/>
      <input type="hidden" name="popunderpopup_form_submit" value="yes"/>
      <p class="submit">
        <input name="publish" lang="publish" class="button add-new-h2" value="<?php _e('Submit', 'popunder-popup'); ?>" type="submit" />
        <input name="publish" lang="publish" class="button add-new-h2" onclick="_popunderpopup_redirect()" value="<?php _e('Cancel', 'popunder-popup'); ?>" type="button" />
        <input name="Help" lang="publish" class="button add-new-h2" onclick="_popunderpopup_help()" value="<?php _e('Help', 'popunder-popup'); ?>" type="button" />
      </p>
	  <?php wp_nonce_field('popunderpopup_form_edit'); ?>
	  <?php $nonce = wp_create_nonce( 'wp_create_nonce_form_edit' ); ?>
	  <input type="hidden" name="wp_create_nonce" id="wp_create_nonce" value="<?php echo $nonce; ?>"/>
    </form>
</div>
<p class="description"><?php echo POPUNDER_OFFICIAL; ?></p>
</div>