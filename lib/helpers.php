<?php
/**
 * Copyright (c) 2019. Obsidian Dev - All rights reserved
 * Unauthorized copying of this file, via any medium is strictly prohibited.
 * Written by Raphael Lisch <raphael.lisch@obsidian.fr>
 */


if (!function_exists('get_current_plugin_dirname')) {
    function get_current_plugin_dirname()
    {
        return basename(dirname(__DIR__));
    }
}