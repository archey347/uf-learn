<?php
/**
 * Multisite setup for sub-directories or path based
 * URLs for subsites.
 *
 * DO NOT EDIT UNLESS YOU KNOW WHAT YOU ARE DOING!
 */

use Grav\Common\Filesystem\Folder;

// Get relative path from Grav root.
$path = !empty($_SERVER['PATH_INFO'])
   ? $_SERVER['PATH_INFO']
   : Folder::getRelativePath($_SERVER['REQUEST_URI'], ROOT_DIR);

// Extract name of subsite from path
$name = Folder::shift($path);

// If no sites is selected, default to latest
if (!$name || !is_dir(ROOT_DIR . "user/sites/{$name}")) {
    $name = '5.0';
}

// Prefix all pages with the name of the subsite
$prefix = ($name === '5.0') ? '' : "/{$name}";
$container['pages']->base($prefix);

return [
    'environment' => $name,
    'streams' => [
        'schemes' => [
            'user' => [
               'type' => 'ReadOnlyStream',
               'prefixes' => [
                   '' => ["user/sites/{$name}", "user"],
               ]
            ]
        ]
    ]
];
