<?php
/**
* @version   $Id: error.php 24187 2014-11-21 16:05:35Z james $
* @author    RocketTheme http://www.rockettheme.com
* @copyright Copyright (C) 2007 - 2015 RocketTheme, LLC
* @license   http://www.gnu.org/licenses/gpl-2.0.html GNU/GPLv2 only
*
* Gantry uses the Joomla Framework (http://www.joomla.org), a GNU/GPLv2 content management system
*
*/
defined( '_JEXEC' ) or die( 'Restricted access' );

// Load and Inititialize Gantry Class
global $gantry;
require_once(dirname(__FILE__) . '/lib/gantry/gantry.php');
$gantry->init();

// Load Mootools
JHTML::_('behavior.framework', true);

$doc = JFactory::getDocument();
$app = JFactory::getApplication();

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

$gantry->addStyle('grid-responsive.css', 5);
$gantry->addLess('bootstrap.less', 'bootstrap.css', 6);
$gantry->addLess('error.less', 'error.css', 4, $lessVariables);

// Scripts
if ($gantry->browser->name == 'ie'){
	if ($gantry->browser->shortversion == 8){
		$gantry->addScript('html5shim.js');
		$gantry->addScript('placeholder-ie.js');
	}
	if ($gantry->browser->shortversion == 9){
		$gantry->addInlineScript("if (typeof RokMediaQueries !== 'undefined') window.addEvent('domready', function(){ RokMediaQueries._fireEvent(RokMediaQueries.getQuery()); });");
		$gantry->addScript('placeholder-ie.js');
	}
}
if ($gantry->get('layout-mode', 'responsive') == 'responsive') $gantry->addScript('rokmediaqueries.js');

ob_start();
?>
<body <?php echo $gantry->displayBodyTag(); ?>>
	<div id="rt-page-surround">
		<div class="rt-pagesurround-overlay">
			<div id="rt-body-surround">
				<div id="rt-header">
					<div class="rt-container">
						<div class="rt-flex-container">
							<?php echo $gantry->displayModules('header','standard','standard'); ?>
							<div class="clear"></div>
						</div>
					</div>
				</div>

				<header id="rt-header-surround">
					<div class="rt-bg-overlay">
						<div id="rt-showcase">
							<div class="rt-container">
								<div class="rt-flex-container">
									<div class="rt-error-body">
										<div class="rt-error-header">
											<div class="rt-error-code"><?php echo $this->error->getCode(); ?></div>
											<div class="rt-error-code-desc"><?php echo $this->error->getMessage(); ?></div>
										</div>
										<div class="rt-error-content">
											<div class="rt-error-title"><?php echo JText::_("RT_ERROR_TITLE"); ?></div>
											<div class="rt-error-message"><?php echo JText::_("RT_ERROR_MESSAGE"); ?></div>
											<div class="rt-error-button"><a href="<?php echo $gantry->baseUrl; ?>" class="readon"><span><?php echo JText::_("RT_ERROR_HOME"); ?></span></a></div>
										</div>
										<div class="clear"></div>
									</div>
									<div class="clear"></div>
								</div>
							</div>
						</div>
					</div>
				</header>

				<footer id="rt-footer-surround">
					<div id="rt-copyright">
						<div class="rt-container">
							<div class="rt-flex-container">
								<?php echo $gantry->displayModules('copyright','standard','standard'); ?>
								<div class="clear"></div>
							</div>
						</div>
					</div>
				</footer>
			</div>
		</div>
	</div>
</body>
</html>
<?php

$body = ob_get_clean();
$gantry->finalize();

require_once(JPATH_LIBRARIES.'/joomla/document/html/renderer/head.php');
$header_renderer = new JDocumentRendererHead($doc);
$header_contents = $header_renderer->render(null);
ob_start();
?>
<!doctype html>
<html xml:lang="<?php echo $gantry->language; ?>" lang="<?php echo $gantry->language;?>" >
<head>
	<?php echo $header_contents; ?>
	<?php if ($gantry->get('layout-mode') == '960fixed') : ?>
	<meta name="viewport" content="width=960px">
	<?php elseif ($gantry->get('layout-mode') == '1200fixed') : ?>
	<meta name="viewport" content="width=1200px">
	<?php else : ?>
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<?php endif; ?>
</head>
<?php
$header = ob_get_clean();
echo $header.$body;