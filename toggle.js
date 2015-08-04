/*
This should be added and implemented in the template.
*/
jQuery(function($) {
	jQuery('.toggle').click(function() {
		var target = jQuery(this).attr('data-target');
		var next = (target) ? jQuery('#'+target) : jQuery(this).next();
		if(next.css('display') == 'none') {
			jQuery(this).children('.glyphicon').removeClass('glyphicon-plus-sign').addClass('glyphicon-minus-sign');
		} else {
			jQuery(this).children('.glyphicon').removeClass('glyphicon-minus-sign').addClass('glyphicon-plus-sign');
		}
		next.slideToggle('fast');	
	}).prepend('<span class="glyphicon glyphicon-plus-sign" aria-hidden="true"></span>').next().hide();
}