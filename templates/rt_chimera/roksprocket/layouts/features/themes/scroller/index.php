<?php
/**
* @version   $Id: index.php 26163 2015-01-27 17:11:55Z james $
* @author    RocketTheme http://www.rockettheme.com
* @copyright Copyright (C) 2007 - 2015 RocketTheme, LLC
* @license   http://www.gnu.org/licenses/gpl-2.0.html GNU/GPLv2 only
 */

/**
 * @var $layout     RokSprocket_Layout_Features
 * @var $items      RokSprocket_Item[]
 * @var $parameters RokCommon_Registry
 */

?>
<div class="sprocket-features layout-scroller <?php if ($parameters->get('features_show_arrows')!='hide') : ?>arrows-active<?php endif; ?> <?php if ($parameters->get('features_show_arrows')=='onhover') : ?>arrows-onhover<?php endif; ?> <?php if ($parameters->get('features_show_pagination')) : ?>pagination-active<?php endif; ?>" data-scroller="<?php echo $parameters->get('module_id'); ?>">
	<div class="sprocket-features-flex-wrapper">
		<ul class="sprocket-features-list">
			<?php
			$index = 0;
				foreach($items as $item){
					$index++;
					echo $layout->getThemeContext()->load('item.php', array('item'=> $item,'parameters'=>$parameters,'index'=>$index,'layout'=>$layout));
				}
			?>
		</ul>

		<?php
		$document = JFactory::getDocument();
		$document->addScriptDeclaration('
		    window.onload = function()
		    {
		        var $scrollbar = document.getElementById("sprocket-features-scroller-scrollbar")
		        ,   scrollbar  = tinyscrollbar($scrollbar)
		        ;
		    }
		');
		?>
        <div id="sprocket-features-scroller-scrollbar">
            <div class="scrollbar"><div class="track"><div class="thumb"><div class="end"></div></div></div></div>
            <div class="viewport">
                 <div class="overview">

					<div class="sprocket-features-pagination<?php echo $parameters->get('features_show_pagination') ? '' : '-hidden'; ?>">
						<ul>
						<?php $i = 0; foreach ($items as $item): ?>
							<?php
								$class = (!$i) ? ' class="active"' : '';
								$i++;
							?>
					    	<li<?php echo $class; ?> data-scroller-pagination="<?php echo $i; ?>"><span><?php echo $i; ?></span>  <?php echo $item->getTitle(); ?> </li>
						<?php endforeach; ?>
						</ul>
					</div>

                </div>
            </div>
        </div>

	</div>

	<?php if ($parameters->get('features_show_arrows')!='hide') : ?>
	<div class="sprocket-features-arrows">
		<span class="arrow next" data-scroller-next><span>&rsaquo;</span></span>
		<span class="arrow prev" data-scroller-previous><span>&lsaquo;</span></span>
	</div>
	<?php endif; ?>


</div>
