(function() {

	var team = {
		initialize: function() {
			this.readMore();
		},
		readMore: function() {
			var read_more_toggle = jQuery('.b2-team-member-bio + a');
			read_more_toggle.click(function() {
				jQuery(this).parent().find('.b2-team-member-bio').toggleClass('show-bio');

				if (jQuery(this).parent().find('.b2-team-member-bio').hasClass('show-bio')) {
					jQuery(this).html('Read Less');
				} else {
					jQuery(this).html('Read More...');
				}
			});
		},
	}

	jQuery(document).ready(function() {
		team.initialize();
	});

}());