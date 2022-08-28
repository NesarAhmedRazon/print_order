<?php

/*
*
* @package PrintOrder
*
* Plugin Name: Thermal Printer
* Plugin URI: https://github.com/NesarAhmedRazon/print_order
* Description: This plugin will add Order printing button for Bluetooth Print App.
* Author: Nesar Ahmed
* Version: 0.0.2
* Author URI: https://github.com/NesarAhmedRazon/
* Text Domain: thermal-printer
*/

define(
    'PRINT_ORDER',
    __FILE__
);
require plugin_dir_path(PRINT_ORDER) . 'inc/routes.php';
require plugin_dir_path(PRINT_ORDER) . 'inc/ThermalPrinter.php';
 // Adds option under General Settings
