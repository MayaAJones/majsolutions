<?php
/**
* @version   $Id: index.php 26163 2015-01-27 17:11:55Z james $
* @author    RocketTheme http://www.rockettheme.com
* @copyright Copyright (C) 2007 - 2015 RocketTheme, LLC
* @license   http://www.gnu.org/licenses/gpl-2.0.html GNU/GPLv2 only
 *
 * Gantry uses the Joomla Framework (http://www.joomla.org), a GNU/GPLv2 content management system
 *
 */

/* No Direct Access */
defined( '_JEXEC' ) or die( 'Restricted index access' );
/* Load Mootools */
JHTML::_('behavior.framework', true);
/* Load and Inititialize Gantry Class */
require_once(dirname(__FILE__) . '/lib/gantry/gantry.php');
$gantry->init();
/* Get the Current Preset */
$gpreset = str_replace(' ','',strtolower($gantry->get('name')));
?>
<!doctype html>
<html xml:lang="<?php echo $gantry->language; ?>" lang="<?php echo $gantry->language;?>" >
<head>
<?php if ($gantry->get('layout-mode') == '960fixed') : ?>
	<meta name="viewport" content="width=960px">
<?php elseif ($gantry->get('layout-mode') == '1200fixed') : ?>
	<meta name="viewport" content="width=1200px">
<?php else : ?>
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
<?php endif; ?>
<?php /* Head */
	$gantry->displayHead();
?>
<?php /* Force IE to Use the Most Recent Version */ if ($gantry->browser->name == 'ie') : ?>
	<meta http-equiv="X-UA-Compatible" content="IE=edge" />
<?php endif; ?>

<?php
	$gantry->addLess('bootstrap.less', 'bootstrap.css', 6);
	if ($gantry->browser->name == 'ie'){
		if ($gantry->browser->shortversion == 8){
			$gantry->addScript('html5shim.js');
			$gantry->addScript('canvas-unsupported.js');
			$gantry->addScript('placeholder-ie.js');
		}
		if ($gantry->browser->shortversion == 9){
			$gantry->addInlineScript("if (typeof RokMediaQueries !== 'undefined') window.addEvent('domready', function(){ RokMediaQueries._fireEvent(RokMediaQueries.getQuery()); });");
			$gantry->addScript('placeholder-ie.js');
		}
	}
	if ($gantry->get('layout-mode', 'responsive') == 'responsive') $gantry->addScript('rokmediaqueries.js');
