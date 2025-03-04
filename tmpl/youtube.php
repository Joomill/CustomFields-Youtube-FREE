<?php

/*
 *  package: Custom Fields - Youtube plugin - FREE Version
 *  copyright: Copyright (c) 2023. Jeroen Moolenschot | Joomill
 *  license: GNU General Public License version 3 or later
 *  link: https://www.joomill-extensions.com
 */

// No direct access.
defined('_JEXEC') or die;

use Joomla\CMS\Factory;

//add stylesheet for responsive container
$document = Factory::getDocument();
$value    = $field->value;
$width    = $fieldParams->get('video_width');
$height   = $fieldParams->get('video_height');

if ($value == '')
{
	return;
}

echo '<iframe width="' . $width . '" height="' . $height . '" src="https://www.youtube.com/embed/' . $value . '" frameborder="0" allowfullscreen></iframe>';
