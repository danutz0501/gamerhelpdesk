<?php
/*
 * File: SingletonTrait.php
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

namespace GamerHelpDesk\Helper\SingletonTrait;

/**
 * SingletonTrait
 * This trait provides a simple implementation of the Singleton design pattern.
 * It ensures that a class has only one instance and provides a global point of access to it.
 * 
 * @package GamerHelpDesk\Helper\SingletonTrait
 * @version 1.0.0
 */
trait SingletonTrait
{
    /**
     * The instance of the singleton class.
     * @var static|null
     */
    private static ?self $instance = null;

    /**
     * Get the instance of the singleton class.
     * If the instance does not exist, it will be created.
     * @return static
     */
    public static function getInstance(): self
    {
        return self::$instance ??= new self();
    }
}