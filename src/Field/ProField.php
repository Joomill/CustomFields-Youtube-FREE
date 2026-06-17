<?php
/*
 *  package: Custom Fields - Youtube plugin - FREE Version
 *  copyright: Copyright (c) 2026. Jeroen Moolenschot | Joomill
 *  license: GNU General Public License version 3 or later
 *  link: https://www.joomill-extensions.com
 */

namespace Joomill\Plugin\Fields\Youtube\Field;

// No direct access.
defined('_JEXEC') or die;

use Joomla\CMS\Factory;
use Joomla\CMS\Form\FormField;
use Joomla\CMS\Language\Text;

class ProField extends FormField
{
	protected $type = 'pro';

	protected static $styleLoaded = false;

	protected function getInput()
	{
		$this->loadStyle();

		return '<a class="btn btn-success btn-sm youtube-pro-badge"'
			. ' href="https://www.joomill-extensions.com/extensions/custom-fields-plugins"'
			. ' target="_blank" rel="noopener noreferrer">'
			. '<span class="icon-star icon-white" aria-hidden="true"></span> '
			. Text::_('PLG_FIELDS_YOUTUBE_PRO_ONLY')
			. '</a>';
	}

	protected function loadStyle(): void
	{
		if (self::$styleLoaded)
		{
			return;
		}

		self::$styleLoaded = true;

		Factory::getApplication()->getDocument()->getWebAssetManager()
			->addInlineStyle('.youtube-pro-badge[target="_blank"]::before{content:none !important;}.alert a[target="_blank"]::before{content:none !important;}');
	}
}
