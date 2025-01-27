<?php
/*
 * File: Cpu.php
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

namespace GamerHelpDesk\SystemInfo\Cpu;

use GamerHelpDesk\Exception\GamerHelpDeskException;
use GamerHelpDesk\Exception\GamerHelpDeskExceptionEnum;
use GamerHelpDesk\SystemInfo\Os\Os;

class Cpu
{

    /**
     * Array with CLI commands for each OS.
     * @var array
     */
    private array $cli =
    [
        "powershell" => "Powershell \"Get-Counter '\\Processor(*)\\% Processor Time' | Select -Expand Countersamples | Select InstanceName, CookedValue\"",
        "linux/unix" => "/proc/stat",
    ];

    /**
     * The OS of the system.
     * @var string
     */
    private readonly string $os;

    /**
     * The CPU usage of the system.
     * @access private set
     * @access public get
     * @var int|null
     */
    public private(set) ?int $cpu_usage
    {
        get
        {
            return $this->cpu_usage;
        }
    }

    /**
     * Summary of __construct
     */
    public function __construct()
    {
        $this->os = new Os()->os;
        $this->cpu_usage = $this->getCpuUsage();
        if (empty($this->cpu_usage)) {
            throw new GamerHelpDeskException(case: GamerHelpDeskExceptionEnum::SystemException, custom_message: "CPU usage cannot be read.");
        }
    }

    /**
     * Depends on the OS, it will run  the correct command to get the CPU usage.
     * @return int|null
     */
    private function getCpuUsage(): ?int
    {
        if ($this->os === "windows")
        {
            return $this->getCpuUsageWindows();
        }
        else
        {
            return $this->getCpuUsageLinuxUnix();
        }
    }

    /**
     * Run the command to get the CPU usage on Windows.
     * @return int|null
     */
    private function getCpuUsageWindows(): ?int
    {
        $output = shell_exec(command:  $this->cli["powershell"]);
        if ($output !== null)
        {
            return (int) explode(separator: ".", string: explode(separator: "_total", string: $output)[1])[0];;
        }

        return null;
    }

    /**
     * Run the command to get the CPU usage on Linux/Unix.
     * @return null|int
     */
    private function getCpuUsageLinuxUnix(): ?int
    {
        if (is_readable(filename: $this->cli["linux/unix"]))
        {
            // Collect 2 samples - each with 1-second period
            $stat_data1 = $this->readCpuUsageLinux();
            sleep(seconds: 1);
            $stat_data2 = $this->readCpuUsageLinux();

            if ((!is_null($stat_data1)) && (!is_null($stat_data2)))
            {
                // Get difference
                $stat_data2[0] -= $stat_data1[0];
                $stat_data2[1] -= $stat_data1[1];
                $stat_data2[2] -= $stat_data1[2];
                $stat_data2[3] -= $stat_data1[3];

                // Sum up the 4 values for User, Nice, System and Idle and calculate
                // the percentage of idle time (which is part of the 4 values!)
                $cpu_time = $stat_data2[0] + $stat_data2[1] + $stat_data2[2] + $stat_data2[3];

                // Invert percentage to get CPU time, not idle time
                $load = 100 - ($stat_data2[3] * 100 / $cpu_time);
            }
        }

        return null;
    }

    /**
     * Get the content of the file /proc/stat and parse it.
     * @return string[]|null
     */
    private function readCpuUsageLinux(): ?array
    {
        if (is_readable(filename: $this->cli["linux/unix"]))
        {
            $stats = @file_get_contents(filename: $this->cli["linux/unix"]);

            if ($stats !== false)
            {
                // Remove double spaces to make it easier to extract values with explode()
                $stats = preg_replace(pattern: "/[[:blank:]]+/", replacement: " ", subject: $stats);

                // Separate lines
                $stats = str_replace(search: array("\r\n", "\n\r", "\r"), replace: "\n", subject: $stats);
                $stats = explode(separator: "\n", string: $stats);

                // Separate values and find line for main CPU load
                foreach ($stats as $statLine)
                {
                    $statLineData = explode(separator: " ", string: trim($statLine));

                    // Found!
                    if ((count($statLineData) >= 5) && ($statLineData[0] == "cpu"))
                    {
                        return [$statLineData[1], $statLineData[2], $statLineData[3], $statLineData[4],];
                    }
                }
            }
        }

        return null;
    }
}