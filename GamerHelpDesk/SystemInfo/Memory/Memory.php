<?php
/*
 * File: Memory.php
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

namespace GamerHelpDesk\SystemInfo\Memory;

use GamerHelpDesk\Exception\GamerHelpDeskException;
use GamerHelpDesk\Exception\GamerHelpDeskExceptionEnum;
use GamerHelpDesk\SystemInfo\Os\Os;

/**
 *
 */
class Memory
{

    /**
     * Array with CLI commands for each OS.
     * @var array
     */
    private array $cli =
    [
        "windows"    =>
        [
            "total" => "PowerShell (Get-CimInstance -ClassName Win32_ComputerSystem).TotalPhysicalMemory",
            "free"  => "PowerShell (Get-CimInstance -ClassName Win32_OperatingSystem).FreePhysicalMemory * 1KB",
        ],
        "linux/unix" => "/proc/meminfo",
    ];

    /**
     * The OS of the system.
     * @var string
     */
    private readonly string $os;

    /**
     * The memory usage of the system.
     * @access private set
     * @access public get
     * @var int|null
     */
    public private(set) ?int $memory_used
    {
        get
        {
            return $this->memory_used;
        }
    }

    /**
     * The free memory of the system.
     * @access private set
     * @access public get
     * @var int|null
     */
    public private(set) ?int $memory_free
    {
        get
        {
            return $this->memory_free;
        }
    }

    /**
     * The total memory of the system.
     * @access private set
     * @access public get
     * @var int|null
     */
    public private(set) ?int $memory_capacity
    {
        get
        {
            return $this->memory_capacity;
        }
    }

    /**
     * Summary of __construct
     * @throws \GamerHelpDesk\Exception\GamerHelpDeskException
     */
    public function __construct()
    {
        $this->os = new Os()->os;
        $this->memory_capacity = $this->getMemoryCapacity();
        if (empty($this->memory_capacity))
        {
            throw new GamerHelpDeskException(case: GamerHelpDeskExceptionEnum::SystemException, custom_message: "Memory Capacity cannot be read");
        }
        $this->memory_free = $this->getMemoryFree();
        $this->memory_used = $this->getMemoryUsed();
    }

    /**
     * Check the OS and get the memory capacity using the correct command.
     * @return int|null
     */
    private function getMemoryCapacity(): ?int
    {
        if ($this->os === "windows")
        {
            return $this->getMemoryCapacityWindows();
        }
        else
        {
            return $this->getMemoryCapacityLinuxUnix();
        }
    }

    /**
     * Check the OS and get the used memory using the correct command.
     * @return int|null
     */
    private function getMemoryUsed(): ?int
    {
        if ($this->os === "windows")
        {
            return $this->getMemoryUsedWindows();
        }
        else
        {
            return $this->getMemoryUsedLinuxUnix();
        }
    }

    /**
     * Check the OS and get the free memory using the correct command.
     * @return int|null
     */
    private function getMemoryFree(): ?int
    {
        if ($this->os === "windows")
        {
            return $this->getMemoryFreeWindows();
        }
        else
        {
            return $this->getMemoryFreeLinuxUnix();
        }
    }

    /**
     * Get the capacity of memory on windows
     * @return int|null
     */
    private function getMemoryCapacityWindows(): ?int
    {
        $output = shell_exec(command: $this->cli["windows"]["total"]);
        if ($output !== null)
        {
            return (int) $output;
        }
        return null;
    }

    /**
     * Calculate the used memory on windows, the total capacity minus the free memory
     * @return int|null
     */
    private function getMemoryUsedWindows(): ?int
    {
        return $this->memory_capacity - $this->memory_free;
    }

    /**
     * Get the amount of free memory on windows
     * @return int|null
     */
    private function getMemoryFreeWindows(): ?int
    {
        $output = shell_exec(command: $this->cli["windows"]["free"]);
        if ($output !== null)
        {
            return (int) $output;
        }
        return null;
    }

    /**
     * Get the capacity of memory on *nix
     * @return int|null
     */
    private function getMemoryCapacityLinuxUnix(): ?int
    {
        $stats = $this->linuxHelper();
        foreach ($stats as $stat_line)
        {
            $stat_line_data = explode(separator: ":", string: trim(string: $stat_line));
            // Total memory
            if (count(value: $stat_line_data) == 2 && trim(string: $stat_line_data[0]) == "MemTotal")
            {
                $memory_total = trim(string: $stat_line_data[1]);
                $memory_total = explode(separator:  " ", string:  $memory_total);
                return  (int) $memory_total[0];
            }
        }
        return null;
    }

    /**
     * Get the amount of used memory on *nix
     * @return int|null
     */
    private function getMemoryUsedLinuxUnix(): ?int
    {
        return $this->memory_capacity - $this->memory_free;
    }

    private function getMemoryFreeLinuxUnix(): ?int
    {
        $stats = $this->linuxHelper();
        foreach ($stats as $stat_line)
        {
            $stat_line_data = explode(separator: ":", string: trim(string: $stat_line));
            // Free memory
            if (count(value: $stat_line_data) == 2 && trim(string: $stat_line_data[0]) == "MemFree")
            {
                $memory_free = trim(string: $stat_line_data[1]);
                $memory_free = explode(separator: " ", string: $memory_free);
                return (int) $memory_free[0];
            }
        }
        return null;
    }

    /**
     * Calculate the used memory, total amount minus the free one
     * @return int|null
     */
    private function getAMemoryUsedLinuxUnix(): ?int
    {
        return $this->memory_capacity - $this->memory_free;
    }

    /**
     * A little helper for nix, some string replacement,
     * still have to do some refactoring to reduce duplicate code in *nix methods
     * @return array|null
     */
    private function linuxHelper(): ?array
    {
        if (is_readable(filename: $this->cli["linux/unix"]))
        {
            $stats = @file_get_contents(filename: $this->cli["linux/unix"] );
            if ($stats !== false)
            {
                // Separate lines
                $stats = str_replace(search:array("\r\n", "\n\r", "\r"), replace:"\n", subject: $stats);
                $stats = explode(separator:"\n", string: $stats);
            }
            return $stats;
        }
        return null;
    }
}
//TODO: refactor *nix methods to reduce duplicate code