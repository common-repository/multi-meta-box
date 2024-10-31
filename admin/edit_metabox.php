<?php
	/**
    * Author: Agile Infoways
    * Author URI: http://agileinfoways.com
    */
    if(!defined('ABSPATH'))exit;

    $metaboxItem = $wpdb->get_results($wpdb->prepare("SELECT * FROM ".$table_multi_meta_table." where id = %d",sanitize_text_field($_REQUEST['id'])));
    
 	$list=$wpdb->get_results("SELECT * FROM wp_multi_metabox_fields where multi_multi_meta_table_id=".$metaboxItem[0]->id,ARRAY_A);
	if($_REQUEST['action']=='add'){
        $title = 'Add New';
        $label = 'Add';
    }else{
        $title = 'Edit';
        $label = 'Update';
    }
	$fieldtypeList = $wpdb->get_results("SELECT * FROM ".$table_metabox_metabox);
	$textfieldList = $wpdb->get_results("SELECT * FROM wp_multi_metabox_fieldtype WHERE metabox_field_type_id=1");
	$args = array(
		'public'   => true,
		'_builtin' => false,
	);
	// Getting Custom Post type.
	?>
    <div style="overflow: hidden;" id="wpbody-content" aria-label="Main content" tabindex="0">
	    <div class="wrap">
	    	<h2><?php echo $title;?> Metabox</h1>
	    	<form name="post" action="<?php echo home_url().'/wp-admin/admin.php?page=multi_metabox_listing' ?>" method="post" id="post">
	    		<input type="hidden" value="" id="defaultHtml">
	    		<input type="hidden" name="id" value="<?php echo $metaboxItem[0]->id;?>">
	    		<input type="hidden" name="delete_id" id="delete_id" value="">
	    		<div id="poststuff">
                	<div id="post-body" class="metabox-holder columns-2">
                		<div id="post-body-content">
					        <label for="metabox_field_label">Meta Box Label:</label>
					        <div id="titlediv">
			                	<div id="titlewrap" class="boxclass">
					        		<input name="metabox_field_label" value="<?php echo $metaboxItem[0]->metabox_title; ?>" id="metabox_field_label" type="text" class="textbox requiredbox length">
					        	</div>
					    	</div>
					    	<label for="metabox_field_post_type">Meta Field Post Type:</label><br/>
						        <?php $field_post_type= explode(",",$metaboxItem[0]->metabox_type);
						        if(count($field_post_type)>=1){ ?>
							        <fieldset id="checkArray">
										<input type="checkbox" <?php if(in_array('post', $field_post_type)){echo 'checked="checked"';}?> name="metabox_field_post_type[]" value="post"><b>Posts</b>&nbsp;&nbsp;
										<input type="checkbox" <?php if(in_array('page', $field_post_type)){echo 'checked="checked"';}?> name="metabox_field_post_type[]" value="page"><b>Pages</b>&nbsp;&nbsp;
									</fieldset>
									<?php }else{ ?>
									<fieldset id="checkArray">
										<input type="checkbox" name="metabox_field_post_type[]" value="post"><b>Posts</b>&nbsp;&nbsp;
										<input type="checkbox" name="metabox_field_post_type[]" value="page"><b>Pages</b>&nbsp;&nbsp;
										
									</fieldset>
								<?php } ?>
								<div>
									<label for="metabox_field_status">Status:</label><br/>
							       	<select name="metabox_field_status" id="metabox_field_status">
							       		<?php if($_REQUEST['action'] == 'add'){ ?>
							        		<option value="1" selected>Available</option>
							        		<option value="0">Un Available</option>
							        	<?php } else { ?>
							        		<option value="1" <?php if($metaboxItem[0]->metabox_field_status==1){echo 'selected="selected"';}?>>Available</option>
							        		<option value="0" <?php if($metaboxItem[0]->metabox_field_status==0){echo 'selected="selected"';}?>>Un Available</option>
							        	<?php } ?>
							    	</select>
							    </div><br/>
						    <div id="addmetabox" class="boxclass">
							 	<input type="button" value="Add Meta Field" name="add_multi_meta_field" onclick="add_metabox_field()" class="addmeta button">
							</div>
							<br/>
							<?php if($title=='Edit'){
								echo '<div id="edit"> ';
								$count= count($list);
								for($i=0; $i<count($list); $i++){ $j=$i+1; ?>
									<div class="multi_meta_field1" id="<?php echo $list[$i][id];?>" style="display: block; border: 1px solid; margin-bottom:20px;" >
										<input type="hidden" name="field_id[]" value="<?php echo $list[$i][id];?>">
									    <div style="margin: 5px 5px 0 5px;">
										    <div style="margin:5px;">
										        <label for="my_multi_meta_box_post_type">Field Type:</label><br/>
										        <select name='my_multi_meta_box_select[]' id="<?php echo 'my_multi_meta_box_select_'.$j; ?>" onchange="field_type_change(this)" class="selectclass">
										        	<option value="" >Select Option</option>
										            <?php foreach( $fieldtypeList as $fieldtype ): ?>
										            	<option value="<?php  echo esc_attr($fieldtype->metabox_field_type); ?>" <?php if($list[$i][metabox_field_type]==$fieldtype->metabox_field_type){echo 'selected="selected"';}?>  ><?php  echo $fieldtype->metabox_field_title; ?></option>
										            <?php endforeach; ?>
										        </select>
									        </div>
									        <div id="<?php echo 'textbox_display_'.$j; ?>" style="display: none; margin:5px;">
								        		<label for="metabox_field_field_type">Meta Field Type:</label><br/>
								        		<select name="metabox_field_field_type1[]" id="<?php echo 'metabox_field_field_type_'.$j; ?>">
								        			<?php foreach ($textfieldList as $texttype): ?>
								        				<option value="<?php echo esc_attr($texttype->metabox_field_fieldtype); ?>" <?php if($list[$i][metabox_field_field_type]==$texttype->metabox_field_fieldtype){echo 'selected="selected"';}?> > <?php echo $texttype->metabox_field_fieldvalue;?></option>
								        			<?php endforeach; ?>
								        		</select>     
									        </div>
									        <div style="margin:5px;">
										        <label for="metabox_field_id">Meta Field Title:</label>
										        <div id="titlediv">
								                	<div id="titlewrap" class="boxclass">
										        		<input name="metabox_field_id[]" value="<?php echo esc_attr($list[$i][metabox_field_title]); ?>" id="<?php echo 'metabox_field_id_'.$j;?>" type="text" class="textbox length1">
										        	</div>
										    	</div>
										    </div>
											<div id="<?php echo 'checkbox_radio_display_'.$j;?>" style="display: none; margin:5px;">
									        <label for="metabox_field_value">Meta Field Value:</label>
									        	<input name="metabox_field_value[]" value="<?php echo esc_attr($list[$i][metabox_field_value]); ?>" id="<?php echo 'metabox_field_value_'.$j; ?>" type="text" class="textbox length">
									        	<p style="color:red">Note: Please Put Value with Comma Separated Ex: Gender Male,Female</p>
									        </div>
									        <div style="margin:5px;">
									        <label for="metabox_field_required">Meta Field Required:</label><br/>
									        <select name="metabox_field_required[]" onchange="metabox_field_change(this)" id="<?php echo 'metabox_field_required_'.$j; ?>">
									        	<option value="1" <?php if($list[$i][metabox_field_required]==1){echo 'selected="selected"';}?>>True</option>
									        	<option value="0" <?php if($list[$i][metabox_field_required]==0){echo 'selected="selected"';}?>>False</option>
									    	</select>
									       	</div>
									       	<div id="<?php echo 'textbox_textarea_display_'.$j;?>" style="display: none; margin:5px;">
										        <label for="metabox_field_placeholder">Meta Field Place Holder:</label>
										        <input name="metabox_field_placeholder[]" value="<?php echo esc_attr($list[$i][metabox_field_placeholder]); ?>" id="<?php echo 'metabox_field_placeholder_'.$j; ?> " type="text" class="textbox length">
										        <div id="<?php echo 'minlength_maxlength_'.$j;?>">
											        <label for="metabox_field_minlength">Meta Field Min Length:</label>
											        <input name="metabox_field_minlength[]" value="<?php if($list[$i][metabox_field_minlength]!=0)echo $list[$i][metabox_field_minlength]; ?>"  onkeypress="return isNumber(event)" maxlength="3" id="<?php echo 'metabox_field_minlength_'.$j;?>" type="text" class="textbox length">
											        <label for="metabox_field_maxlength">Meta Field Max Length:</label>
											        <input name="metabox_field_maxlength[]" value="<?php if($list[$i][metabox_field_maxlength]!=0)echo $list[$i][metabox_field_maxlength]; ?>"  onkeypress="return isNumber(event)" maxlength="3" id="<?php echo 'metabox_field_maxlength_'.$j;?> " type="text" class="textbox length">
										        </div>
									        </div>
									        <div style="margin:5px 0 5px 5px;">
									        	<input class="button" type="button" onclick="delete_this(this)" id="<?php echo 'cancel_'.$list[$i][id]; ?>" value="Cancel" />
									        </div>
								        </div>
					        		</div>	
			        				<?php } } ?>
		        				<!-- For edit time new div start-->
			        			<div class="multi_meta_field_add" style="display: none; border: 1px solid; margin-bottom:20px;" >
									<div style="margin: 5px 5px 0 5px;">
										<div  style="margin:5px;">
									        <label for="my_multi_meta_box_post_type">Field Type:</label><br/>
									        <select name='my_multi_meta_box_select_add[]' id='my_multi_meta_box_select' onchange="field_type_change(this)" class="selectclass">
									        	<option value="" >Select Option</option>
									            <?php foreach( $fieldtypeList as $fieldtype ): ?>
									            	<option value="<?php  echo esc_attr($fieldtype->metabox_field_type); ?>" <?php if($metaboxItem[0]->metabox_field_type==$fieldtype->metabox_field_type){echo 'selected="selected"';}?>  ><?php  echo $fieldtype->metabox_field_title; ?></option>
									            <?php endforeach; ?>
									        </select>
								    	</div>
								        <div id="textbox_display" style="display: none; margin:5px;">
							        		<label for="metabox_field_field_type">Meta Field Type:</label><br/>
							        		<select name="metabox_field_field_type_add[]" id="metabox_field_field_type">
							        			<?php foreach ($textfieldList as $texttype): ?>
							        				<option value="<?php echo esc_attr($texttype->metabox_field_fieldtype); ?>" <?php if($metaboxItem[0]->metabox_field_field_type==$texttype->metabox_field_fieldtype){echo 'selected="selected"';}?>><?php echo $texttype->metabox_field_fieldvalue;?></option>
							        			<?php endforeach; ?>
							        		</select>
								        </div>
								        <div style="margin:5px;">
									        <label for="metabox_field_id">Meta Field Title:</label>
									        <div id="titlediv">
							                	<div id="titlewrap" class="boxclass">
									        		<input name="metabox_field_id_add[]" value="<?php echo esc_attr($metaboxItem[0]->metabox_field_title); ?>" id="metabox_field_id" type="text" class="textbox length1">
									        	</div>
									    	</div>
									    </div>
										<div id="checkbox_radio_display" style="display: none; margin:5px;">
								        	<label for="metabox_field_value">Meta Field Value:</label>
								        	<input name="metabox_field_value_add[]" value="<?php echo esc_attr($metaboxItem[0]->metabox_field_value); ?>" id="metabox_field_value" type="text" class="textbox length">
								        	<p style="color:red">Note: Please Put Value with Comma Separated Ex: Gender Male,Female</p>
								        </div>
								        <div style="margin:5px;" >
									        <label for="metabox_field_required">Meta Field Required: </label><br/>
									        <select name="metabox_field_required_add[]" onchange="metabox_field_change(this)" id="metabox_field_required">
									        	<option value="1" <?php if($metaboxItem[0]->metabox_field_required==1){echo 'selected="selected"';}?>>True</option>
									        	<option value="0" <?php if($metaboxItem[0]->metabox_field_required==0){echo 'selected="selected"';}?>>False</option>
									    	</select>
									    </div>

								       	<div id="textbox_textarea_display" style="display: none; margin:5px;">
									        <label for="metabox_field_placeholder">Meta Field Place Holder:</label>
									        <input name="metabox_field_placeholder_add[]" value="<?php echo esc_attr($metaboxItem[0]->metabox_field_placeholder); ?>" id="metabox_field_placeholder" type="text" class="textbox length">
									        <div id="minlength_maxlength">
										        <label for="metabox_field_minlength">Meta Field Min Length:</label>
										        <input name="metabox_field_minlength_add[]" value="<?php if($metaboxItem[0]->metabox_field_minlength!=0)echo $metaboxItem[0]->metabox_field_minlength; ?>"  onkeypress="return isNumber(event)" maxlength="3" id="metabox_field_minlength" type="text" class="textbox length">
										        <label for="metabox_field_maxlength">Meta Field Max Length:</label>
										        <input name="metabox_field_maxlength_add[]" value="<?php if($metaboxItem[0]->metabox_field_maxlength!=0)echo $metaboxItem[0]->metabox_field_maxlength; ?>"  onkeypress="return isNumber(event)" maxlength="3" id="metabox_field_maxlength" type="text" class="textbox length">
									        </div>
								        </div>
								        <div style="margin:5px 0 5px 5px;">
								        	<input class="button" type="button" onclick="remove_this(this)" id="cancel" value="Cancel" />
								        </div>
							    	</div>
			        			</div>
				        		<!-- For edit time new div end-->
				        	</div> 
			        	<?php if($title=='Edit') echo '</div>'; ?>			   			
			        	<div id="postbox-container-1" class="postbox-container">
	                        <div id="side-sortables" class="meta-box-sortables ui-sortable">
	                            <div id="submitdiv" class="postbox ">
	                                <h3 class="hndle"><span>Publish</span></h3>
	                                <div class="inside">
	                                    <div class="submitbox" id="submitpost">
	                                        <div id="major-publishing-actions">
	                                            <div id="publishing-action">
	                                                <span class="spinner"></span>
	                                                <input name="original_publish" id="original_publish" value="<?php echo $label;?>" type="hidden">
	                                                <input name="publish" id="publish" class="button button-primary button-large" value="<?php echo $label;?>" accesskey="p" type="button">
	                                            </div>
	                                            <div class="clear"></div>
	                                        </div>
	                                    </div>
	                                </div>
	                            </div>
	                        </div>
	                    </div>
	                </div>
	                <br class="clear">
	            </div><!-- /poststuff -->
        	</form>
 			<div class="clear"></div>
		</div>
	<div class="clear"></div>
