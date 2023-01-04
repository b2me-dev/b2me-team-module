<?php

	/* Module Name: B2Me Team Module */

	class B2Me_Team_Module {

		public function __construct() {
			add_shortcode('b2-team', array($this, 'team'));
		}

		

		/* Shortcode */
		public function team($attr) {
			
		}
	}

	new B2Me_Team_Module();