<?php
/*
 * File: SingletonTrait.php
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

namespace GamerHelpDesk\Helper\Singleton;

/**
 * Trait for implementing Singleton pattern
 * @package GamerHelpDesk\Helper\Singleton
 */
trait SingletonTrait
{
    /**
     * Variable to store the instance of the class
     *
     * @var self|null
     */
    private static self|null $instance = null;

    /**
     * Returning the instance of the class if already created or create a new instance
     *
     * @return self
     */
    public static function init(): self
    {
        return self::$instance??= new self();
    }
}