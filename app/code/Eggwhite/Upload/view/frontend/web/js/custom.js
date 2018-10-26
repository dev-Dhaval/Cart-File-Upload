/**
 * Eggwhite_Upload extension
 *
 *
 * @category Eggwhite Cartupload
 * @package  Eggwhite_Upload
 * @author   D.V <Eggwhite Dev>
 */


require([
    "jquery"
], function ($) {
jQuery('.commentupload').click(function()
{
	var id = jQuery(this).data("id");
	jQuery('#update'+id).parent().addClass(' progress');
	var comments = jQuery('#comment'+id).val();
	jQuery.ajax({
	    url: jQuery('.commentupload').data("url"),
	    type: 'POST',
	    data: { id : id, comment : comments },
	    success: function (resp) {
		jQuery('#update'+id).parent().removeClass('progress');
		jQuery('#update'+id).parent().addClass(' complete');
	    }
	});
});
jQuery('.comment textarea').click(function()
{
	jQuery(this).parent().find('.commentupload').removeClass(' complete');
});   
});
