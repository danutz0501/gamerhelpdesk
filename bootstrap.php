<?php
/*
 * File: bootstrap.php
 * Project: GamerHelpDesk
 * Created Date: June 2025
 * Author: M. Dumitru Daniel (danutz0501)
 * -----
 * Last Modified:
 * Modified By:
 * -----
 * Copyright (c) 2025 M. Dumitru Daniel (danutz0501)
 *  This program is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 * 
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 * 
 * You should have received a copy of the GNU General Public License
 * along with this program.  If not, see <https://www.gnu.org/licenses/>.
 */
/**
 * This file is the entry point for the framework.
 * It includes the autoloader and the configuration.
 * It also defines some base paths for our site.
 * Declaring strict types and some error reporting and display settings.
 */
declare(strict_types=1);

/**
 * Error reporting and display settings
 * Useful for debugging(using xdebug) and development.
 */
error_reporting(error_level: E_ALL);
ini_set(option: "display_errors",                  value: 1);
ini_set(option: "xdebug.var_display_max_depth",    value: "15");
ini_set(option: "xdebug.var_display_max_children", value: "256");
ini_set(option: "xdebug.var_display_max_data",     value: "1024");
/**
 * Timezone and internal encoding settings
 */
date_default_timezone_set(timezoneId: "Europe/Bucharest");
mb_internal_encoding(encoding: "UTF-8");

/**
 * Defining some base paths for our site
 */
define(constant_name: "BASE_PATH"          , value: realpath(__DIR__).DIRECTORY_SEPARATOR);
define(constant_name: "COMPOSER_PATH"      , value: BASE_PATH."vendor".DIRECTORY_SEPARATOR);
define(constant_name: "CONFIGURATION_PATH" , value: BASE_PATH."config".DIRECTORY_SEPARATOR);
define(constant_name: "ARCHIVE_PATH"       , value: BASE_PATH."Archive".DIRECTORY_SEPARATOR);
define(constant_name: "DATABASE_PATH"      , value: BASE_PATH."Database".DIRECTORY_SEPARATOR);
define(constant_name: "LOGS_PATH"          , value: BASE_PATH."logs".DIRECTORY_SEPARATOR);    
define(constant_name: "PUBLIC_PATH"        , value: BASE_PATH."www".DIRECTORY_SEPARATOR);
define(constant_name: "PYTHON_PATH"        , value: BASE_PATH."python".DIRECTORY_SEPARATOR);
define(constant_name: "VIEW_PATH"          , value: BASE_PATH."View".DIRECTORY_SEPARATOR);
define(constant_name: "MIDDLEWARE_PATH"    , value: BASE_PATH."Middleware".DIRECTORY_SEPARATOR);

/**
 * Starting the website
 */
try
{
    if(file_exists(filename: COMPOSER_PATH."autoload.php") && is_readable(filename: COMPOSER_PATH."autoload.php"))
    {
        require_once COMPOSER_PATH."autoload.php";
        new User();
    }
    else
    {
        throw new Exception(message: "Composer autoload file not found or cannot be read!!!", code: 0);
    }
} 
catch (Throwable $exception) 
{
    $exception = new ModernPHPException\ModernPHPException("exception_config.yaml");
    $exception->start();
    //echo $exception->getMessage()."<br/>";
    //echo $exception->getCode()."<br/>";
    //echo $exception->getFile()."<br/>";
    //echo $exception->getLine()."<br/>";
    //echo $exception->getTraceAsString()."<br/>";
    //echo $exception->getPrevious()."<br/>";
    //print_r($exception->getTrace())."<br/>";
    //echo $exception->__toString()."<br/>";
}
