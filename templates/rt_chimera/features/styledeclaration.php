<?php
/**
* @version   $Id: styledeclaration.php 26163 2015-01-27 17:11:55Z james $
* @author		RocketTheme http://www.rockettheme.com
* @copyright 	Copyright (C) 2007 - 2015 RocketTheme, LLC
* @license		http://www.gnu.org/licenses/gpl-2.0.html GNU/GPLv2 only
 *
 * Gantry uses the Joomla Framework (http://www.joomla.org), a GNU/GPLv2 content management system
 *
 */
defined('JPATH_BASE') or die();

gantry_import('core.gantryfeature');

class GantryFeatureStyleDeclaration extends GantryFeature {
    var $_feature_name = 'styledeclaration';

    function isEnabled() {
		global $gantry;
        $menu_enabled = $this->get('enabled');

        if (1 == (int)$menu_enabled) return true;
        return false;
    }

	function init() {
		global $gantry, $ie_ver;
		$browser = $gantry->browser;

        if ($gantry->browser->name == 'ie' && $gantry->browser->shortversion == 8) $ie_ver = 'ie8';

        // Logo
    	$css = $this->buildLogo();

        // Less Variables
    	$lessVariables = array(
            'accent-color1'             => $gantry->get('accent-color1',                '#B17E15'),
            'accent-color2'             => $gantry->get('accent-color2',                '#B2301A'),

            'slideshow-textcolor'       => $gantry->get('slideshow-textcolor',          '#FFFFFF'),
            'slideshow-background'      => $gantry->get('slideshow-background',         '#975820'),

            'header-textcolor'          => $gantry->get('header-textcolor',             '#FFFFFF'),
            'header-background'         => $gantry->get('header-background',            '#3B3B3B'),
            'header-type'               => $gantry->get('header-type',                  'normal'),

            'showcase-textcolor'        => $gantry->get('showcase-textcolor',           '#FFFFFF'),
            'showcase-background'       => $gantry->get('showcase-background',          '#B17E15'),

            'feature-textcolor'         => $gantry->get('feature-textcolor',            '#444444'),
            'feature-background'        => $gantry->get('feature-background',           '#FFFFFF'),

            'utility-textcolor'         => $gantry->get('utility-textcolor',            '#444444'),
            'utility-background'        => $gantry->get('utility-background',           '#FFFFFF'),

            'expandedtop-textcolor'     => $gantry->get('expandedtop-textcolor',        '#FFFFFF'),
            'expandedtop-background'    => $gantry->get('expandedtop-background',       '#D14C3B'),

            'maintop-textcolor'         => $gantry->get('maintop-textcolor',            '#444444'),
            'maintop-background'        => $gantry->get('maintop-background',           '#FFFFFF'),

            'mainbottom-textcolor'      => $gantry->get('mainbottom-textcolor',         '#444444'),
            'mainbottom-background'     => $gantry->get('mainbottom-background',        '#FFFFFF'),

            'mainbody-overlay'          => $gantry->get('mainbody-overlay',             'light'),

            'extension-textcolor'       => $gantry->get('extension-textcolor',          '#444444'),
            'extension-background'      => $gantry->get('extension-background',         '#F7F7F7'),

            'bottom-textcolor'          => $gantry->get('bottom-textcolor',             '#AAAAAA'),
            'bottom-background'         => $gantry->get('bottom-background',            '#3B3B3B'),

            'footer-textcolor'          => $gantry->get('footer-textcolor',             '#AAAAAA'),
            'footer-background'         => $gantry->get('footer-background',            '#333333'),

            'copyright-textcolor'       => $gantry->get('copyright-textcolor',          '#AAAAAA'),
            'copyright-background'      => $gantry->get('copyright-background',         '#3B3B3B')
    	);

        // Section Background Images
        $positions  = array('pagesurround-custompagesurround-image', 'headersurround-customheadersurround-image', 'expandedbottom-customexpandedbottom-image');
        $source     = "";

        foreach ($positions as $position) {
            $data = $gantry->get($position, false) ? json_decode(str_replace("'", '"', $gantry->get($position))) : false;
            if ($data) $source = $data->path;
            if (!preg_match('/^\//', $source)) $source = JURI::root(true).'/'.$source;
            $lessVariables[$position] = $data ? 'url(' . $source . ')' : 'none';
        }

        $gantry->addInlineStyle($css);

       	$gantry->addLess('global.less', 'master.css', 7, $lessVariables);

	    $this->_disableRokBoxForiPhone();

        if ($gantry->get('layout-mode')=="responsive") {
            $gantry->addLess('mediaqueries.less');
            $gantry->addLess('grid-flexbox-responsive.less');
            $gantry->addLess('menu-dropdown-direction.less');
        }

        // Scrolling Header
        if ($gantry->get('header-type')=="scroll") {
            $gantry->addScript('scrolling-header-fullpage.js');
        }

        // unassigned menu items pages.
        $app = JFactory::getApplication();
        $menu = $app->getMenu();
        if (!$menu->getActive()) {
            $gantry->addInlineStyle(".header-type-scroll #rt-header {opacity: 1; visibility: visible; position: relative;}");
        }

        if ($gantry->get('layout-mode')=="960fixed")   $gantry->addLess('960fixed.less');
        if ($gantry->get('layout-mode')=="1200fixed")  $gantry->addLess('1200fixed.less');

        // RTL
        if ($gantry->get('rtl-enabled')) $gantry->addLess('rtl.less', 'rtl.css', 8, $lessVariables);

        // Demo Styling
        if ($gantry->get('demo')) $gantry->addLess('demo.less', 'demo.css', 9, $lessVariables);

        // Third Party (k2)
        if ($gantry->get('k2')) $gantry->addLess('thirdparty-k2.less', 'thirdparty-k2.css', 10, $lessVariables);

        // Chart Script
        if ($gantry->get('chart-enabled')) $gantry->addScript('chart.js');

        // Animate CSS
        $gantry->addLess('animate.less');

        // WOW JS
        if ($ie_ver != 'ie8') {
            $gantry->addScript('wow.js');
            $gantry->addScript('wow-init.js');
        }

        // SmoothScroll
        $gantry->addScript('bind-polyfill.min.js');
        $gantry->addScript('smooth-scroll.min.js');

	}

