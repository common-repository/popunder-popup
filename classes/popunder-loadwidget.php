<?php
class popunderpopup_cls_widget
{
	public static function popunderpopup_widget_int($arr)
	{
		if ( ! is_array( $arr ) )
		{
			return '';
		}
		
		$popunderpopup_session = get_option('popunderpopup_session');
		$display = "NO";
		$popunder = "";
		if($popunderpopup_session <> "YES")
		{
			$display = "YES";
		}
		else if($popunderpopup_session == "YES" && isset($_SESSION['popunder-popup']) <> "YES")
		{
			$display = "YES";
		}
		else if($popunderpopup_session == "YES" && isset($_SESSION['popunder-popup']) == "YES")
		{
			$display = "NO";
		}
		
		if($display == "YES")
		{
			$id = isset($arr['id']) ? $arr['id'] : '0';
			$cat = isset($arr['cat']) ? $arr['cat'] : '';
			$data = array();
			$data = popunderpopup_cls_dbquery::popup_widget($id, $cat);
			
			if( count($data) > 0 )
			{
				$form = array(
					'id' => $data[0]['id'],
					'url' => $data[0]['url'],
					'width' => $data[0]['width'],
					'height' => $data[0]['height'],
					'expiration' => $data[0]['expiration'],
					'starttime' => $data[0]['starttime'],
					'group' => $data[0]['group'],
					'timeout' => $data[0]['timeout']
				);
				
				$width = $form["width"];
				$height = $form["height"];
				
				if(!is_numeric($width)) 
				{
					$width = 70;
				}
				if(!is_numeric($height)) 
				{
					$height = 70;
				}
				//require_once(POPUNDER_DIR.'classes'.DIRECTORY_SEPARATOR.'popunder-widget.php');
				
				$popunder = $popunder . '<script type="text/javascript">';
				$popunder = $popunder . '(function($)'; 
				$popunder = $popunder . '{';
				$popunder = $popunder . '$.popunder = function(sUrl) {';
					//$popunder = $popunder . 'var bSimple = $.browser.msie,';
					$popunder = $popunder . 'var bSimple = "",';
						$popunder = $popunder . 'run = function() {';
							$popunder = $popunder . '$.popunderHelper.open(sUrl, bSimple);';
						$popunder = $popunder . '};';
					$popunder = $popunder . '(bSimple) ? run() : window.setTimeout(run, 1);';
					$popunder = $popunder . 'return $;';
				$popunder = $popunder . '};';
				
				$popunder = $popunder . '$.popunderHelper = {';
					$popunder = $popunder . 'rand: function(name, rand) {';
						$popunder = $popunder . "var p = (name) ? name : 'pu_';";
						$popunder = $popunder . "return p + (rand === false ? '' : Math.floor(89999999*Math.random()+10000000));";
					$popunder = $popunder . '},';
				
					$popunder = $popunder . 'open: function(sUrl, bSimple) {';
						$popunder = $popunder . 'var _parent = self,';
							//$popunder = $popunder . "sToolbar = (!$.browser.webkit && (!$.browser.mozilla || parseInt($.browser.version, 10) < 12)) ? 'yes' : 'no',";
							$popunder = $popunder . "sToolbar = 'no',";
							$popunder = $popunder . 'sOptions,';
							$popunder = $popunder . 'popunder;';
				
						$popunder = $popunder . 'if (top != self) {';
							$popunder = $popunder . 'try {';
								$popunder = $popunder . 'if (top.document.location.toString()) {';
									$popunder = $popunder . '_parent = top;';
								$popunder = $popunder . '}';
							$popunder = $popunder . '}';
							$popunder = $popunder . 'catch(err) { }';
						$popunder = $popunder . '}';
						
						$popunder = $popunder . 'var w = '.$width.';';
						$popunder = $popunder . 'var h = '.$height.';';
						$popunder = $popunder . 'var livew = screen.availWidth;';
						$popunder = $popunder . 'var liveh = screen.availHeight;';
						$popunder = $popunder . 'var showw = (w/100) * livew;';
						$popunder = $popunder . 'var showh = (h/100) * liveh;';
						$popunder = $popunder . "sOptions = 'toolbar=' + sToolbar + ',scrollbars=yes,location=yes,statusbar=yes,menubar=no,resizable=1,width=' + showw.toString();";
						$popunder = $popunder . "sOptions += ',height=' + showh.toString() + ',screenX=0,screenY=0,left=0,top=0';";
				
						$popunder = $popunder . 'popunder = _parent.window.open(sUrl, $.popunderHelper.rand(), sOptions);';
						$popunder = $popunder . 'if (popunder) {';
							$popunder = $popunder . 'popunder.blur();';
							$popunder = $popunder . 'if (bSimple) {';
								$popunder = $popunder . 'window.focus();';
								$popunder = $popunder . 'try { opener.window.focus(); }';
								$popunder = $popunder . 'catch (err) { }';
							$popunder = $popunder . '}';
							$popunder = $popunder . 'else {';
								$popunder = $popunder . 'popunder.init = function(e) {';
									$popunder = $popunder . 'with (e) {';
										$popunder = $popunder . '(function() {';
											$popunder = $popunder . 'if (typeof window.mozPaintCount != "undefined" || typeof navigator.webkitGetUserMedia === "function") {';
												$popunder = $popunder . "var x = window.open('about:blank');";
												$popunder = $popunder . 'x.close();';
											$popunder = $popunder . '}';
				
											$popunder = $popunder . 'try { opener.window.focus(); }';
											$popunder = $popunder . 'catch (err) { }';
										$popunder = $popunder . '})();';
									$popunder = $popunder . '}';
								$popunder = $popunder . '};';
								$popunder = $popunder . 'popunder.params = {';
									$popunder = $popunder . 'url: sUrl';
								$popunder = $popunder . '};';
								$popunder = $popunder . 'popunder.init(popunder);';
							$popunder = $popunder . '}';
						$popunder = $popunder . '}';
				
						$popunder = $popunder . 'return true;';
					$popunder = $popunder . '}';
				$popunder = $popunder . '};';
				$popunder = $popunder . '})(jQuery);';
				
				$popunder = $popunder . 'function iframepopupwidow(sUrl)';
				$popunder = $popunder . '{';
					$popunder = $popunder . "jQuery('#openpopunder').ready(function() {";
						$popunder = $popunder . 'jQuery.popunder(sUrl);';
					$popunder = $popunder . '});';
				$popunder = $popunder . '}';
				$popunder = $popunder . '</script>';
				
				
				$popunder = $popunder . '<script type="text/javascript">';
				$popunder = $popunder . 'document.onclick = function() ';
				$popunder = $popunder . '{'; 
					$popunder = $popunder . 'var openpopunder = document.getElementById("openpopunder");';
					$popunder = $popunder . 'if( openpopunder.value == "YES" )';
					$popunder = $popunder . '{';
						$popunder = $popunder . 'document.getElementById("openpopunder").value = "NO";';
						$popunder = $popunder . 'iframepopupwidow("'.$form["url"].'");';
					$popunder = $popunder . '}';
				$popunder = $popunder . '};';
				$popunder = $popunder . '</script>';
				$popunder = $popunder . '<input name="openpopunder" id="openpopunder" value="YES" type="hidden">';
				
				$_SESSION['popunder-popup'] = "YES";
			}
		}
		return $popunder;
	}
}

function popunderpopup_shortcode( $atts ) 
{
	if ( ! is_array( $atts ) )
	{
		return '';
	}
	//[popunder-popup id="1" cat=""]
	//[popunder-popup id="1"]
	//[popunder-popup cat="Category1"]
	$id = isset($atts['id']) ? $atts['id'] : '0';
	$cat = isset($atts['cat']) ? $atts['cat'] : '';
	
	$arr = array();
	$arr["id"] 	= $id;
	$arr["cat"] = $cat;
	return popunderpopup_cls_widget::popunderpopup_widget_int($arr);
}

function pp_popup()
{
	$arr = array();
	$arr["id"] 	= 0;
	$arr["cat"] = "";
	echo popunderpopup_cls_widget::popunderpopup_widget_int($arr);
}

function pp_popup_id( $id = "0" )
{
	$arr = array();
	$arr["id"] 	= $id;
	$arr["cat"] = "";
	echo popunderpopup_cls_widget::popunderpopup_widget_int($arr);
}

function pp_popup_cat( $cat = "" )
{
	$arr = array();
	$arr["id"] 	= 0;
	$arr["cat"] = $cat;
	echo popunderpopup_cls_widget::popunderpopup_widget_int($arr);
}
?>