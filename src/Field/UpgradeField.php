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
// phpcs:disable PSR1.Files.SideEffects
defined('_JEXEC') or die;
// phpcs:enable PSR1.Files.SideEffects

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
