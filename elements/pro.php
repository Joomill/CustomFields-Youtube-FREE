<?php
/*
 *  package: Custom Fields - Youtube plugin - FREE Version
 *  copyright: Copyright (c) 2021. Jeroen Moolenschot | Joomill
 *  license: GNU General Public License version 3 or later
 *  link: https://www.joomill-extensions.com
 */

// No direct access.
defined('_JEXEC') or die;

use Joomla\CMS\Language\Text;

class JFormFieldPRO extends JFormField
{
	protected $type = 'pro';

	protected function getInput()
	{
		$text = Text::_('PLG_FIELDS_YOUTUBE_PARAMS_PRO_ONLY');
		return
			'<code>' . $text . '</code>';
	}
}