    function buildLogo(){
		global $gantry;

        if ($gantry->get('logo-type')!="custom") return "";

        $source = $width = $height = "";

        $logo = str_replace("&quot;", '"', str_replace("'", '"', $gantry->get('logo-custom-image')));
        $data = json_decode($logo);

        if (!$data){
            if (strlen($logo)) $source = $logo;
            else return "";
        } else {
            $source = $data->path;
        }

        if (substr($gantry->baseUrl, 0, strlen($gantry->baseUrl)) == substr($source, 0, strlen($gantry->baseUrl))){
            $file = JPATH_ROOT . '/' . substr($source, strlen($gantry->baseUrl));
        } else {
            $file = JPATH_ROOT . '/' . $source;
        }

        if (isset($data->width) && isset($data->height)){
            $width = $data->width;
            $height = $data->height;
        } else {
            $size = @getimagesize($file);
            $width = $size[0];
            $height = $size[1];
        }

        if (!preg_match('/^\//', $source))
        {
            $source = JURI::root(true).'/'.$source;
        }

        $source = str_replace(' ', '%20', $source);

        $output = "";
        $output .= "#rt-logo {background: url(".$source.") 50% 0 no-repeat !important;}"."\n";
        $output .= "#rt-logo {width: ".$width."px;height: ".$height."px;}"."\n";

        $file = preg_replace('/\//i', DIRECTORY_SEPARATOR, $file);

        return (file_exists($file)) ?$output : '';
    }

	function _disableRokBoxForiPhone() {
		global $gantry;

		if ($gantry->browser->platform == 'iphone' || $gantry->browser->platform == 'android') {
			$gantry->addInlineScript("window.addEvent('domready', function() {\$\$('a[rel^=rokbox]').removeEvents('click');});");
		}
	}
}