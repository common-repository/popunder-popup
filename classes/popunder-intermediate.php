<?php
class popunderpopup_cls_intermediate
{
	public static function popunderpopup_admin()
	{
		global $wpdb;
		$current_page = isset($_GET['ac']) ? $_GET['ac'] : '';
		switch($current_page)
		{
			case 'add':
				require_once(POPUNDER_DIR.'page'.DIRECTORY_SEPARATOR.'popunder-add.php');
				break;
			case 'edit':
				require_once(POPUNDER_DIR.'page'.DIRECTORY_SEPARATOR.'popunder-edit.php');
				break;
			case 'set':
				require_once(POPUNDER_DIR.'page'.DIRECTORY_SEPARATOR.'popunder-setting.php');
				break;
			default:
				require_once(POPUNDER_DIR.'page'.DIRECTORY_SEPARATOR.'popunder-show.php');
				break;
		}
	}
}
?>