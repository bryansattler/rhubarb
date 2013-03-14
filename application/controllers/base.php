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

	public function __construct()
{
    //ASSETS
    
    /* Javascript*/
    Asset::add('application', 'js/application.js');
    Asset::add('bs-tooltip', 'js/bootstrap-tooltip.js');
    Asset::add('custom-checkbox-radio', 'js/custom_checkbox_and_radio.js');
    Asset::add('custom-radio', 'js/custom_radio.js');
    Asset::add('html5shiv', 'js/html5shiv.js');
    Asset::add('icon-font-ie7', 'js/icon-font-ie7.js');
    Asset::add('jquery', 'js/jquery-1.8.2.min.js');
    Asset::add('jquery-custom', 'js/jquery-ui-1.10.0.custom.min.js');
    Asset::add('jquery-dropkick', 'js/jquery.dropkick-1.0.0.js');
    Asset::add('jquery-placeholder', 'js/jquery.placeholder.js');
    Asset::add('jquery-tagsinput', 'js/jquery.tagsinput.js');
    Asset::add('lte-ie7-24', 'js/lte-ie7-24.js');

    /* CSS */
    Asset::add('bootstrap-css', 'css/bootstrap.css');
    Asset::add('flat-ui', 'css/flat-ui.css');
    Asset::add('jquery-ui', 'css/jquery-ui-1.10.0.custom.css');
    Asset::add('style', 'css/style.css');
    Asset::add('video', 'css/video-js.css');

    /* Fonts & Icons */
	Asset::add('flat-ui-16-dev-svg', 'fonts/Flat-UI-Icons-16.dev.svg');
	Asset::add('flat-ui-16-eot', 'fonts/Flat-UI-Icons-16.eot');
	Asset::add('flat-ui-16-svg', 'fonts/Flat-UI-Icons-16.svg');
	Asset::add('flat-ui-16-ttf', 'fonts/Flat-UI-Icons-16.ttf');
	Asset::add('flat-ui-24-dev-svg', 'fonts/Flat-UI-Icons-24.dev.svg');
	Asset::add('flat-ui-24-eot', 'fonts/Flat-UI-Icons-24.eot');
	Asset::add('flat-ui-24-svg', 'fonts/Flat-UI-Icons-24.svg');
	Asset::add('flat-ui-24-ttf', 'fonts/Flat-UI-Icons-24.ttf');

    parent::__construct();
}



}