<?php
class popunderpopup_cls_registerhook
{
	public static function popunderpopup_activation()
	{
		global $wpdb, $popunderpopup_db_version;
		$prefix = $wpdb->prefix;
		
		add_option('popunderpopup_popup_db', "1.0");
		add_option('popunderpopup_session', "NO");
		
		// Plugin tables
		$array_tables_to_plugin = array('popunderpopup');
		$errors = array();
		
		// loading the sql file, load it and separate the queries
		$sql_file = POPUNDER_DIR.'sql'.DS.'popunder-tbl.sql';
		$prefix = $wpdb->prefix;
        $handle = fopen($sql_file, 'r');
        $query = fread($handle, filesize($sql_file));
        fclose($handle);
        $query=str_replace('CREATE TABLE IF NOT EXISTS `','CREATE TABLE IF NOT EXISTS `'.$prefix, $query);
        $queries=explode('-- SQLQUERY ---', $query);

        // run the queries one by one
        $has_errors = false;
        foreach($queries as $qry)
		{
            $wpdb->query($qry);
        }
		
		// list the tables that haven't been created
        $missingtables=array();
        foreach($array_tables_to_plugin as $table_name)
		{
			if(strtoupper($wpdb->get_var("SHOW TABLES like  '". $prefix.$table_name . "'")) != strtoupper($prefix.$table_name))  
			{
                $missingtables[] = $prefix.$table_name;
            }
        }
		
		// add error in to array variable
        if($missingtables) 
		{
			$errors[] = __('These tables could not be created on installation ' . implode(', ',$missingtables), 'popunder-popup');
            $has_errors=true;
        }
		
		// if error call wp_die()
        if($has_errors) 
		{
			wp_die( __( $errors[0] , 'popunder-popup' ) );
			return false;
		}
		else
		{
			popunderpopup_cls_dbquery::popup_default();
		}
        return true;
	}
	
	public static function popunderpopup_deactivation()
	{
		// do not generate any output here
	}
	
	public static function popunderpopup_adminmenu()
	{
		if (is_admin()) 
		{
			add_options_page( __('Popunder popup', 'popunder-popup'), 
				__('Popunder popup', 'popunder-popup'), 'manage_options', POPUNDER_PLUGIN_NAME, array( 'popunderpopup_cls_intermediate', 'popunderpopup_admin' ) );
		}		
	}
	
	public static function popunderpopup_load_adminscripts() 
	{
		if( !empty( $_GET['page'] ) ) 
		{
			switch ( $_GET['page'] ) 
			{
				case 'popunder-popup':
					wp_register_script( 'popunder-adminscripts', POPUNDER_URL . 'page/setting.js', '', '', true );
					wp_enqueue_script( 'popunder-adminscripts' );
					$popunder_select_params = array(
						'popunder_delete_record'   	=> __( 'Do you want to delete this record?', 'popunder-select', 'popunder-popup' ),
						'popunder_session_option'   => __( 'Select session option for popunder popup.', 'popunder-select', 'popunder-popup' ),
						'popunder_add_url'   		=> __( 'Enter popunder popup url. url must start with either http or https.', 'popunder-select', 'popunder-popup' ),
					);
					wp_localize_script( 'popunder-adminscripts', 'popunder_adminscripts', $popunder_select_params );
					break;
			}
		}
	}
}

function popunderpopup_add_javascript_files() 
{
	if (!is_admin())
	{
		wp_enqueue_script('jquery');
	}
}
?>