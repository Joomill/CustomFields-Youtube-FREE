<?php
/**
 * Custom Fields - Youtube plugin for Joomla
 *
 * @author Joomill (info@joomill-extensions.com)
 * @copyright Copyright (c) 2017 Joomill
 * @license GNU Public License
 * @link https://www.joomill-extensions.com/
 */

defined('_JEXEC') or die;

$value = $field->value;
$width = $fieldParams->get('video_width');
$height = $fieldParams->get('video_height');

if ($value == '')
{
	return;
}

echo '<iframe width="' . $width . '" height="' . $height . '" src="https://www.youtube.com/embed/' . $value . '" frameborder="0" allowfullscreen></iframe>';
