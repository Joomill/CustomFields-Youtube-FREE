<?php

/**
 * Custom Fields - YouTube
 *
 * @copyright   Copyright (c) 2026 Jeroen Moolenschot | Joomill
 * @license     GNU General Public License version 3 or later; see LICENSE
 * @link        https://www.joomill-extensions.com
 */

// No direct access.
\defined('_JEXEC') or die;

/** @var \Joomla\Component\Fields\Administrator\Plugin\FieldsPlugin $this */

$raw = trim((string) $field->value);

if ($raw === '') {
    return;
}

// Resolve the YouTube video ID from a plain ID or any common YouTube URL
// (watch?v=, youtu.be/, /embed/, /shorts/, /live/).
$id = '';

if (preg_match('~^[A-Za-z0-9_-]{11}$~', $raw)) {
    $id = $raw;
} elseif (preg_match('~(?:youtu\.be/|youtube(?:-nocookie)?\.com/(?:watch\?(?:.*&)?v=|embed/|shorts/|live/|v/))([A-Za-z0-9_-]{11})~i', $raw, $m)) {
    $id = $m[1];
}

if ($id === '') {
    return;
}

// Player parameters (only the dimensions and privacy mode are functional in FREE).
$width  = htmlspecialchars((string) $fieldParams->get('video_width', '100%'), ENT_QUOTES);
$height = htmlspecialchars((string) $fieldParams->get('video_height', ''), ENT_QUOTES);

// Privacy-enhanced mode: serve the embed from youtube-nocookie.com so YouTube
// does not store cookies / tracking information until the visitor plays the video.
$host = (int) $fieldParams->get('nocookie', 0) === 1
    ? 'https://www.youtube-nocookie.com'
    : 'https://www.youtube.com';

$src = $host . '/embed/' . $id;

echo '<iframe src="' . htmlspecialchars($src, ENT_QUOTES) . '"'
    . ' width="' . $width . '" height="' . $height . '"'
    . ' style="border:0;" loading="lazy"'
    . ' allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share"'
    . ' allowfullscreen title="YouTube video player"></iframe>';
