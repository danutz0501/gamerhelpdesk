<?php
/*
 * File: FilterByExtension.php
 * Project: GamerHelpDesk
 * Created Date: February 2026
 * Author: danutz0501 (M. Dumitru Daniel)
 * -----
 * Last Modified:
 * Modified By:
 * -----
 * Copyright (c) 2026 M. Dumitru Daniel (M. Dumitru Daniel)
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

namespace GamerHelpDesk\FileSystem;

use RecursiveFilterIterator;
use RecursiveIterator;

class FilterByExtension extends RecursiveFilterIterator
{
    protected array $allowedExtensions;

    public function __construct(RecursiveIterator $iterator, array|string $allowedExtensions)
    {
        parent::__construct(iterator: $iterator);
        $this->allowedExtensions = is_array(value: $allowedExtensions) ? $allowedExtensions : [$allowedExtensions];
    }

    public function accept(): bool
    {
    
        if ($this->hasChildren()) 
        {
            return true;
        }

        return $this->current()->isFile() && 
                in_array(needle: strtolower(string: $this->current()->getExtension()), haystack: $this->allowedExtensions);
}

    public function getChildren(): self
    {
        return new self(iterator: $this->getInnerIterator()->getChildren(), allowedExtensions: $this->allowedExtensions);
    }
}