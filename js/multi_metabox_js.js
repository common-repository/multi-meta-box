/**
* Author: Agile Infoways
* Author URI: http://agileinfoways.com
*/
    //Add meta field when clicked on button and generate dynamic id.   
    function add_metabox_field(){

        var length =jQuery('.multi_meta_field').length + jQuery('.multi_meta_field1').length+1;
        var htmlCode = '<div class="multi_meta_field" id="multi_meta_field" style="border: 1px solid; margin-bottom:20px;">' + jQuery('#defaultHtml').val() + '</div>';

        jQuery('#post-body-content').append(htmlCode);
        jQuery('#multi_meta_field').attr('id', 'multi_meta_field_'+length);
        jQuery('#multi_meta_field_'+length+' '+'#dropdown_display').attr('id', 'dropdown_display_'+length);
        jQuery('#multi_meta_field_'+length+' '+'#cancel').attr('id', 'cancel_'+length);
        jQuery('#multi_meta_field_'+length+' '+'#checkbox_radio_display').attr('id', 'checkbox_radio_display_'+length);
        jQuery('#multi_meta_field_'+length+' '+'#textbox_display').attr('id', 'textbox_display_'+length);
        jQuery('#multi_meta_field_'+length+' '+'#textbox_textarea_display').attr('id', 'textbox_textarea_display_'+length);
        jQuery('#multi_meta_field_'+length+' '+'#checkbox_radio_display').attr('id', 'checkbox_radio_display_'+length);
        jQuery('#multi_meta_field_'+length+' '+"#minlength_maxlength").attr('id', 'minlength_maxlength_'+length);
        jQuery('#multi_meta_field_'+length+' '+'#checkbox_radio_display'+length+' '+'#minlength_maxlength').attr('id', 'checkbox_radio_display_'+length);
        jQuery('#multi_meta_field_'+length+' '+'#my_multi_meta_box_select').attr('id', 'my_multi_meta_box_select_'+length);
        jQuery('#multi_meta_field_'+length+' '+'#titlewrap'+' '+'#metabox_field_id').attr('id', 'metabox_field_id_'+length);
        jQuery('#multi_meta_field_'+length+' '+'#metabox_field_required').attr('id', 'metabox_field_required_'+length);
        jQuery('#multi_meta_field_'+length+' '+'#metabox_field_status').attr('id', 'metabox_field_status_'+length);
        jQuery('#multi_meta_field_'+length+' '+'#textbox_display_'+length+' '+'#metabox_field_field_type').attr('id', 'metabox_field_field_type_'+length);
        jQuery('#multi_meta_field_'+length+' '+'#dropdown_display_'+length+' '+'#metabox_field_value').attr('id', 'metabox_field_value_'+length);
        jQuery('#multi_meta_field_'+length+' '+'#checkbox_radio_display_'+length+' '+'#metabox_field_value').attr('id', 'metabox_field_value_'+length);
        jQuery('#multi_meta_field_'+length+' '+'#textbox_textarea_display_'+length+' '+'#metabox_field_placeholder').attr('id', 'metabox_field_placeholder_'+length);
        jQuery('#multi_meta_field_'+length+' '+'#textbox_textarea_display_'+length+' '+'#minlength_maxlength_'+length+' '+'#metabox_field_maxlength').attr('id', 'metabox_field_maxlength_'+length);
        jQuery('#multi_meta_field_'+length+' '+'#textbox_textarea_display_'+length+' '+'#minlength_maxlength_'+length+' '+'#metabox_field_minlength').attr('id', 'metabox_field_minlength_'+length);
        jQuery('#multi_meta_field_'+length).find('input[type="text"]').focus();   
    }

    jQuery( document ).ready(function(){
        var htmlCode = jQuery('#defaultHtml').val( jQuery('.multi_meta_field_add:eq(0)').html());
    
        //for display textbox textarea section in edit mode.
        var count = jQuery('.multi_meta_field1').length;
        for (var id = 1; id <= count; id++) {
            jQuery("#textbox_display_"+id).css('display','none');
            jQuery("#dropdown_display_"+id).css('display','none');
            jQuery("#textbox_textarea_display_"+id).css('display','none');
            jQuery("#checkbox_radio_display_"+id).css('display','none');
            if(jQuery('#my_multi_meta_box_select_'+id).val()=='textbox'){
                jQuery("#textbox_display_"+id).css('display','block');
                jQuery("#textbox_textarea_display_"+id).css('display','block');
                jQuery("#minlength_maxlength_"+id).css('display','block');
            }if(jQuery('#my_multi_meta_box_select_'+id).val()=='checkbox' || jQuery('#my_multi_meta_box_select_'+id).val()=='radio' || jQuery('#my_multi_meta_box_select_'+id).val()=='dropdown'){
               jQuery("#checkbox_radio_display_"+id).css('display','block');
            }if(jQuery('#my_multi_meta_box_select_'+id).val()=='textarea'){
                jQuery("#textbox_textarea_display_"+id).css('display','block')
                jQuery("#minlength_maxlength_"+id).css('display','none');
            }
        }
    });

    //Change evemnt according to selected field type
    function field_type_change(index){
        var selected_value = index.value;
        var index          = index.id.split('_');
        var id             = index[index.length - 1];
        
        jQuery("#textbox_display_"+id).css('display','none');
        jQuery("#dropdown_display_"+id).css('display','none');
        jQuery("#textbox_textarea_display_"+id).css('display','none');
        jQuery("#checkbox_radio_display_"+id).css('display','none');
        if(selected_value=="textbox"){
            jQuery("#textbox_display_"+id).css('display','block');
            jQuery("#textbox_textarea_display_"+id).css('display','block');
            jQuery("#minlength_maxlength_"+id).css('display','block');
        }if(selected_value=="textarea"){
            jQuery("#minlength_maxlength_"+id).css('display','none');
            jQuery("#textbox_textarea_display_"+id).css('display','block');
        }if(selected_value=="checkbox" || selected_value=="radio" || selected_value=="dropdown"){  //checkbox_radio_display
            jQuery("#checkbox_radio_display_"+id).css('display','block');   
        }
    }

    var myElem = document.getElementById('edit');
    if (myElem != null) {
        jQuery('.multi_meta_field1').css('display','block');
    }
    
    function metabox_field_change(index){
        var selected_value = index.value;
        var index          = index.id.split('_');
        var id             = index[index.length - 1];
    }
    //Hide this div
    function remove_this(index){
        var selected_value = index.value;
        var index          = index.id.split('_');
        var id             = index[index.length - 1];

        jQuery("#multi_meta_field_"+id).hide('slow', function(){ jQuery("#multi_meta_field_"+id).empty(); });
    }
    
    //Delete This field from Meta Field 
    function delete_this(index){
        
        var selected_value  = index.value;
        var index          = index.id.split('_');
        var id              = index[index.length - 1];
        
        //Yalert(id);
        var delete_id = jQuery("#delete_id").val();
        if(delete_id ==""){
            jQuery("#delete_id").val(id);
        }else{
            jQuery("#delete_id").val(delete_id+','+id);
        }
        jQuery("#"+id).hide();
        jQuery("#"+id).hide('slow', function(){ jQuery("#multi_meta_field_"+id).empty(); });
    }

    var regexp = /^\d{0,4}(\.\d{0,2})?$/;
    //Code for Employee
    //Send subscribe email listing and send notification mail.
    
    jQuery(document).ready(function() {
    var xyz = 0;
    jQuery('#publish').click(function(e){
        var error1 = validateAll();
        if(error1 == 0){
            xyz = 0;
            jQuery('#post').submit();
        }else{
            xyz = 1;
            jQuery('#post').attr('action', null);
            return false;
        }
    });

    jQuery("#post").submit(function(e){
        if(xyz==1){
            e.preventDefault();
        }
    });

    /* Display send subscribe form*/
    jQuery("#sendSubscribe").click(function(){
        jQuery('.subscribeForm').show();
    });

    function validateAll(){
        var error = 0;   
        jQuery( ".boxclass" ).each(function() {
            jQuery( this).children('.errormessage').text('');
        });

        //meta box label validation.
        var v1 = jQuery.trim(jQuery( ".boxclass").children('.length').val());
        if(v1=='' ){
            jQuery( ".boxclass").children('.errortitle').hide();
            jQuery( ".boxclass").children('.length').after("<p class='errortitle' style='color: red; font-weight: bold; margin: 0 0 !important;'>This Field is Required. </p>");
            error=1;
        }else if(v1.length<3 || v1.length >100){
            jQuery( ".boxclass").children('.errortitle').hide();
            jQuery( ".boxclass").children('.length').after("<p class='errortitle' style='color: red; font-weight: bold; margin: 0 0 !important;'>Please Enter Between 3 to 100 Characters.</p>");
            error=1;
        }else{
              jQuery( ".boxclass").children('.errortitle').hide();
        }

        //meta field post type validation.
        if(jQuery('#checkArray :checkbox:checked').length==0){
            jQuery('.errorcheckbox').hide();
            jQuery('#checkArray').after("<p class='errorcheckbox' style='color:red; font-weight: bold; margin: 0 0 !important;'> Please Check at least One Checkbox.</p> ")
            error=1;
        }else{
            jQuery('.errorcheckbox').hide();
        }

        //meta field length validation
        var metafield_length  = jQuery('.multi_meta_field').length + jQuery('.multi_meta_field1').length;
        var metafield_length1 = jQuery('.multi_meta_field:not([style*="display: none"])').length + jQuery('.multi_meta_field1:not([style*="display: none"])').length;
        if(metafield_length==0 || metafield_length1 ==0){
            jQuery( ".boxclass").children('.errorfieldlength').hide();
            jQuery( ".boxclass").children('.addmeta').after("<p class='errorfieldlength' style='color: red; font-weight: bold; margin: 0 0 !important;'>At leaset one meta box required.</p>");
            error=1;
        }
        else{
            jQuery( ".boxclass").children('.errorfieldlength').hide();
            for (var i = 1; i <=metafield_length; i++) {
                if (jQuery('#multi_meta_field_'+i).css('display') == 'none') {
                    // checking if meta field is hide.
                }else{
                    //meta field title validate.
                    var v2 = jQuery.trim(jQuery( ".boxclass").children("#metabox_field_id_"+i).val());
                    if(v2==''){
                        jQuery( ".boxclass").children('.errortitle_'+i).hide();
                        jQuery( ".boxclass").children("#metabox_field_id_"+i).after("<p class='errortitle_"+i+"' style='color: red; font-weight: bold; margin: 0 0 !important;'>This Field is Required. </p>");
                        error=1;
                    }else if(v2.length<3 || v2.length>100){
                        jQuery( ".boxclass").children('.errortitle_'+i).hide();
                        jQuery( ".boxclass").children("#metabox_field_id_"+i).after("<p class='errortitle_"+i+"' style='color: red; font-weight: bold; margin: 0 0 !important;'>Please Enter Between 3 to 100 Characters.</p>");
                        error=1;
                    }else{
                        jQuery( ".boxclass").children('.errortitle_'+i).hide();
                    }

                    //Field type validation
                    if(jQuery("#my_multi_meta_box_select_"+i).val()==''){
                        jQuery('.errorfieldtype_'+i).hide();
                        jQuery('#my_multi_meta_box_select_'+i).after("<p class='errorfieldtype_"+i+"' style='color:red; font-weight: bold; margin: 0 0 !important;'> Please Select any Fieldtype.</p> ")
                        error=1;
                    }else{
                        jQuery('.errorfieldtype_'+i).hide();
                    }

                    //min length validation
                    if(jQuery('#metabox_field_minlength_'+1).val()!='' && jQuery('#metabox_field_minlength_'+1).val()<1){
                        jQuery('.errorminlength_'+i).hide();
                        jQuery('#metabox_field_minlength_'+1).after("<p class='errorminlength_"+i+"' style='color:red; font-weight: bold; margin: 0 0 !important;'> Please Enter atleast 1 or Grater then 1. </p> ")
                        error=1;
                    }else{
                        jQuery('.errorminlength_'+i).hide();
                    }

                    //max length validation
                    if(jQuery('#metabox_field_maxlength_'+i).val()>100){
                        jQuery('.errormaxlength_'+i).hide();
                        jQuery('#metabox_field_maxlength_'+i).after("<p class='errormaxlength_"+i+"' style='color:red; font-weight: bold; margin: 0 0 !important;'> Not Allowed Greater then 100.</p> ")
                        error=1;
                    }else if( parseInt(jQuery('#metabox_field_maxlength_'+i).val()) <=  parseInt(jQuery('#metabox_field_minlength_'+i).val()) && jQuery('#metabox_field_maxlength_'+i).val()!=''){
                        jQuery('.errormaxlength').hide();
                        jQuery('#metabox_field_maxlength_'+i).after("<p class='errormaxlength' style='color:red; font-weight: bold; margin: 0 0 !important;'> Max-length should be Greater then Min-Length.</p> ")
                        error=1;
                    }
                    else{
                        jQuery('.errormaxlength_'+i).hide();
                    }
                }
            };
        }
        return error;
        }
    });
    // Function that validates email address through a regular expression.
    function validateEmail(sEmail) {
        var filter = /^[\w\-\.\+]+\@[a-zA-Z0-9\.\-]+\.[a-zA-z0-9]{2,4}$/;
        if (filter.test(sEmail)) {
            return true;
        }else {
            return false;
        }
    }
    //Function that restric other data then number to enter in textbox.
    function isNumber(evt) {
        evt = (evt) ? evt : window.event;
        var charCode = (evt.which) ? evt.which : evt.keyCode;
        if (charCode > 31 && (charCode < 48 || charCode > 57)) {
            return false;
        }
        return true;
    }