?>
</head>
<body <?php echo $gantry->displayBodyTag(); ?>>
	<div id="rt-page-surround">
		<div class="rt-pagesurround-overlay">
			<div id="rt-body-surround">
				<?php /** Begin Header **/ if ($gantry->countModules('header')) : ?>
				<div id="rt-header">
					<div class="rt-container">
						<div class="rt-flex-container">
							<?php echo $gantry->displayModules('header','standard','standard'); ?>
							<div class="clear"></div>
						</div>
					</div>
				</div>
				<div class="rt-header-fixed-spacer"></div>
				<?php /** End Header **/ endif; ?>
				<?php /** Begin Slideshow **/ if ($gantry->countModules('slideshow')) : ?>
				<div id="rt-slideshow">
					<div class="rt-bg-overlay">
						<?php echo $gantry->displayModules('slideshow','basic','standard'); ?>
						<div class="clear"></div>
						<a class="rt-slideshow-scrollbottom" href="#rt-head-anchor" data-scroll><span class="rt-bottom-arrow"></span></a>
					</div>
				</div>
				<?php /** End Slideshow **/ endif; ?>

				<?php /** Begin Head Anchor **/ ?>
				<div id="rt-head-anchor"></div>
				<?php /** End Head Anchor **/ ?>

				<?php /** Begin TopFullWidth **/ if ($gantry->countModules('topfullwidth')) : ?>
				<div id="rt-topfullwidth">
					<?php echo $gantry->displayModules('topfullwidth','basic','standard'); ?>
					<div class="clear"></div>
				</div>
				<?php /** End TopFullWidth **/ endif; ?>
				<?php /** Begin Header Surround **/ if ($gantry->countModules('drawer') or $gantry->countModules('top') or $gantry->countModules('showcase')) : ?>
				<header id="rt-header-surround">
					<div class="rt-bg-overlay">
						<?php /** Begin Drawer **/ if ($gantry->countModules('drawer')) : ?>
						<div id="rt-drawer">
							<div class="rt-container">
								<div class="rt-flex-container">
									<?php echo $gantry->displayModules('drawer','standard','standard'); ?>
									<div class="clear"></div>
								</div>
							</div>
						</div>
						<?php /** End Drawer **/ endif; ?>
						<?php /** Begin Top **/ if ($gantry->countModules('top-')) : ?>
						<div id="rt-top">
							<div class="rt-container">
								<div class="rt-flex-container">
									<?php echo $gantry->displayModules('top-','standard','standard'); ?>
									<div class="clear"></div>
								</div>
							</div>
						</div>
						<?php /** End Top **/ endif; ?>

						<?php /** Begin Showcase **/ if ($gantry->countModules('showcase')) : ?>
						<div id="rt-showcase">
							<div class="rt-container">
								<div class="rt-flex-container">
									<?php echo $gantry->displayModules('showcase','standard','standard'); ?>
									<div class="clear"></div>
								</div>
							</div>
						</div>
						<?php /** End Showcase **/ endif; ?>
					</div>
				</header>
				<?php /** End Header Surround **/ endif; ?>

				<?php /** Begin Main Section **/ ?>
				<section id="rt-mainbody-surround">
					<?php /** Begin Breadcrumbs **/ if ($gantry->countModules('breadcrumb')) : ?>
					<div id="rt-breadcrumbs">
						<div class="rt-container">
							<div class="rt-flex-container">
								<?php echo $gantry->displayModules('breadcrumb','standard','standard'); ?>
								<div class="clear"></div>
							</div>
						</div>
					</div>
					<?php /** End Breadcrumbs **/ endif; ?>
					<?php /** Begin Feature **/ if ($gantry->countModules('feature')) : ?>
					<div id="rt-feature">
						<div class="rt-container">
							<div class="rt-flex-container">
								<?php echo $gantry->displayModules('feature','standard','standard'); ?>
								<div class="clear"></div>
							</div>
						</div>
					</div>
					<?php /** End Feature **/ endif; ?>
					<?php /** Begin Utility **/ if ($gantry->countModules('utility')) : ?>
					<div id="rt-utility">
						<div class="rt-container">
							<div class="rt-flex-container">
								<?php echo $gantry->displayModules('utility','standard','standard'); ?>
								<div class="clear"></div>
							</div>
						</div>
					</div>
					<?php /** End Utility **/ endif; ?>
					<?php /** Begin Expanded Top **/ if ($gantry->countModules('expandedtop')) : ?>
					<div id="rt-expandedtop">
						<div class="rt-container">
							<div class="rt-flex-container">
								<?php echo $gantry->displayModules('expandedtop','standard','standard'); ?>
								<div class="clear"></div>
							</div>
						</div>
					</div>
					<?php /** End Expanded Top **/ endif; ?>
					<?php /** Begin Main Top **/ if ($gantry->countModules('maintop')) : ?>
					<div id="rt-maintop">
						<div class="rt-container">
							<div class="rt-flex-container">
								<?php echo $gantry->displayModules('maintop','standard','standard'); ?>
								<div class="clear"></div>
							</div>
						</div>
					</div>
					<?php /** End Main Top **/ endif; ?>
					<?php /** Begin Main Body **/ ?>
					<div id="rt-mainbody-wrapper">
						<div class="rt-container">
							<?php echo $gantry->displayMainbody('mainbody','sidebar','standard','standard','standard','standard','standard'); ?>
						</div>
					</div>
					<?php /** End Main Body **/ ?>
					<?php /** Begin Main Bottom **/ if ($gantry->countModules('mainbottom')) : ?>
					<div id="rt-mainbottom">
						<div class="rt-container">
							<div class="rt-flex-container">
								<?php echo $gantry->displayModules('mainbottom','standard','standard'); ?>
								<div class="clear"></div>
							</div>
						</div>
					</div>
					<?php /** End Main Bottom **/ endif; ?>
					<?php /** Begin Expanded Bottom **/ if ($gantry->countModules('expandedbottom')) : ?>
					<div id="rt-expandedbottom">
						<div class="rt-bg-overlay">
							<div class="rt-container">
								<div class="rt-flex-container">
									<?php echo $gantry->displayModules('expandedbottom','standard','standard'); ?>
									<div class="clear"></div>
								</div>
							</div>
						</div>
					</div>
					<?php /** End Expanded Bottom **/ endif; ?>
				</section>
				<?php /** End Main Section **/ ?>

				<?php /** Begin FullWidth **/ if ($gantry->countModules('fullwidth')) : ?>
				<div id="rt-fullwidth">
					<?php echo $gantry->displayModules('fullwidth','basic','standard'); ?>
					<div class="clear"></div>
				</div>
				<?php /** End FullWidth **/ endif; ?>

				<?php /** Begin Footer Section **/ if ($gantry->countModules('extension') or $gantry->countModules('bottom') or $gantry->countModules('footer') or $gantry->countModules('copyright')) : ?>
				<footer id="rt-footer-surround">
					<?php /** Begin Extension **/ if ($gantry->countModules('extension')) : ?>
					<div id="rt-extension">
						<div class="rt-container">
							<div class="rt-flex-container">
								<?php echo $gantry->displayModules('extension','standard','standard'); ?>
								<div class="clear"></div>
							</div>
						</div>
					</div>
					<?php /** End Extension **/ endif; ?>
					<?php /** Begin Bottom **/ if ($gantry->countModules('bottom')) : ?>
					<div id="rt-bottom">
						<div class="rt-container">
							<div class="rt-flex-container">
								<?php echo $gantry->displayModules('bottom','standard','standard'); ?>
								<div class="clear"></div>
							</div>
						</div>
					</div>
					<?php /** End Bottom **/ endif; ?>
					<?php /** Begin Footer **/ if ($gantry->countModules('footer')) : ?>
					<div id="rt-footer">
						<div class="rt-container">
							<div class="rt-flex-container">
								<?php echo $gantry->displayModules('footer','standard','standard'); ?>
								<div class="clear"></div>
							</div>
						</div>
					</div>
					<?php /** End Footer **/ endif; ?>
					<?php /** Begin Copyright **/ if ($gantry->countModules('copyright')) : ?>
					<div id="rt-copyright">
						<div class="rt-container">
							<div class="rt-flex-container">
								<?php echo $gantry->displayModules('copyright','standard','standard'); ?>
								<div class="clear"></div>
							</div>
						</div>
					</div>
					<?php /** End Copyright **/ endif; ?>
				</footer>
				<?php /** End Footer Surround **/ endif; ?>
			</div>

			<?php /** Begin Debug **/ if ($gantry->countModules('debug')) : ?>
			<div id="rt-debug">
				<div class="rt-container">
					<div class="rt-flex-container">
						<?php echo $gantry->displayModules('debug','standard','standard'); ?>
						<div class="clear"></div>
					</div>
				</div>
			</div>
			<?php /** End Debug **/ endif; ?>

			<?php /** Begin Analytics **/ if ($gantry->countModules('analytics')) : ?>
			<?php echo $gantry->displayModules('analytics','basic','basic'); ?>
			<?php /** End Analytics **/ endif; ?>

			<?php /** Popup Login and Popup Module **/ ?>
			<?php echo $gantry->displayModules('login','login','popup'); ?>
			<?php echo $gantry->displayModules('popup','popup','popup'); ?>
			<?php /** End Popup Login and Popup Module **/ ?>
		</div>
	</div>

	<?php if ($gantry->countModules('slideshow')) : ?>
	<script>
		(function(){
		    var width, height = true;

		    function initHeader() {
		        width = window.innerWidth;
		        height = window.innerHeight;

		        largeHeader = document.getElementById('rt-slideshow');
		        largeHeader.style.height = height+'px';

		        document.getElementById('sprocket-features-img-list').style.height= height+'px';

		    }

		    // Main
		    initHeader();
		})();
	</script>
	<?php endif; ?>

</body>
</html>
<?php
$gantry->finalize();
?>