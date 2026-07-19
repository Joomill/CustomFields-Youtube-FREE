<?php

/**
 * Custom Fields - YouTube
 *
 * @copyright   Copyright (c) 2026 Jeroen Moolenschot | Joomill
 * @license     GNU General Public License version 3 or later; see LICENSE
 * @link        https://www.joomill-extensions.com
 */

namespace Joomill\Plugin\Fields\Youtube\Field;

// No direct access.
defined('_JEXEC') or die;

use Joomla\CMS\Form\FormField;
use Joomla\CMS\Language\Text;

class UpgradeField extends FormField
{
	protected $type = 'upgrade';

	protected function getInput()
	{
		return Text::_('PLG_FIELDS_YOUTUBE_UPGRADE_DESC');
	}
}
