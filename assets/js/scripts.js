(function() {

	var team = {
		initialize: function() {
			this.readMore();
			this.closePopup();
		},
		readMore: function() {
			var read_more_toggle = jQuery('.b2-team-member-bio + a'),
				has_popup = jQuery('.b2-team').hasClass('two-column');

			read_more_toggle.click(function() {
				if (has_popup) {
					jQuery('.b2-team-popup').fadeIn();
					
					var photo = jQuery(this).parent().parent().parent().find('.b2-team-member-img img').attr('src'),
						name = jQuery(this).parent().parent().parent().find('.b2-team-member-cd h2').html(),
						position = jQuery(this).parent().parent().parent().find('.b2-team-member-cd h3').html(),
						phone = jQuery(this).parent().parent().parent().find('.members-phone').attr('href'),
						email = jQuery(this).parent().parent().parent().find('.members-email').attr('href'),
						facebook = jQuery(this).parent().parent().parent().find('.members-facebook').attr('href'),
						twitter = jQuery(this).parent().parent().parent().find('.members-twitter').attr('href'),
						instagram = jQuery(this).parent().parent().parent().find('.members-instagram').attr('href'),
						linkedin = jQuery(this).parent().parent().parent().find('.members-linkedin').attr('href'),
						bio = jQuery(this).parent().parent().parent().find('.b2-team-member-bio').html();
						
					jQuery('.b2-team-popup').find('.b2-team-member-img img').attr('src', photo);
					jQuery('.b2-team-popup').find('.b2-team-member-cd h2').html(name);
					jQuery('.b2-team-popup').find('.b2-team-member-cd h3').html(position);

					if (phone != '') {
						jQuery('.b2-team-popup').find('.members-phone').attr('href', phone);
						jQuery('.b2-team-popup').find('.members-phone').html('<i class="fa-solid fa-phone"></i> ' + phone.replace('tel:',''));
					} else {
						jQuery('.b2-team-popup').find('.members-phone').hide();
					}

					if (email != '') {
						jQuery('.b2-team-popup').find('.members-email').attr('href', email);
						jQuery('.b2-team-popup').find('.members-email').html('<i class="fa-solid fa-envelope"></i> ' + email.replace('mailto:',''));
					} else {
						jQuery('.b2-team-popup').find('.members-email').hide();
					}

					jQuery('.b2-team-popup').find('.members-facebook').attr('href', facebook);
					jQuery('.b2-team-popup').find('.members-twitter').attr('href', twitter);
					jQuery('.b2-team-popup').find('.members-instagram').attr('href', instagram);
					jQuery('.b2-team-popup').find('.members-linkedin').attr('href', linkedin);
					jQuery('.b2-team-popup').find('.b2-team-member-bio').html(bio);

				} else {
					jQuery(this).parent().find('.b2-team-member-bio').toggleClass('show-bio');
	
					if (jQuery(this).parent().find('.b2-team-member-bio').hasClass('show-bio')) {
						jQuery(this).html('Read Less');
					} else {
						jQuery(this).html('Read More...');
					}
				}
			});
		},
		closePopup: function() {
			var close_popup_toggle = jQuery('.b2-team-popup-close');
			close_popup_toggle.click(function() {
				jQuery('.b2-team-popup').fadeOut();
			});
		}
	}

	jQuery(document).ready(function() {
		team.initialize();
	});

}());