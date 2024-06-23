<?php
/*
 * File: Collection.php
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

namespace GamerHelp\Helper\Container;

/**
 * Implementing a simple collection class.
 */
class Collection implements \IteratorAggregate, \Countable
{
    /**
     * Constructor and initialization of the collection.
     *
     * @param  array $collection
     */
    public function __construct(protected array $collection = []){}
    
    /**
     * Implementing the IteratorAggregate interface.
     *
     * @return \Traversable
     */
    public function getIterator(): \Traversable
    {
        return new \ArrayIterator($this->collection);
    }

    /**
     * Implementing the Countable interface.
     *
     * @return integer
     */
    public function count(): int
    {
        return count($this->collection);
    }
}