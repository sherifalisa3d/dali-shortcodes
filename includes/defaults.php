<?php

// ======================================================================== //		
// Define some constants for easy reference later
// ======================================================================== // 

    if(!defined('DALI_SHORTCODES_DIR')) {
        define('DALI_SHORTCODES_DIR', plugin_dir_path( __FILE__ ));
    }

    if(!defined('DALI_SHORTCODES_URL')) {
        define('DALI_SHORTCODES_URL', plugin_dir_url( __FILE__ ));
    }

// ======================================================================== // 

// Windows-proof constants: replace backward by forward slashes - thanks to: https://github.com/peterbouwmeester
//$fslashed_dir = trailingslashit(str_replace('\\','/', dirname(__FILE__)));
//$fslashed_abs = trailingslashit(str_replace('\\','/', ABSPATH));