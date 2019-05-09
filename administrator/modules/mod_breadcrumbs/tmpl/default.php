<?php
/**
 * @package     Joomla.Site
 * @subpackage  mod_breadcrumbs
 *
 * @copyright   Copyright (C) 2005 - 2019 Open Source Matters, Inc. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */

defined('_JEXEC') or die;

?>
<div class="col-md-11">
	<nav role="navigation">
		<ol itemscope itemtype="https://schema.org/BreadcrumbList" class="breadcrumb">
			<li class="float-left">
				<span class="divider fa fa-location" aria-hidden="true"></span>
			</li>
			<?php foreach ($items['breadcrumbs'] as $key => $item) : ?>
				<?php if ($item->link === '') : ?>
					<?php $breadcrumbItem = '<span itemprop="name">' . $item->name . '</span>'; ?>
				<?php else : ?>
					<?php $breadcrumbItem = HTMLHelper::_('link', $item->link,
						'<span itemprop="name">' . $item->name . '</span>',
						array('itemprop' => 'item', 'class' => 'pathway')
					); ?>
				<?php endif; ?>
				<li itemprop="itemListElement" itemscope itemtype="https://schema.org/ListItem"
					class="breadcrumb-item"><?php echo $breadcrumbItem; ?>
					<meta itemprop="position" content="<?php echo $key + 1; ?>">
				</li>
			<?php endforeach; ?>
		</ol>
	</nav>
</div>
