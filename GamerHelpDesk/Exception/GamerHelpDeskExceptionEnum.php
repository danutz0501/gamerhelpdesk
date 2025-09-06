<?php 
/*
 * File: GamerHelpDeskExceptionEnum.php
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

namespace GamerHelpDesk\Exception;

/**
 * GamerHelpDeskExceptionEnum class
 * This class defines an enumeration for the different types of exceptions that can occur in the GamerHelpDesk application.
 * It is used to categorize exceptions and provide specific error messages.
 * 
 * @package GamerHelpDesk\Exception
 * @version 1.0.0
 */
enum GamerHelpDeskExceptionEnum: string
{
    case InvalidArgumentException = "InvalidArgumentException";
    case InvalidPropertyException = "InvalidPropertyException";
    case InvalidMethodException   = "InvalidMethodException";
    case InvalidClassException    = "InvalidClassException";
    case InvalidRangeException    = "InvalidRangeException";
    case InvalidPathException     = "InvalidPathException";
    case InvalidDateTimeException = "InvalidDateTimeException";
    case SystemException          = "SystemException";
    case FileSystemException      = "FileSystemException";
    
    case RouteNotFoundException   = "RouteNotFoundException";
}