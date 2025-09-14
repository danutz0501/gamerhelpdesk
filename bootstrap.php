<?php
/*
 * File: bootstrap.php
 * Project: GamerHelpDesk
 * Created Date: August 2025
 * Author: danutz0501 (M. Dumitru Daniel)
 * -----
 * Last Modified:
 * Modified By:
 * -----
 * Copyright (c) 2025 M. Dumitru Daniel (M. Dumitru Daniel)
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
declare(strict_types=1);

/**
 * Error reporting and display settings
 * Useful for debugging(using xdebug) and development.
 */
error_reporting(error_level: E_ALL);
ini_set(option: "display_errors",                  value: 1);
ini_set(option: "xdebug.var_display_max_depth",    value: "25");
ini_set(option: "xdebug.var_display_max_children", value: "512");
ini_set(option: "xdebug.var_display_max_data",     value: "2048");
/**
 * Timezone and internal encoding settings
 */
date_default_timezone_set(timezoneId: "Europe/Bucharest");
mb_internal_encoding(encoding: "UTF-8");

/**
 * Declaration of constants
 * Useful for the application configuration.
 */
define(constant_name: "APP_NAME",      value: "GamerHelpDesk");
define(constant_name: "APP_VERSION",   value: "1.0.0");
define(constant_name: "BASE_PATH",     value: realpath(path: __DIR__ ).DIRECTORY_SEPARATOR);
define(constant_name: "COMPOSER_PATH", value: BASE_PATH . "vendor" . DIRECTORY_SEPARATOR);
define(constant_name: "CONFIG_PATH",   value: BASE_PATH . "config" . DIRECTORY_SEPARATOR);
define(constant_name: "ARCHIVE_PATH",  value: BASE_PATH . "archive" . DIRECTORY_SEPARATOR);
define(constant_name: "DATABASE_PATH", value: BASE_PATH . "Database" . DIRECTORY_SEPARATOR);
define(constant_name: "VIEW_PATH",     value: BASE_PATH . "view" . DIRECTORY_SEPARATOR);
define(constant_name: "PUBLIC_PATH",   value: BASE_PATH . "www" . DIRECTORY_SEPARATOR);

/**
 * Include Composer's autoloader
 * This will automatically load all the required classes.
 */
try {
    if(file_exists(filename: COMPOSER_PATH . 'autoload.php') && is_readable(filename: COMPOSER_PATH . 'autoload.php'))
    {
        require_once COMPOSER_PATH . 'autoload.php';

        /**
         * Connect to the database
         */
        $database = \GamerHelpDesk\Database\Database::getInstance();
        $database->connect(path: DATABASE_PATH);

        /**
         * Register the router
         */
        $router = \GamerHelpDesk\Http\Router\Router::getInstance();

        $router->base_path = "/sites/gamerhelpdesk/www";

        $router->addAttributeRouteClass(attributes_class_array: ["Stream\\Stream", "Tools\\Tools"]);

        $router->addNamedRoute(verb: "GET", route: "/", method: "Internal\\Internal::index");
        $router->addNamedRoute(verb: "GET", route: "/internal", method: "Internal\\Internal::index");
        $router->addNamedRoute(verb: "GET", route: "/speed-dial", method: "Internal\\Internal::speedDial");
        $router->addNamedRoute(verb: "GET", route: "/services", method: "Internal\\Internal::services");
        $router->addNamedRoute(verb: "GET", route: "/notes", method: "Internal\\Internal::notes");
        /**
         * Run the router
         * This will start the application
         */
        $router->run();
    }
    else
    {
        throw new RuntimeException(message: "Composer autoloader not found at " . COMPOSER_PATH . 'autoload.php');
    }
} 
catch (Throwable $e) 
{
    //echo "Error loading Composer autoloader: " . $e->getMessage();
    echo "<br>";
    echo "<hr>";
    echo "<br>";
    echo "<div style='background-color: #f8d7da; color: #721c24; padding: 10px; border-radius: 5px;'><pre>";
    echo "Error: " . $e->getMessage();
    echo "<br>";
    echo "Code: " . $e->getCode();
    echo "<br>";
    echo "Type: " . get_class(object: $e);
    echo "<br>";
    echo "Message: " . $e->getMessage();
    echo "<br>";
    echo "File: " . $e->getFile();
    echo "<br>";
    echo "Line: " . $e->getLine();
    echo "<br>";
    echo "<hr>";
    echo "<br>";
    echo "Trace: <br>" . $e->getTraceAsString();
    echo "<br>";
    echo "<br></pre>";
    echo "</div>";
    exit(1);
}