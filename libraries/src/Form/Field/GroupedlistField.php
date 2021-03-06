<?php
/**
 * Joomla! Content Management System
 *
 * @copyright  Copyright (C) 2005 - 2019 Open Source Matters, Inc. All rights reserved.
 * @license    GNU General Public License version 2 or later; see LICENSE.txt
 */

namespace Joomla\CMS\Form\Field;

defined('JPATH_PLATFORM') or die;

use Joomla\CMS\Form\FormField;
use Joomla\CMS\HTML\HTMLHelper;
use Joomla\CMS\Language\Text;

/**
 * Form Field class for the Joomla Platform.
 * Provides a grouped list select field.
 *
 * @since  1.7.0
 */
class GroupedlistField extends FormField
{
	/**
	 * The form field type.
	 *
	 * @var    string
	 * @since  1.7.0
	 */
	protected $type = 'Groupedlist';

	/**
	 * Method to get the field option groups.
	 *
	 * @return  array  The field option objects as a nested array in groups.
	 *
	 * @since   1.7.0
	 * @throws  \UnexpectedValueException
	 */
	protected function getGroups()
	{
		$groups = array();
		$label = 0;

		foreach ($this->element->children() as $element)
		{
			switch ($element->getName())
			{
				// The element is an <option />
				case 'option':
					// Initialize the group if necessary.
					if (!isset($groups[$label]))
					{
						$groups[$label] = array();
					}

					$disabled = (string) $element['disabled'];
					$disabled = ($disabled == 'true' || $disabled == 'disabled' || $disabled == '1');

					// Create a new option object based on the <option /> element.
					$tmp = HTMLHelper::_(
						'select.option', ($element['value']) ? (string) $element['value'] : trim((string) $element),
						Text::alt(trim((string) $element), preg_replace('/[^a-zA-Z0-9_\-]/', '_', $this->fieldname)), 'value', 'text',
						$disabled
					);

					// Set some option attributes.
					$tmp->class = (string) $element['class'];

					// Set some JavaScript option attributes.
					$tmp->onclick = (string) $element['onclick'];

					// Add the option.
					$groups[$label][] = $tmp;
					break;

				// The element is a <group />
				case 'group':
					// Get the group label.
					if ($groupLabel = (string) $element['label'])
					{
						$label = Text::_($groupLabel);
					}

					// Initialize the group if necessary.
					if (!isset($groups[$label]))
					{
						$groups[$label] = array();
					}

					// Iterate through the children and build an array of options.
					foreach ($element->children() as $option)
					{
						// Only add <option /> elements.
						if ($option->getName() != 'option')
						{
							continue;
						}

						$disabled = (string) $option['disabled'];
						$disabled = ($disabled == 'true' || $disabled == 'disabled' || $disabled == '1');

						// Create a new option object based on the <option /> element.
						$tmp = HTMLHelper::_(
							'select.option', ($option['value']) ? (string) $option['value'] : Text::_(trim((string) $option)),
							Text::_(trim((string) $option)), 'value', 'text', $disabled
						);

						// Set some option attributes.
						$tmp->class = (string) $option['class'];

						// Set some JavaScript option attributes.
						$tmp->onclick = (string) $option['onclick'];

						// Add the option.
						$groups[$label][] = $tmp;
					}

					if ($groupLabel)
					{
						$label = count($groups);
					}
					break;

				// Unknown element type.
				default:
					throw new \UnexpectedValueException(sprintf('Unsupported element %s in GroupedlistField', $element->getName()), 500);
			}
		}

		reset($groups);

		return $groups;
	}

	/**
	 * Method to get the field input markup fora grouped list.
	 * Multiselect is enabled by using the multiple attribute.
	 *
	 * @return  string  The field input markup.
	 *
	 * @since   1.7.0
	 */
	protected function getInput()
	{
		$html = array();
		$attr = '';

		// Initialize some field attributes.
		$attr .= !empty($this->class) ? ' class="custom-select ' . $this->class . '"' : ' class="custom-select"';
		$attr .= !empty($this->size) ? ' size="' . $this->size . '"' : '';
		$attr .= $this->multiple ? ' multiple' : '';
		$attr .= $this->required ? ' required' : '';
		$attr .= $this->autofocus ? ' autofocus' : '';

		// To avoid user's confusion, readonly="true" should imply disabled="true".
		if ($this->readonly || $this->disabled)
		{
			$attr .= ' disabled="disabled"';
		}

		// Initialize JavaScript field attributes.
		$attr .= !empty($this->onchange) ? ' onchange="' . $this->onchange . '"' : '';

		// Get the field groups.
		$groups = (array) $this->getGroups();

		// Create a read-only list (no name) with a hidden input to store the value.
		if ($this->readonly)
		{
			$html[] = HTMLHelper::_(
				'select.groupedlist', $groups, null,
				array(
					'list.attr' => $attr, 'id' => $this->id, 'list.select' => $this->value, 'group.items' => null, 'option.key.toHtml' => false,
					'option.text.toHtml' => false,
				)
			);

			// E.g. form field type tag sends $this->value as array
			if ($this->multiple && is_array($this->value))
			{
				if (!count($this->value))
				{
					$this->value[] = '';
				}

				foreach ($this->value as $value)
				{
					$html[] = '<input type="hidden" name="' . $this->name . '" value="' . htmlspecialchars($value, ENT_COMPAT, 'UTF-8') . '">';
				}
			}
			else
			{
				$html[] = '<input type="hidden" name="' . $this->name . '" value="' . htmlspecialchars($this->value, ENT_COMPAT, 'UTF-8') . '">';
			}
		}

		// Create a regular list.
		else
		{
			$html[] = HTMLHelper::_(
				'select.groupedlist', $groups, $this->name,
				array(
					'list.attr' => $attr, 'id' => $this->id, 'list.select' => $this->value, 'group.items' => null, 'option.key.toHtml' => false,
					'option.text.toHtml' => false,
				)
			);
		}

		return implode($html);
	}
}
