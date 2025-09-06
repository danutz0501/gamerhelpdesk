<?php 
/*
 * File: Collection.php
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

namespace GamerHelpDesk\Helper\Collection;
use IteratorAggregate;
use Countable;
use Traversable;

/**
 * Collection class
 * This class implements the IteratorAggregate and Countable interfaces.
 * It provides a way to manage a collection of items.
 * It can be used to store, iterate over, and count items.
 * 
 * @package GamerHelpDesk\Helper\Collection
 * @version 1.0.0
 */
class Collection implements IteratorAggregate, Countable
{
    /**
     * The items in the collection.
     * @var array
     */
    public function __construct( protected array $collection = []) {}

    /**
     * Implementing iterator aggregate interface
     * This method returns an iterator for the collection items.
     * @return \ArrayIterator
     */
    public function getIterator(): Traversable
    {
        return new \ArrayIterator($this->collection);
    }

    /**
     * Implementing countable interface
     * This method returns the number of items in the collection.
     * @return int
     */
    public function count(): int
    {
        return count($this->collection);
    }
}