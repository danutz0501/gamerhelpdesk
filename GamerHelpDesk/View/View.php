<?php 
/*
 * File: View.php
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

namespace GamerHelpDesk\View;

use GamerHelpDesk\Exception\
{
    GamerHelpDeskException,
    GamerHelpDeskExceptionEnum,
};

/**
 * View class
 * A simple view handler for rendering PHP templates
 * @package GamerHelpDesk\View
 * @version 1.0.0
 */
class View 
{
    /**
     * View file name
     * @var string
     */
    protected string $view_name;
    
    /**
     * Check if view file exists and is readable, then set the view name.
     * If not, throw a GamerHelpDeskException InvalidArgumentException. 
     * @param string $view_name
     * @throws \GamerHelpDesk\Exception\GamerHelpDeskException
     */
    public function __construct(string $view_name = '', protected array $data = [])
    {
        $view_name .= '.php';
        if(file_exists(filename: $view_name) && is_readable(filename: $view_name))
        {
            $this->view_name = $view_name;
        }
        else
        {
            throw new GamerHelpDeskException(case: GamerHelpDeskExceptionEnum::InvalidArgumentException, custom_message: "View file not found: " . $view_name);
        }
    } 

    /**
     * Assign data to the view
     * @param string $name
     * @param mixed $value
     */
    public function assign(string $name, $value): void
    {
        $this->data[$name] = $value;
    }

    /**
     * Render the view and return the output as a string, or false on failure.
     * Just use echo to get output for now.
     * @return bool|string
     */
    public function render(): bool|string
    {
        extract(array: $this->data);
        ob_start();
        include_once $this->view_name;
        return ob_get_clean();
    }
}