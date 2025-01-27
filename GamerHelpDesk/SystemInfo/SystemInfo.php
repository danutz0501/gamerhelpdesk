<?php
/*
 * File: System.php
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

namespace GamerHelpDesk\SystemInfo;

use GamerHelpDesk\Exception\GamerHelpDeskException;
use GamerHelpDesk\Exception\GamerHelpDeskExceptionEnum;
use GamerHelpDesk\SystemInfo\Cli\Cli;
use GamerHelpDesk\SystemInfo\Cpu\Cpu;
use GamerHelpDesk\SystemInfo\Memory\Memory;
use GamerHelpDesk\SystemInfo\Os\Os;

class SystemInfo
{
    /**
     * Instance of Cli
     * @var Cli
     * @access private set
     * @access public get
     */
    public private(set) Cli $cli
    {
        get
        {
            return $this->cli;
        }
        
    }

    /**
     * Instance of Os
     * @var Os
     * @access private set
     * @access public get
     */
    public private(set) Os $os
    {
        get
        {
            return $this->os;
        }
    }

    /**
     * Instance of Cpu
     * @var Cpu
     * @access private set
     * @access public get
     */
    public private(set) ?Cpu $cpu
    {
        get
        {
            return $this->cpu;
        }
    }

    /**
     * Instance of Memory
     * @var Memory
     * @access private set
     * @access public get
     */
    public private(set) ?Memory $memory
    {
        get
        {
            return $this->memory;
        }
    }

    /**
     * Summary of __construct
     */
    public function __construct()
    {
        $this->cli = new Cli();
        $this->os  = new Os();
    }

    /**
     * Check if the shell command is enabled and get the system resources.
     * @throws \GamerHelpDesk\Exception\GamerHelpDeskException
     * @return void
     */
    public function checkSystemResources(): void
    {
        if ($this->checkShellCommand())
        {
            $this->cpu    = new Cpu();
            $this->memory = new Memory();
        }
        else
        {
            throw new GamerHelpDeskException(case: GamerHelpDeskExceptionEnum::SystemException, custom_message: "Shell command not enabled.");

        }
    }
    
    /**
     * Check if the shell command is enabled.
     * @return bool
     */
    private function checkShellCommand(): bool
    {
        return function_exists(function: "shell_exec");
    }
}