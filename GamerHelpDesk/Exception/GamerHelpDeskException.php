<?php
/*
 * File: GamerHelpDeskException.php
 * Project: GamerHelpDesk
 * Created Date: June 2024
 * Author: M. Dumitru Daniel (danutz0501)
 * -----
 * Last Modified:
 * Modified By:
 * -----
 * Copyright (c) 2024 M. Dumitru Daniel (danutz0501)
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
 * Internal exception class for GamerHelpDesk
 * @package GamerHelpDesk\Exception
 */
class GamerHelpDeskException extends \Exception
{
    /**
     * Constructs a new instance of the GamerHelpDeskException class.
     * @param GamerHelpDeskExceptionEnum $case The exception case.
     * @param string $custom_message Message in exception
     */
    public function __construct(private readonly GamerHelpDeskExceptionEnum $case, private readonly string $custom_message = "")
    {
        match ($this->case)
        {
            GamerHelpDeskExceptionEnum::InvalidArgumentException => parent::__construct(message: sprintf(format: "BAD REQUEST - INVALID ARGUMENT %s ", values: $this->custom_message)),
            GamerHelpDeskExceptionEnum::InvalidPropertyException => parent::__construct(message: sprintf(format: "BAD REQUEST - INVALID PROPERTY %s ", values: $this->custom_message)),
            GamerHelpDeskExceptionEnum::InvalidMethodException   => parent::__construct(message: sprintf(format: "BAD REQUEST - INVALID METHOD %s ", values: $this->custom_message)),
            GamerHelpDeskExceptionEnum::InvalidClassException    => parent::__construct(message: sprintf(format: "BAD REQUEST - INVALID CLASS %s ", values: $this->custom_message)),
            GamerHelpDeskExceptionEnum::InvalidRangeException    => parent::__construct(message: sprintf(format: "BAD REQUEST - INVALID RANGE %s ", values: $this->custom_message)),
            GamerHelpDeskExceptionEnum::InvalidPathException     => parent::__construct(message: sprintf(format: "BAD REQUEST - INVALID PATH %s ", values: $this->custom_message)),
            GamerHelpDeskExceptionEnum::InvalidDateTimeException => parent::__construct(message: sprintf(format: "BAD REQUEST - INVALID DATE TIME %s ", values: $this->custom_message)),
            GamerHelpDeskExceptionEnum::SystemException          => parent::__construct(message: sprintf(format: "BAD REQUEST - SYSTEM ERROR %s", values: $this->custom_message)),
            GamerHelpDeskExceptionEnum::FileSystemException      => parent::__construct(message: sprintf(format: "BAD REQUEST - FILE ERROR %s", values: $this->custom_message)),
            
            GamerHelpDeskExceptionEnum::RouteNotFoundException   => parent::__construct(message: "BAD REQUEST - ROUTE NOT FOUND!", code: 404),
        };
    }
}