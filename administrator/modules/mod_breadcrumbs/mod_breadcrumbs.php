<?php
/**
 * @package     Joomla.Site
 * @subpackage  mod_breadcrumbs
 *
 * @copyright   Copyright (C) 2005 - 2019 Open Source Matters, Inc. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */

defined('_JEXEC') or die;

use Joomla\CMS\Helper\ModuleHelper;
use Joomla\Module\Breadcrumbs\Site\Helper\BreadcrumbsHelper;

// Load the mod_menu language file for the breadcrumbs
$app      = Factory::getApplication();
$language = $app->getLanguage();
$language->load('mod_menu');

// Get the breadcrumb items
/** @var \Joomla\CMS\Pathway\AdministratorPathway $pathway */
$this->breadcrumbs['breadcrumbs'] = $app->getPathway()->getPathWay();

require ModuleHelper::getLayoutPath('mod_breadcrumbs', $params->get('layout', 'default'));
