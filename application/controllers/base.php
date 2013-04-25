<?php

class Base_Controller extends Controller {

	/**
	 * Catch-all method for requests that can't be matched.
	 *
	 * @param  string    $method
	 * @param  array     $parameters
	 * @return Response
	 */
	public function __call($method, $parameters)
	{
		return Response::error('404');
	}

    public function __construct(){
        //styles
        Asset::add('main_style', 'css/style.css');

        /**************** SCRIPTS ****************/

       /* jQuery */
        Asset::add('jquery_min', 'js/jquery-1.8.2.min.js');
        Asset::add('jquery_ui_custom_min', 'js/jquery-ui-1.10.0.custom.min.js');
        Asset::add('jquery_dropkick', 'js/jquery.dropkick-1.0.0.js');
        Asset::add('jquery_placeholder', 'js/jquery.placeholder.js');
        Asset::add('jquery_tagsinput', 'js/jquery.tagsinput.js');
        Asset::add('lte_ie7_24', 'js/lte-ie7-24.js');

        Asset::add('application', 'js/application.js');

        /* Bootstrap JS */
        Asset::add('bootstrap_tooltip', 'js/bootstrap-tooltip.js');
        Asset::add('bootstrap_alert', 'js/bootstrap-alert.js');
        Asset::add('bootstrap_button', 'js/bootstrap-button.js');
        Asset::add('bootstrap_carousel', 'js/bootstrap-carousel.js');
        Asset::add('bootstrap_collapse', 'js/bootstrap-collapse.js');
        Asset::add('bootstrap_dropdown', 'js/bootstrap-dropdown.js');        
        Asset::add('bootstrap_modal', 'js/bootstrap-modal.js'); 
        Asset::add('bootstrap_popover', 'js/bootstrap-popover.js');         
        Asset::add('bootstrap_scrollspy', 'js/bootstrap-scrollspy.js');         
        Asset::add('bootstrap_tab', 'js/bootstrap-tab.js');         
        Asset::add('bootstrap_transition', 'js/bootstrap-transition.js');        
        Asset::add('bootstrap_typeahead', 'js/bootstrap-typeahead.js');        
        
        /* Custom JS */
        Asset::add('custom_checkbox_and_radio', 'js/custom_checkbox_and_radio.js');
        Asset::add('custom_radio', 'js/custom_radio.js');
        Asset::add('html5shiv', 'js/html5shiv.js');

        /* Icon JS */
        Asset::add('icon_font_ie7', 'js/icon-font-ie7.js');

        /* Custom Rhubarb JS */
        Asset::add('rhubarb', 'js/rhubarb.js');

        /* Pusher Activity Stream */
        // Asset::add('pusher_js', 'http://js.pusher.com/2.0/pusher.min.js');
        // Asset::add('activity_stream','../activity-streams/src/PusherActivityStreamer.js');



        //fonts
  //       Asset::add('ico_16_eot', 'fonts/Flat-UI-Icons-16.eot');
  //       Asset::add('ico_16_svg', 'fonts/Flat-UI-Icons-16.svg');
  //       Asset::add('ico_16_ttf', 'fonts/Flat-UI-Icons-16.ttf');
		// Asset::add('ico_16_ttf', 'fonts/Flat-UI-Icons-16.woff');
  //       Asset::add('ico_24_eot', 'fonts/Flat-UI-Icons-24.eot');
  //       Asset::add('ico_24_svg', 'fonts/Flat-UI-Icons-24.svg');
  //       Asset::add('ico_24_ttf', 'fonts/Flat-UI-Icons-24.ttf');
		// Asset::add('ico_24_ttf', 'fonts/Flat-UI-Icons-24.woff');

        parent::__construct();
    }	

}