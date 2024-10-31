<?php if(preg_match('#' . basename(__FILE__) . '#', $_SERVER['PHP_SELF'])) { die('You are not allowed to call this page directly.'); } ?>
<?php
class popunderpopup_cls_dbquery
{
	public static function popup_count($id = 0)
	{
		global $wpdb;
		$prefix = $wpdb->prefix;
		$result = 0;
		if($id > 0)
		{
			$sSql = $wpdb->prepare("SELECT COUNT(*) AS `count` FROM `".$prefix."popunderpopup` WHERE `id` = %d", array($id));
		}
		else
		{
			$sSql = "SELECT COUNT(*) AS `count` FROM `".$prefix."popunderpopup`";
		}
		$result = $wpdb->get_var($sSql);
		return $result;
	}
	
	public static function popup_select($id = 0)
	{
		global $wpdb;
		$prefix = $wpdb->prefix;
		$arrRes = array();
		if($id > 0)
		{
			$sSql = $wpdb->prepare("SELECT * FROM `".$prefix."popunderpopup` where id = %d", array($id));
		}
		else
		{
			$sSql = "SELECT * FROM `".$prefix."popunderpopup` order by id desc";
		}
		$arrRes = $wpdb->get_results($sSql, ARRAY_A);
		return $arrRes;
	}
	
	public static function popup_widget($id = 0, $cat = "")
	{
		global $wpdb;
		$prefix = $wpdb->prefix;
		$arrRes = array();
		$sSql = "SELECT * FROM `".$prefix."popunderpopup` where url <> ''";
		if ($id > 0)
		{
			$sSql = $sSql . " and id = ".$id;
		}
		if ($cat <> "")
		{
			$sSql = $sSql . " and `group` = '".$cat."'";
		}
		$sSql = $sSql . " and ( expiration >= NOW() or expiration = '0000-00-00 00:00:00' )";
		$sSql = $sSql . " and ( starttime <= NOW() or starttime = '0000-00-00 00:00:00' )";
		$sSql = $sSql . " Order by rand()";
		$sSql = $sSql . " LIMIT 0,1";
		$arrRes = $wpdb->get_results($sSql, ARRAY_A);
		return $arrRes;
	}
	
	public static function popup_delete($id = 0)
	{
		global $wpdb;
		$prefix = $wpdb->prefix;
		$sSql = $wpdb->prepare("DELETE FROM `".$prefix."popunderpopup` WHERE `id` = %d LIMIT 1", $id);
		$wpdb->query($sSql);
		return true;
	}
	
	public static function popup_act($data = array(), $action = "ins")
	{
		global $wpdb;
		$prefix = $wpdb->prefix;
		if($action == "ins")
		{
			$sql = $wpdb->prepare("INSERT INTO `".$prefix."popunderpopup` 
			(`url`, `width`, `height`, `expiration`, `starttime`, `group`, `timeout`)
			VALUES(%s, %s, %s, %s, %s, %s, %s)", 
			array($data["url"], $data["width"], $data["height"], $data["expiration"], $data["starttime"], $data["group"], $data["timeout"]) );
			$wpdb->query($sql);
			return "sus";
		}
		elseif($action == "ups")
		{
			$sql = $wpdb->prepare("UPDATE `".$prefix."popunderpopup` SET `url` = %s, `width` = %s, `height` = %s, `expiration` = %s, `starttime` = %s, 
			`group` = %s, `timeout` = %s WHERE id = %d LIMIT 1", array($data["url"], $data["width"], $data["height"], $data["expiration"], $data["starttime"], 
			$data["group"], $data["timeout"], $data["id"]) );
			$wpdb->query($sql);
			return "sus";
		}
		else
		{
			return "err";
		}
	}
	
	public static function popup_default()
	{
		$result = popunderpopup_cls_dbquery::popup_count(0);
		if ($result == 0)
		{
			global $wpdb;
			$prefix = $wpdb->prefix;
			$title = "Popunder popup - sample data";
			$url = "http://www.example.com/";
			$sql = $wpdb->prepare("INSERT INTO `".$prefix."popunderpopup` (`url`) VALUES (%s)", array($url));
			$wpdb->query($sql);
		}
		return true;
	}
}
?>