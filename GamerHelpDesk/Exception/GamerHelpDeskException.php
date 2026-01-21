<?php 
/*
 * File: GamerHelpDeskException.php
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

use Exception;

/**
 * GamerHelpDeskException class
 * This class extends the base Exception class to provide a custom exception for the GamerHelpDesk application.
 * It can be used to handle specific errors related to the application.
 * 
 * @package GamerHelpDesk\Exception
 * @version 1.0.0
 */;
class GamerHelpDeskException extends Exception
{
    /**
     * Constructs a new instance of the GamerHelpDeskException class.
     * @param GamerHelpDeskExceptionEnum $case The exception case.
     * @param string $custom_message Message in exception
     */
    public function __construct(private readonly GamerHelpDeskExceptionEnum $case, private readonly string $custom_message)
    {
        match ($this->case)
        {
            GamerHelpDeskExceptionEnum::InvalidArgumentException => parent::__construct(message: sprintf( "BAD REQUEST - INVALID ARGUMENT %s " ,  $this->custom_message)),
            GamerHelpDeskExceptionEnum::InvalidPropertyException => parent::__construct(message: sprintf( "BAD REQUEST - INVALID PROPERTY %s " ,  $this->custom_message)),
            GamerHelpDeskExceptionEnum::InvalidMethodException   => parent::__construct(message: sprintf( "BAD REQUEST - INVALID METHOD %s "   ,  $this->custom_message)),
            GamerHelpDeskExceptionEnum::InvalidClassException    => parent::__construct(message: sprintf( "BAD REQUEST - INVALID CLASS %s "    ,  $this->custom_message)),
            GamerHelpDeskExceptionEnum::InvalidRangeException    => parent::__construct(message: sprintf( "BAD REQUEST - INVALID RANGE %s "    ,  $this->custom_message)),
            GamerHelpDeskExceptionEnum::InvalidPathException     => parent::__construct(message: sprintf( "BAD REQUEST - INVALID PATH %s "     ,  $this->custom_message)),
            GamerHelpDeskExceptionEnum::InvalidDateTimeException => parent::__construct(message: sprintf( "BAD REQUEST - INVALID DATE TIME %s ",  $this->custom_message)),
            GamerHelpDeskExceptionEnum::SystemException          => parent::__construct(message: sprintf( "BAD REQUEST - SYSTEM ERROR %s"      ,  $this->custom_message)),
            GamerHelpDeskExceptionEnum::FileSystemException      => parent::__construct(message: sprintf( "BAD REQUEST - FILE ERROR %s"        ,  $this->custom_message)),
            
            GamerHelpDeskExceptionEnum::RouteNotFoundException   => parent::__construct(message: sprintf( "BAD REQUEST - ROUTE NOT FOUND! %s"  ,  $this->custom_message)),
        };
    }
}
