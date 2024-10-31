<?php if(preg_match('#' . basename(__FILE__) . '#', $_SERVER['PHP_SELF'])) { die('You are not allowed to call this page directly.'); } ?>
<?php if ( ! empty( $_POST ) && ! wp_verify_nonce( $_REQUEST['wp_create_nonce'], 'wp_create_nonce_form_show' ) )  { die('<p>Security check failed.</p>'); } ?>
<?php
// Form submitted, check the data
if (isset($_POST['frm_popunderpopup_display']) && $_POST['frm_popunderpopup_display'] == 'yes')
{
	$did = isset($_GET['did']) ? sanitize_text_field($_GET['did']) : '0';
	if(!is_numeric($did)) { die('<p>Are you sure you want to do this?</p>'); }
	
	$popunderpopup_success = '';
	$popunderpopup_success_msg = FALSE;
	
	// First check if ID exist with requested ID
	$result = popunderpopup_cls_dbquery::popup_count($did);
	
	if ($result != '1')
	{
		?><div class="error fade"><p><strong><?php _e('Oops, selected details doesnt exist.', 'popunder-popup'); ?></strong></p></div><?php
	}
	else
	{
		// Form submitted, check the action
		if (isset($_GET['ac']) && $_GET['ac'] == 'del' && isset($_GET['did']) && $_GET['did'] != '')
		{
			//	Just security thingy that wordpress offers us
			check_admin_referer('popunderpopup_form_show');
			
			//	Delete selected record from the table
			popunderpopup_cls_dbquery::popup_delete($did);
			
			//	Set success message
			$popunderpopup_success_msg = TRUE;
			$popunderpopup_success = __('Selected record was successfully deleted.', 'popunder-popup');
		}
	}
	
	if ($popunderpopup_success_msg == TRUE)
	{
		?><div class="updated fade"><p><strong><?php echo $popunderpopup_success; ?></strong></p></div><?php
	}
}
?>
<div class="wrap">
  <div id="icon-edit" class="icon32 icon32-posts-post"></div>
    <h2><?php _e(POPUNDER_PLUGIN_DISPLAY, 'popunder-popup'); ?>
	<a class="add-new-h2" href="<?php echo POPUNDER_ADMINURL; ?>&page=popunder-popup&ac=add"><?php _e('Add New', 'popunder-popup'); ?></a></h2>
    <div class="tool-box">
	<?php
		$myData = array();
		$myData = popunderpopup_cls_dbquery::popup_select(0);
		?>
		<form name="frm_popunderpopup_display" method="post">
      <table width="100%" class="widefat" id="straymanage">
        <thead>
          <tr>
			<th scope="col"><?php _e('ID', 'popunder-popup'); ?></th>
            <th scope="col"><?php _e('Popunder url', 'popunder-popup'); ?></th>
			<th scope="col"><?php _e('Start date', 'popunder-popup'); ?></th>
			<th scope="col"><?php _e('Expiration date', 'popunder-popup'); ?></th>
			<th scope="col"><?php _e('Category', 'popunder-popup'); ?></th>
			<th scope="col"><?php _e('Width', 'popunder-popup'); ?></th>
          </tr>
        </thead>
		<tfoot>
          <tr>
			<th scope="col"><?php _e('ID', 'popunder-popup'); ?></th>
            <th scope="col"><?php _e('Popunder url', 'popunder-popup'); ?></th>
			<th scope="col"><?php _e('Start date', 'popunder-popup'); ?></th>
			<th scope="col"><?php _e('Expiration date', 'popunder-popup'); ?></th>
			<th scope="col"><?php _e('Category', 'popunder-popup'); ?></th>
			<th scope="col"><?php _e('Width', 'popunder-popup'); ?></th>
          </tr>
        </tfoot>
		<tbody>
			<?php 
			$i = 0;
			if(count($myData) > 0 )
			{
				foreach ($myData as $data)
				{
					?>
					<tr class="<?php if ($i&1) { echo'alternate'; } else { echo ''; }?>">
						<td><?php echo $data['id']; ?></td>
						<td><?php echo esc_html(stripslashes($data['url'])); ?>
						<div class="row-actions">
						<span class="edit">
						<a title="Edit" href="<?php echo POPUNDER_ADMINURL; ?>&ac=edit&amp;did=<?php echo $data['id']; ?>"><?php _e('Edit', 'popunder-popup'); ?></a> | </span>
						<span class="trash">
						<a onClick="javascript:_popunderpopup_delete('<?php echo $data['id']; ?>')" href="javascript:void(0);"><?php _e('Delete', 'popunder-popup'); ?></a>
						</span> 
						</div>
						</td>
						<td><?php echo esc_html(substr($data['starttime'],0,10)); ?></td>
						<td><?php echo esc_html(substr($data['expiration'],0,10)); ?></td>
						<td><?php echo esc_html($data['group']); ?></td>
						<td><?php echo esc_html($data['width']); ?>%</td>
					</tr>
					<?php 
					$i = $i+1; 
				} 	
			}
			else
			{
				?><tr><td colspan="6" align="center"><?php _e('No records available.', 'popunder-popup'); ?></td></tr><?php 
			}
			?>
		</tbody>
        </table>
		<?php wp_nonce_field('popunderpopup_form_show'); ?>
		<input type="hidden" name="frm_popunderpopup_display" value="yes"/>
		<?php $nonce = wp_create_nonce( 'wp_create_nonce_form_show' ); ?>
	  <input type="hidden" name="wp_create_nonce" id="wp_create_nonce" value="<?php echo $nonce; ?>"/>
      </form>	
	  <div class="tablenav bottom">
		  <a href="<?php echo POPUNDER_ADMINURL; ?>&amp;ac=add"><input class="button action" type="button" value="<?php _e('Add New', 'popunder-popup'); ?>" /></a>
		  <a href="<?php echo POPUNDER_ADMINURL; ?>&amp;ac=set"><input class="button action" type="button" value="<?php _e('Session Setting', 'popunder-popup'); ?>" /></a>
		  <a target="_blank" href="<?php echo POPUNDER_FAV; ?>"><input class="button action" type="button" value="<?php _e('Help', 'popunder-popup'); ?>" /></a>
		  <a target="_blank" href="<?php echo POPUNDER_FAV; ?>"><input class="button button-primary" type="button" value="<?php _e('Short Code', 'popunder-popup'); ?>" /></a>
	  </div>
	<h3><?php _e('Plugin configuration option', 'popunder-popup'); ?></h3>
	<ol>
		<li><?php _e('Add popup into specific  post or page using short code', 'popunder-popup'); ?></li>
		<li><?php _e('Add directly in to the theme using PHP code', 'popunder-popup'); ?></li>
	</ol>
	<p class="description"><?php echo POPUNDER_OFFICIAL; ?></p>
	</div>
</div>