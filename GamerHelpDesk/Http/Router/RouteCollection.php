<?php
/*
 * File: RouteCollection.php
 * Project: GamerHelpDesk
 * Created Date: June 2025
 * Author: M. Dumitru Daniel (danutz0501)
 * -----
 * Last Modified:
 * Modified By:
 * -----
 * Copyright (c) 2025 M. Dumitru Daniel (danutz0501)
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

namespace GamerHelpDesk\Http\Router;

/**
 * Custom route collection 
 * @package GamerHelpDesk\Http\Router
 */
class RouteCollection extends \GamerHelp\Helper\Container\Collection
{
    /**
     * Adds a route to the collection.
     *
     * @param Route $route The route to add.
     */
    public function add(Route $route): void
    {
        $this->collection[] = $route;
    }
}