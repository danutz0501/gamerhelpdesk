<?php 
/*
 * File: DebugHelper.php
 * Project: GamerHelpDesk
 * Created Date: September 2025
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

namespace GamerHelpDesk\Helper\DebugHelper;

/**
 * DebugHelper class
 * Provides debugging utilities for the application.
 * @package GamerHelpDesk\Helper\DebugHelper\DebugHelper
 * @version 1.0.0
 */
class DebugHelper
{
    /**
     * Prints debug information in a readable format.
     * @param mixed $data
     * @return void
     */
    public static function debug($data)
    {
        echo "<div style='background-color: #f8d7da; color: #721c24; padding: 10px; border-radius: 5px;'><pre>";
        print_r($data);
        echo "</pre></div>";
    }

    /**
     * Dumps debug information and terminates the script.
     * @param mixed $data
     * @return void
     */
    public static function dd($data): never
    {
        self::debug($data);
        die();
    }
    

}