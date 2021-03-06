<?php
/**
 * @package	Joomla.Installation
 *
 * @copyright  Copyright (C) 2005 - 2019 Open Source Matters, Inc. All rights reserved.
 * @license	GNU General Public License version 2 or later; see LICENSE.txt
 */

defined('_JEXEC') or die;

use Joomla\CMS\HTML\HTMLHelper;
use Joomla\CMS\Language\Text;

/** @var JDocumentHtml $this */

// Add Stylesheets
// Load the template CSS file
HTMLHelper::_('stylesheet', 'template' . ($this->direction === 'rtl' ? '-rtl' : '') . '.css', ['version' => 'auto', 'relative' => true]);
HTMLHelper::_('stylesheet', 'installation/template/css/joomla-alert.min.css', ['version' => 'auto']);

// Add scripts
HTMLHelper::_('behavior.core');
HTMLHelper::_('behavior.keepalive');
HTMLHelper::_('behavior.formvalidator');
HTMLHelper::_('script', 'installation/template/js/template.js', ['version' => 'auto']);
HTMLHelper::_('webcomponent', 'vendor/joomla-custom-elements/joomla-alert.min.js', ['version' => 'auto', 'relative' => true]);

// Add script options
$this->addScriptOptions('system.installation', ['url' => JRoute::_('index.php')]);

// Load JavaScript message titles
Text::script('ERROR');
Text::script('WARNING');
Text::script('NOTICE');
Text::script('MESSAGE');

// Add strings for JavaScript error translations.
Text::script('JLIB_JS_AJAX_ERROR_CONNECTION_ABORT');
Text::script('JLIB_JS_AJAX_ERROR_NO_CONTENT');
Text::script('JLIB_JS_AJAX_ERROR_OTHER');
Text::script('JLIB_JS_AJAX_ERROR_PARSE');
Text::script('JLIB_JS_AJAX_ERROR_TIMEOUT');

// Load the JavaScript translated messages
Text::script('INSTL_PROCESS_BUSY');
Text::script('INSTL_FTP_SETTINGS_CORRECT');
?>
<!DOCTYPE html>
<html lang="<?php echo $this->language; ?>" dir="<?php echo $this->direction; ?>">
	<head>
		<jdoc:include type="metas" />
		<jdoc:include type="styles" />
	</head>
	<body data-basepath="<?php echo JUri::root(true); ?>">
		<div class="j-install">
			<?php // Header ?>
			<header class="j-header" role="banner">
				<div class="j-header-logo">
					<img src="<?php echo $this->baseurl; ?>/template/images/logo.svg" alt="" class="logo"/>
				</div>
				<div class="j-header-help">
					<a href="https://docs.joomla.org/Special:MyLanguage/J4.x:Installing_Joomla">
						<span class="fa fa-lightbulb" aria-hidden="true"></span>
						<span class="sr-only"><?php echo Text::_('INSTL_HELP_LINK'); ?></span>
					</a>
				</div>
			</header>
			<?php // Container ?>
			<main class="j-container">
				<h1><?php echo Text::_('INSTL_PAGE_TITLE'); ?></h1>
				<jdoc:include type="message" />
				<div id="javascript-warning">
					<noscript>
						<?php echo Text::_('INSTL_WARNJAVASCRIPT'); ?>
					</noscript>
				</div>
				<div id="container-installation" class="container-installation flex no-js" data-base-url="<?php echo JUri::root(); ?>" style="display:none">
					<jdoc:include type="component" />
				</div>
			</main>
			<jdoc:include type="scripts" />
			<footer class="j-footer">
				<a href="https://www.joomla.org" target="_blank">Joomla!</a>
				is free software released under the
				<a href="https://www.gnu.org/licenses/old-licenses/gpl-2.0.html" target="_blank" rel="noopener noreferrer">GNU General Public License</a>
			</footer>
		</div>
	</body>
</html>
