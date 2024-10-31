<?php
    /**
    * Author: Agile Infoways
    * Author URI: http://agileinfoways.com
    */
    if(!defined('ABSPATH'))exit;

    //This function use for display menu.   
    function mmb_multi_metabox_menu(){
        $my_plugins_page = add_menu_page('Wp Multiple Meta Box', 'Wp Multiple Meta Box', 'manage_options', 'multi_metabox_listing', 'mmb_multi_metabox_listing');
        add_submenu_page('multi_metabox_listing', 'Wp Multiple Meta Box', 'Wp Multiple Meta Box', 'manage_options', 'multi_metabox_listing','mmb_multi_metabox_listing');
        add_submenu_page('multi_metabox_listing', 'Help',              'Help',              'manage_options', 'multi_help',           'mmb_multi_help'           );
    }

    //This Function will add script/css for admin section
    function mmb_multi_metabox_adminscripts(){
        wp_enqueue_script('metabox_script', plugins_url('/js/multi_metabox_js.js' , __FILE__ ));
        wp_register_style('metabox_css',    plugins_url('/css/metabox_css.css', __FILE__ ));
        wp_enqueue_style('metabox_css');
        wp_register_style('multiple_meta_box_backend_css',    plugins_url('css/backend.css', __FILE__ ));    
        wp_enqueue_style('multiple_meta_box_backend_css');
    }
    //This is for pulgin page load js.
    if($_GET['page']=="multi_metabox_listing"){
        add_action( 'init', 'mmb_multi_metabox_adminscripts' );
    }

    //This function called when plugin installed
    function mmb_multi_metabox_install(){
        //Instal time check if another plugin isactivated or not.
        if ( is_plugin_active( 'wp_custom_meta_box/custom_meta_box.php' ) ) {
            echo 'Please Deactivate Wp Custom metabox plugin to activate this plugin'; 
            exit;
        }
        global $wpdb;
        global $table_metabox_metabox;
        global $table_metabox_fields;
        global $table_metabox_fieldtype;
        global $table_multi_meta_table;

        $sql_exist = "DROP TABLE IF EXISTS $table_metabox_metabox";
        require_once(ABSPATH .'wp-admin/includes/upgrade.php');
        dbDelta($sql_exist);

        $sql = "CREATE TABLE  $table_metabox_metabox (
        id mediumint(9) NOT NULL AUTO_INCREMENT,
        metabox_field_type VARCHAR(150),
        metabox_field_title VARCHAR(150),
        metabox_field_created_date  datetime,
        UNIQUE KEY id (id)
        );";
        require_once(ABSPATH .'wp-admin/includes/upgrade.php');
        dbDelta($sql);

        $sql_exist = "DROP TABLE IF EXISTS $table_multi_meta_table";
        require_once(ABSPATH .'wp-admin/includes/upgrade.php');
        dbDelta($sql_exist);

        $sql = "CREATE TABLE  $table_multi_meta_table (
        id mediumint(9) NOT NULL AUTO_INCREMENT,
        metabox_type VARCHAR(150),
        metabox_title VARCHAR(150),
        metabox_field_status  BOOLEAN,
        metabox_field_created_date  datetime,
        UNIQUE KEY id (id)
        );";
        require_once(ABSPATH .'wp-admin/includes/upgrade.php');
        dbDelta($sql);

        $sql_exist = "DROP TABLE IF EXISTS $table_metabox_fields";
        require_once(ABSPATH .'wp-admin/includes/upgrade.php');
        dbDelta($sql_exist);

        $sql = "CREATE TABLE  $table_metabox_fields (
        id mediumint(9) NOT NULL AUTO_INCREMENT,
        multi_multi_meta_table_id mediumint(9),
        metabox_field_type VARCHAR(150),
        metabox_field_field_type VARCHAR(150),
        metabox_field_title VARCHAR(150),
        metabox_field_value VARCHAR(150),
        metabox_field_required BOOLEAN,
        metabox_field_placeholder VARCHAR(50),
        metabox_field_minlength int,
        metabox_field_maxlength int,
        metabox_field_created_date  datetime,
        UNIQUE KEY id (id)
        );";
        require_once(ABSPATH .'wp-admin/includes/upgrade.php');
        dbDelta($sql);

        $sql_exist = "DROP TABLE IF EXISTS $table_metabox_fieldtype";
        require_once(ABSPATH .'wp-admin/includes/upgrade.php');
        dbDelta($sql_exist);

        $sql = "CREATE TABLE  $table_metabox_fieldtype (
        id mediumint(9) NOT NULL AUTO_INCREMENT,
        metabox_field_type_id mediumint(9),
        metabox_field_fieldtype VARCHAR(150),
        metabox_field_fieldvalue VARCHAR(150),
        metabox_field_created_date  datetime,
        UNIQUE KEY id (id)
        );";
        require_once(ABSPATH .'wp-admin/includes/upgrade.php');
        dbDelta($sql);

        // insert data in metabox_meatbox table.
        $format = array("%s", "%s", "%s");
        $fields = array(
            "metabox_field_type"          => "textbox", 
            "metabox_field_title"         => "Text Box",
            "metabox_field_created_date"  => date("Y-m-d h:i:s", strtotime("now"))
            );
        mmb_multi_meta_insert_data($table_metabox_metabox,$fields,$format);
        $fields = array(
            "metabox_field_type"          => "textarea", 
            "metabox_field_title"         => "Text Area",
            "metabox_field_created_date"  => date("Y-m-d h:i:s", strtotime("now"))
            );
        mmb_multi_meta_insert_data($table_metabox_metabox,$fields,$format);
        $fields = array(
            "metabox_field_type"          => "dropdown", 
            "metabox_field_title"         => "Drop Down",
            "metabox_field_created_date"  => date("Y-m-d h:i:s", strtotime("now"))
            );
        mmb_multi_meta_insert_data($table_metabox_metabox,$fields,$format);
        $fields = array(
            "metabox_field_type"          => "checkbox", 
            "metabox_field_title"         => "Check Box",
            "metabox_field_created_date"  => date("Y-m-d h:i:s", strtotime("now"))
            );
        mmb_multi_meta_insert_data($table_metabox_metabox,$fields,$format);
        $fields = array(
            "metabox_field_type"          => "radio",
            "metabox_field_title"         => "Radio Button",
            "metabox_field_created_date"  => date("Y-m-d h:i:s", strtotime("now"))
            );
        mmb_multi_meta_insert_data($table_metabox_metabox,$fields,$format);
        
        //insert data in metabox field type.
        $format = array("%d","%s","%s","%s");
        $fields = array( 
            "metabox_field_type_id"      => '1',
            "metabox_field_fieldtype"    => "text",
            "metabox_field_fieldvalue"   => "Text",
            "metabox_field_created_date" => date("Y-m-d h:i:s", strtotime("now")),
            );
        mmb_multi_meta_insert_data($table_metabox_fieldtype,$fields,$format);
        $fields = array( 
            "metabox_field_type_id"      => '1',
            "metabox_field_fieldtype"    => "email",
            "metabox_field_fieldvalue"   => "Email",
            "metabox_field_created_date" => date("Y-m-d h:i:s", strtotime("now")),
            );
        mmb_multi_meta_insert_data($table_metabox_fieldtype,$fields,$format);
        $fields = array( 
            "metabox_field_type_id"      => '1',
            "metabox_field_fieldtype"    => "password",
            "metabox_field_fieldvalue"   => "Password",
            "metabox_field_created_date" => date("Y-m-d h:i:s", strtotime("now")),
            );
        mmb_multi_meta_insert_data($table_metabox_fieldtype,$fields,$format);
        $fields = array( 
            "metabox_field_type_id"      => '1',
            "metabox_field_fieldtype"    => "file",
            "metabox_field_fieldvalue"   => "File",
            "metabox_field_created_date" => date("Y-m-d h:i:s", strtotime("now")),
            );
        mmb_multi_meta_insert_data($table_metabox_fieldtype,$fields,$format);
        $fields = array( 
            "metabox_field_type_id"      => '1',
            "metabox_field_fieldtype"    => "number",
            "metabox_field_fieldvalue"   => "Number",
            "metabox_field_created_date" => date("Y-m-d h:i:s", strtotime("now")),
            );
        mmb_multi_meta_insert_data($table_metabox_fieldtype,$fields,$format);
    }

    //This function called when plugin uninstalled.
    function mmb_multi_metabox_uninstall(){
        global $wpdb;
        global $table_metabox_fields;
        global $table_metabox_metabox;
        global $table_metabox_fieldtype;
        global $table_multi_meta_table;
        global $table_postmeta;

        $metaidList = $wpdb->get_results("SELECT id FROM ".$table_metabox_fields, ARRAY_A);
        //Delete meta box data from postmeta table.
        for($i=0; $i <count($metaidList); $i++){
            $field = 'meta_key';
            mmb_multi_meta_delete_data($table_postmeta,$field,"multiple_meta".$metaidList[$i][id], "%s");
        }
        $sql = "DROP TABLE $table_metabox_metabox";     
        require_once(ABSPATH .'wp-admin/includes/upgrade.php');
        $wpdb->query($sql); 
        $sql = "DROP TABLE $table_metabox_fields";
        require_once(ABSPATH .'wp-admin/includes/upgrade.php');
        $wpdb->query($sql);
        $sql = "DROP TABLE $table_metabox_fieldtype";
        require_once(ABSPATH .'wp-admin/includes/upgrade.php');
        $wpdb->query($sql);
        $sql = "DROP TABLE $table_multi_meta_table";
        require_once(ABSPATH .'wp-admin/includes/upgrade.php');
        $wpdb->query($sql);
    }

    //This function for database and redirct to link when menu called 
    function mmb_multi_metabox_listing(){
        global $wpdb;
        global $table_metabox_fields;
        global $table_metabox_metabox;
        global $table_multi_meta_table;
        global $table_postmeta;

        $metabox_field_value = implode(",",(array)$_POST['metabox_field_post_type']);

        if($_POST['my_meta_box_select']!='textbox'){
            $_POST['metabox_field_field_type']="";
        }

        //insert record in database
        if($_POST['original_publish']=='Add'){
            $fields = array(
                "id"                        => 'NULL',
                "metabox_type"              => sanitize_text_field($metabox_field_value),
                "metabox_title"             => sanitize_text_field($_POST['metabox_field_label']),
                "metabox_field_status"      => sanitize_text_field($_POST['metabox_field_status']), 
                "metabox_field_created_date"=> date("Y-m-d h:i:s", strtotime("now"))
                );
            $format = array("%d", "%s","%s","%s","%s",);
            mmb_multi_meta_insert_data($table_multi_meta_table,$fields,$format);
            
            $lastid = $wpdb->insert_id;
            foreach($_POST['my_multi_meta_box_select_add'] as $key=>$val){
                if($key!='0'){
                    $metabox_field_value1 = array_unique((explode(',',sanitize_text_field($_POST['metabox_field_value_add'][$key]))));
                    $metabox_field_value1 = implode(',', array_filter(array_map('trim', $metabox_field_value1 ),'strlen'));
                    $fields = array(
                        'id'                         => 'NULL', 
                        "multi_multi_meta_table_id"  => $lastid, 
                        "metabox_field_type"         => trim(sanitize_text_field($_POST['my_multi_meta_box_select_add'][$key])), 
                        "metabox_field_field_type"   => sanitize_text_field($_POST['metabox_field_field_type_add'][$key]), 
                        "metabox_field_title"        => sanitize_text_field($_POST['metabox_field_id_add'][$key]), 
                        "metabox_field_value"        => $metabox_field_value1,
                        "metabox_field_required"     => sanitize_text_field($_POST['metabox_field_required_add'][$key]),
                        "metabox_field_placeholder"  => sanitize_text_field($_POST['metabox_field_placeholder_add'][$key]),
                        "metabox_field_minlength"    => sanitize_text_field($_POST['metabox_field_minlength_add'][$key]),
                        "metabox_field_maxlength"    => sanitize_text_field($_POST['metabox_field_maxlength_add'][$key]),
                        "metabox_field_created_date" => date("Y-m-d h:i:s", strtotime("now"))
                    );
                    $format = array("%d", "%d", "%s", "%s", "%s", "%s", "%s", "%s", "%s", "%s", "%s",);
                    mmb_multi_meta_insert_data($table_metabox_fields,$fields,$format);
                }
            }
            $message            = '<span style="color:green;"><b>Inserted Successfully.</b></span>';
            $_REQUEST['action'] ='';
        }
        //update record in database
        if($_POST['original_publish'] =='Update'){
            $delete_id  = sanitize_text_field($_POST['delete_id']);
            $delete_ids = array_unique(explode(',',$delete_id));
            $field = 'id';
            for($i=0; $i<=count($delete_ids); $i++){
                mmb_multi_meta_delete_data($table_metabox_fields, $field, sanitize_text_field($delete_ids[$i]),'%d');
                mmb_multi_meta_delete_data($table_postmeta,'meta_key',"multiple_meta".sanitize_text_field($delete_ids[$i]), "%s");
            }

            $fields = array(
                "metabox_type"         => $metabox_field_value,
                "metabox_title"        => sanitize_text_field($_POST['metabox_field_label']),
                "metabox_field_status" => sanitize_text_field($_POST['metabox_field_status'])
            );
            $where = array("id" => sanitize_text_field($_POST['id']));
            mmb_multi_meta_update_data($table_multi_meta_table,$fields,$where);
            if(isset($_POST['my_multi_meta_box_select'])){
            foreach($_POST['my_multi_meta_box_select'] as $key=>$val){

                $metabox_field_value1 = array_unique((explode(',',sanitize_text_field($_POST['metabox_field_value'][$key]))));
                $metabox_field_value1 = implode(',', array_filter(array_map('trim', $metabox_field_value1 ),'strlen'));

                $fields = array(
                    "multi_multi_meta_table_id" => sanitize_text_field($_POST['id']),
                    "metabox_field_type"        => trim(sanitize_text_field($_POST['my_multi_meta_box_select'][$key])),
                    "metabox_field_field_type"  => sanitize_text_field($_POST['metabox_field_field_type1'][$key]),
                    "metabox_field_title"       => trim(sanitize_text_field($_POST['metabox_field_id'][$key])),
                    "metabox_field_value"       => $metabox_field_value1,
                    "metabox_field_required"    => sanitize_text_field($_POST['metabox_field_required'][$key]),
                    "metabox_field_placeholder" => sanitize_text_field($_POST['metabox_field_placeholder'][$key]),
                    "metabox_field_minlength"   => sanitize_text_field($_POST['metabox_field_minlength'][$key]),
                    "metabox_field_maxlength"   => sanitize_text_field($_POST['metabox_field_maxlength'][$key])
                );
                $where  = array('id' => sanitize_text_field($_POST['field_id'][$key]));
                mmb_multi_meta_update_data($table_metabox_fields, $fields,$where);
            }
            }   
            foreach($_POST['my_multi_meta_box_select_add'] as $key=>$val){
                if($key!='0'){
                    $metabox_field_value1 = array_unique((explode(',',sanitize_text_field($_POST['metabox_field_value_add'][$key]))));
                    $metabox_field_value1 = implode(',', array_filter(array_map('trim', $metabox_field_value1 ),'strlen'));

                    $fields = array(
                        "id"                          => "NULL",
                        "multi_multi_meta_table_id"   => sanitize_text_field($_POST['id']),
                        "metabox_field_type"          => trim(sanitize_text_field($_POST['my_multi_meta_box_select_add'][$key])),
                        "metabox_field_field_type"    => sanitize_text_field($_POST['metabox_field_field_type_add'][$key]),
                        "metabox_field_title"         => sanitize_text_field($_POST['metabox_field_id_add'][$key]),
                        "metabox_field_value"         => $metabox_field_value1, 
                        "metabox_field_required"      => sanitize_text_field($_POST['metabox_field_required_add'][$key]), 
                        "metabox_field_placeholder"   => sanitize_text_field($_POST['metabox_field_placeholder_add'][$key]), 
                        "metabox_field_minlength"     => sanitize_text_field($_POST['metabox_field_minlength_add'][$key]), 
                        "metabox_field_maxlength"     => sanitize_text_field($_POST['metabox_field_maxlength_add'][$key]), 
                        "metabox_field_created_date"  => date("Y-m-d h:i:s", strtotime("now"))
                    );
                    $format = array("%d", "%d", "%s", "%s", "%s", "%s", "%s", "%s", "%s", "%s", "%s");
                    mmb_multi_meta_insert_data($table_metabox_fields,$fields,$values);
                }
            }
            $message = '<span style="color:green;"><b>Updated Successfully.</b></span>';
            $_REQUEST['action'] = '';
        }
        //delete record from database
        if($_REQUEST['action']=='delete' || $_REQUEST['action2']=='delete'){
            if($_REQUEST['id']!=''){
                $list = $wpdb->get_results($wpdb->prepare("SELECT id FROM ".$table_metabox_fields." WHERE multi_multi_meta_table_id= %d",sanitize_text_field($_REQUEST['id'])), ARRAY_A);
                for($i=0; $i<count($list); $i++){
                  mmb_multi_meta_delete_data($table_metabox_fields,'id',$list[$i][id],"%d");
                  mmb_multi_meta_delete_data($table_postmeta,'meta_key',"multiple_meta".$list[$i][id], "%s");
                }
                mmb_multi_meta_delete_data($table_multi_meta_table,'id',sanitize_text_field($_REQUEST['id']), "%d");
                $message = '<span style="color:red;"><b>Deleted Successfully.</b></span>';
            }elseif(count($_REQUEST['item'])>0){                
                for($i=0; $i<count($_REQUEST['item']); $i++){
                    $list = $wpdb->get_results($wpdb->prepare("SELECT id FROM ".$table_metabox_fields." WHERE multi_multi_meta_table_id= %d",sanitize_text_field($_REQUEST['item'][$i])), ARRAY_A);
                    for($j=0; $j<=count($list); $j++){
                        mmb_multi_meta_delete_data($table_metabox_fields,'id',$list[$j][id], "%d");
                        mmb_multi_meta_delete_data($table_postmeta,'meta_key',"multiple_meta".$list[$j][id], "%s");
                    }
                }
                mmb_multi_meta_delete_data($table_multi_meta_table,'id',$_REQUEST['item'],"%d");
                $message = '<span style="color:red;"><b>Deleted Successfully.</b></span>';
            }else{
                $message = '<span style="color:red;"><b>No Data Found.</b></span>';
            }
            $_REQUEST['action'] ='';
        }
        //Page Redirction
        if($_REQUEST['action'] =='add' || $_REQUEST['action'] =='edit'){
            include('admin/edit_metabox.php');
        }else{
            include('admin/multi_metabox_inventory_details.php');
        }
    }

    function mmb_multi_help(){
        include('admin/help.php');
    }
    /**
    * Adds a box to the main column on the Post and Page edit screens.
    */
    function mmb_custom_multi_meta_boxes($post){
        global $wpdb;
        global $table_metabox_fields;
        global $table_metabox_metabox;
        global $table_multi_meta_table;

        $fieldtypeList = $wpdb->get_results("SELECT * FROM ".$table_multi_meta_table." WHERE metabox_field_status='1'");
        foreach($fieldtypeList as $fieldtype):
            $screens =explode(',',$fieldtype->metabox_type);
            foreach ( $screens as $screen ):
                add_meta_box(
                    $fieldtype->id,                           // Unique ID
                    $fieldtype->metabox_title,                // Box title
                    'mmb_multi_render_my_multi_meta_box',     // Content callback
                    $screen,                                  // Post types
                    'normal',                                 // Section Should Be Shown
                    'low' ,                                   // Priority
                    array('id' => $fieldtype->id)             // Args
                );
            endforeach;
        endforeach;
    }
    add_action('add_meta_boxes','mmb_custom_multi_meta_boxes');

    /**
     * Prints the box content.
     * 
     * @param WP_Post $post The object for the current post/page.
     */
    function mmb_multi_render_my_multi_meta_box($post, $metabox){
        global $wpdb;
        global $table_metabox_fields;
        global $table_metabox_metabox;
        global $table_multi_meta_table;

        // Add a nonce field so we can check for it later.
        wp_nonce_field('mmb_multi_save_multi_meta_box_data', 'multi_multi_meta_box_nonce');
        $list = $wpdb->get_results("SELECT * FROM ".$table_metabox_fields." WHERE multi_multi_meta_table_id=".$metabox['args']['id']);
        echo '<table>';
        foreach($list as $display):
           if($display->multi_multi_meta_table_id==$metabox['args']['id']){
                echo '<tr>';
                    echo '<td>';
                        //Geting value useing get_post_meta() to retrieve an existing value
                        $value = get_post_meta( $post->ID, 'multiple_meta'.$display->id, true );
                        echo '<label for="multi_multi_meta_new_field">';
                        _e($display->metabox_field_title,'myplugin_textdomain');
                        echo '</label> ';
                    echo '</td>';
                    echo '<td>';
                        if($display->metabox_field_type=="textbox"){
                            if($display->metabox_field_field_type=="file"){
                                echo '<input value="'.esc_attr($value).'" type="text" '. (($display->metabox_field_minlength>0)?' minlength="'.$display->metabox_field_minlength.'"':"").' '. (($display->metabox_field_maxlength>0)?'maxlength="'.$display->metabox_field_maxlength.'"':"").' name="'.$display->id.'" id="'.$display->metabox_field_title.'" '. (($display->metabox_field_required=='1')?'required="required"':"").'   placeholder="'.$display->metabox_field_placeholder.'" size="25" style="border: 1px solid !important;" /><br/>';
                            }else{
                                echo '<input value="'.esc_attr($value).'" type="'.$display->metabox_field_field_type.'" '. (($display->metabox_field_minlength>0)?'minlength="'.$display->metabox_field_minlength.'"':"").' '. (($display->metabox_field_maxlength>0)?'maxlength="'.$display->metabox_field_maxlength.'"':"").' name="'.$display->id.'" id="'.$display->metabox_field_title.'" '. (($display->metabox_field_required=='1')?'required="required"':"").'   placeholder="'.$display->metabox_field_placeholder.'" size="25" style="border: 1px solid !important;" /><br/>';
                            }
                        }if($display->metabox_field_type=="textarea"){
                            echo '<textarea name="'.$display->id.'" id="'.$display->metabox_field_title.'" '. (($display->metabox_field_required='1')?'required="required"':"").'   placeholder="'.$display->metabox_field_placeholder.'" style="border: 1px solid !important;">'.esc_attr( $value ).'</textarea></br>' ;
                        }if($display->metabox_field_type=="dropdown"){
                            $option_value= explode(',',$display->metabox_field_value);
                            echo '<select name="'.$display->id.'" id="'.$display->metabox_field_title.'" '.(($display->metabox_field_required='1')?'required="required"':"").'> ';
                            echo '<option value="">Select</option>';
                            foreach($option_value as $optionvalue):
                                if(trim($optionvalue)!=""){
                                    ?><option value="<?php  echo trim($optionvalue); ?>" <?php if(trim($optionvalue)==$value){?>selected="selected"<?php } ?> ><?php echo trim($optionvalue); ?></option><?php
                                }
                            endforeach;
                            echo '</select>';
                        }if($display->metabox_field_type=="checkbox"){
                            $option_value= explode(',',$display->metabox_field_value);
                            foreach($option_value as $optionvalue):
                                if(trim($optionvalue)!=""){
                                    ?><input type="<?php echo $display->metabox_field_type; ?>" id="<?php echo $display->metabox_field_title; ?>" name="<?php echo $display->id.'[]'; ?>" value="<?php echo trim($optionvalue); ?>" <?php if(in_array(trim($optionvalue),explode(',',$value))){?>checked="checked"<?php } ?> ><?php echo trim($optionvalue).' ';
                                }
                            endforeach;
                        }if($display->metabox_field_type=="radio"){
                            $option_value= explode(',',$display->metabox_field_value);
                            foreach($option_value as $optionvalue):
                            if(trim($optionvalue)!=""){
                                ?><input type="<?php echo $display->metabox_field_type; ?>" id="<?php echo $display->metabox_field_title; ?>" name="<?php echo $display->id; ?>" value="<?php echo trim($optionvalue); ?>" <?php if(trim($optionvalue)==$value){?>checked="checked"<?php } ?> ><?php echo trim($optionvalue).' ';
                            }
                            endforeach;
                        }
                    echo '</td>';
                echo '</tr>';
            }
        endforeach;
        echo '</table>';
    }
    
    /**
     * When the post is saved, saves our custom data.
     *
     * @param int $post_id The ID of the post being saved.
     */
    function mmb_multi_save_multi_meta_box_data($post_id){
        global $wpdb;
        global $table_metabox_fields;
        global $table_metabox_metabox;

        /*
         * We need to verify this came from our screen and with proper authorization,
         * because the save_post action can be triggered at other times.
         */
        // Check if our nonce is set.
        if (!isset($_POST['multi_multi_meta_box_nonce'])){
            return;
        }
        // Verify that the nonce is valid.
        if (!wp_verify_nonce($_POST['multi_multi_meta_box_nonce'], 'mmb_multi_save_multi_meta_box_data')){
            return;
        }
        // If this is an autosave, our form has not been submitted, so we don't want to do anything.
        if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE){
            return;
        }
        // Check the user's permissions.
        if(isset($_POST['post_type']) && 'page' == $_POST['post_type']){
            if (!current_user_can('edit_page', $post_id)){
                return;
            }
        }else{
            if (!current_user_can('edit_post', $post_id)){
                return;
            }
        }
        
        //Save and Update Data.
        $fieldtypeList = $wpdb->get_results("SELECT * FROM ".$table_metabox_fields);
        foreach( $fieldtypeList as $fieldtype ):
            //Check if checkbox set multivalue
            if($fieldtype->metabox_field_type=='checkbox'){
                foreach($_POST[$fieldtype->id] as $check) {
                    $my_value[]=$check;
                }
                $my_data  = implode(',', $my_value);
                $my_value = array();
            }else{
                $my_data  = sanitize_text_field($_POST[$fieldtype->id]);
            }
            // Update the meta field in the database.
            update_post_meta($post_id,'multiple_meta'.$fieldtype->id,$my_data);
        endforeach;
    }
    add_action('save_post','mmb_multi_save_multi_meta_box_data');

    //Display saved meta box on front ens side.
    function mmb_multi_multi_meta_display_the_content($content){
        global $wpdb;
        global $table_metabox_fields;
        global $table_metabox_metabox;
        global $table_multi_meta_table;

        if(is_page()){
            $post = 'page';
        }else{
            $post = 'post';
        }
        $data .= $content;
        
        $fieldtypeList = $wpdb->get_results("SELECT * FROM ".$table_multi_meta_table." WHERE metabox_field_status='1' AND metabox_type LIKE '%".$post."%' ",ARRAY_A);
        $count         = count($fieldtypeList);
        for($i=0; $i<$count; $i++){
            $data      .= '<div id="multi_metabox_id_'.$i.'" class="multi_metabox"  >';
            $fieldList  = $wpdb->get_results("SELECT * FROM ".$table_metabox_fields." WHERE multi_multi_meta_table_id=".$fieldtypeList[$i]['id'],ARRAY_A);
            $fieldcount = count($fieldList);
            
            if($fieldcount>=1){
                $data .= '<table class="multi_metabox_table">';
                for($j=0; $j<$fieldcount; $j++){
                    $should_hide_content = get_post_meta(get_the_ID(),'multiple_meta'.$fieldList[$j]['id'],true);
                    if($fieldList[$i]['metabox_field_field_type']=='file' && $should_hide_content!=""){
                        if ($j==0) {
                            $data .= '<tr><th colspan="2"><h2>'.$fieldtypeList[$i]['metabox_title'].'</h2></th></tr> ';
                        }
                        $data .='<a href="'.esc_attr($should_hide_content).'" target="_blank">'.$fieldList[$j]['metabox_field_title'].'</a> ';
                    }else if($should_hide_content!="") {
                        if($j==0){
                            $data .= '<tr><th colspan="2"><h2>'.$fieldtypeList[$i]['metabox_title'].'</h2></th></tr>';
                        }
                        if(esc_attr($fieldList[$j]['metabox_field_field_type'])=='password'){
                            $passlength = strlen(esc_attr($should_hide_content));
                            $data .= '<tr><td style="width:30%;"><label class="multi_metabox_label"><b>'.esc_attr($fieldList[$j]['metabox_field_title']).'</b> </label></td><td><span class="multi_metabox_value"></td></tr>';
                            for($k=0; $k<$passlength; $k++){
                                $data .='*';
                            }
                            $data .= '</span>';
                        }else if(esc_attr($fieldList[$j]['metabox_field_field_type'])=='email'){
                            $data .= '<tr><td style="width:30%;"><label class="multi_metabox_label"><b>'.esc_attr($fieldList[$j]['metabox_field_title']).'</b> </label></td><td><span class="multi_metabox_value"><a href=mailto:'.esc_attr($should_hide_content).'<a>'.esc_attr($should_hide_content).'</a></span></td></tr>';
                        }else{
                            $data .= '<tr><td style="width:30%;"><label class="multi_metabox_label"><b>'.esc_attr($fieldList[$j]['metabox_field_title']).'</b> </label></td><td><span class="multi_metabox_value" >  '.esc_attr($should_hide_content) .'</span></td></tr>';
                        }
                    }
                    if($j!=$fieldcount-1){
                        $data .= '<br/>';
                    }
                }
                $data .= '</table>';
            }
            $data .= '</div>';
        }
        return $data;
    }
    add_filter('the_content','mmb_multi_multi_meta_display_the_content');
?>