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
});
