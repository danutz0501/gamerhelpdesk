<?php
/*
 * File: Registry.php
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

namespace GamerHelpDesk\Helper\Registry;

use GamerHelp\Helper\Container\Collection;
use GamerHelpDesk\Helper\Singleton\SingletonTrait;

/**
 * Class Registry
 * @package GamerHelpDesk\Helper\Registry
 */
class Registry extends Collection
{
    /**
     * Using the SingletonTrait to make the class a singleton.
     */
    use SingletonTrait;

    /**
     * Adds a key-value pair to the registry.
     *
     * @param string $key The key under which the value will be stored.
     * @param mixed $value The value to be stored in the registry.
     */
    public function add(string $key, mixed $value): void
    {
        $this->collection[$key] = $value;
    }

    /**
     * Retrieves the value associated with the given key.
     *
     * @param string $key The key of the value to retrieve.
     *
     * @return mixed The value associated with the given key or null if it doesn't exist.
     */
    public function get(string $key): mixed
    {
        return $this->collection[$key] ?? null;
    }

    /**
     * Removes the value associated with the given key from the registry.
     *
     * @param string $key The key of the value to remove.
     */
    public function remove(string $key): void
    {
        unset($this->collection[$key]);
    }

    /**
     * Checks if the given key exists in the registry.
     *
     * @param string $key The key to check.
     *
     * @return bool True if the key exists, false otherwise.
     */
    public function has(string $key): bool
    {
        return isset($this->collection[$key]);
    }
}