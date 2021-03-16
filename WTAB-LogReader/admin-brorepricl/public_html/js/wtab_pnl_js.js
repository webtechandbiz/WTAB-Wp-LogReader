jQuery( document ).ready(function() {
    'use strict';

    jQuery('body').on('change', ".wtab_chk", function(e) {
        var this_id = this.id;
        this_id = this_id.replace('chk_', '');

        if(jQuery(this).prop('checked')){
            jQuery('#' + this_id).val('1');
        }else{
            jQuery('#' + this_id).val('0');
        }
    });
    
    jQuery('body').on('change', ".wtab_chk_choosenfile", function(e) {
        var this_value = jQuery(this).data('filename');

        if(jQuery(this).prop('checked')){
            jQuery('#choosenfile').val(jQuery('#choosenfile').val() + '|' + this_value);
        }else{
            var _choosenfile = jQuery('#choosenfile').val();
            _choosenfile = _choosenfile.replace('|' + this_value);
            jQuery('#choosenfile').val(_choosenfile);
        }
    });
    
    jQuery('body').on('change', ".wtab_chk_wpdebugactive", function(e) {
        if(jQuery(this).prop('checked')){
            jQuery('#wpdebugactive').val(1);
        }else{
            jQuery('#wpdebugactive').val(0);
        }
    });

    jQuery('body').on('change', ".wtab_chk_wpshowphpmsgactive", function(e) {
        if(jQuery(this).prop('checked')){
            jQuery('#wpshowphpmsgactive').val(1);
        }else{
            jQuery('#wpshowphpmsgactive').val(0);
        }
    });
});
