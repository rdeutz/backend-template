<?php
/**
 * @package     Joomla.Site
 * @subpackage  Layout
 *
 * @copyright   Copyright (C) 2005 - 2019 Open Source Matters, Inc. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */

defined('JPATH_BASE') or die;

use Joomla\CMS\HTML\HTMLHelper;
use Joomla\CMS\Language\Text;

HTMLHelper::_('script', 'legacy/toolbar.min.js', array('version' => 'auto', 'relative' => true));
?>
<nav aria-label="<?php echo Text::_('JTOOLBAR'); ?>">
<div class="btn-toolbar d-flex" role="toolbar" id="<?php echo $displayData['id']; ?>">
