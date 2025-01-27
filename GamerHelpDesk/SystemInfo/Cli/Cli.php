<?php
/*
 * File: Cli.php
 * Project: GamerHelpDesk
 * Created Date: January 2025
 * Author: M. Dumitru Daniel (M. Dumitru Daniel)
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

namespace GamerHelpDesk\SystemInfo\Cli;

class Cli
{
    /**
     * Store the result of the check if the script is running in a CLI environment.
     * @var bool $check_if_is_cli
     * @access private set
     * @access public get
     */
    public private(set) bool $check_if_is_cli
    {
        get
        {
            return $this->check_if_is_cli;
        }
    }

    /**
     * Summary of __construct
     */
    public function __construct()
    {
        $this->check_if_is_cli = $this->isCli();
    }

    /**
     * Check if the script is running in a CLI environment.
     * @return bool
     */
    private function isCli(): bool
    {
        if (defined(constant_name: "STDIN"))
        {
            return true;
        }
        if (php_sapi_name() === "cli")
        {
            return true;
        }
        if (PHP_SAPI === "cli")
        {
            return true;
        }
        if (stristr(haystack: PHP_SAPI, needle: "cgi") && getenv(name: "TERM"))
        {
            return true;
        }
        if (empty($_SERVER["REMOTE_ADDR"]) && !isset($_SERVER["HTTP_USER_AGENT"]) && count(value: (array) $_SERVER["argv"]) > 0)
        {
            return true;
        }

        return false;
    }
}