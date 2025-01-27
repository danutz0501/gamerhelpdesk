<?php 
/*
 * File: Directory.php
 * Project: GamerHelpDesk
 * Created Date: January 2025
 * Author: M. Dumitru Daniel (M. Dumitru Daniel)
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
declare(strict_types = 1);

namespace GamerHelpDesk\FileSystem\Directory;

use FilesystemIterator; 
use RecursiveDirectoryIterator;
use RecursiveIteratorIterator;
use RegexIterator;
use CallbackFilterIterator;
use RecursiveCallbackFilterIterator;

class Directory extends RecursiveDirectoryIterator
{
    /**
     * Instance of RecursiveIteratorIterator
     * @var RecursiveIteratorIterator
     */
    private RecursiveIteratorIterator $iterator;
    /**
     * Summary of __construct
     * @param string $directory
     */
    public function __construct(private readonly string $directory)
    {
        parent::__construct(directory: $this->directory);
        $this->setFlags(flags:FilesystemIterator::SKIP_DOTS|FilesystemIterator::UNIX_PATHS);
    }

    /**
     * Set the maximum depth of the iterator
     * @param int $maxDepth
     * @return void
     */
    public function setMaxDepth(int $maxDepth): void
    {
        $this->iterator->setMaxDepth(maxDepth: $maxDepth);
    }

    /**
     * Filter files with a regex
     * @param string $regex
     * @return RecursiveIteratorIterator<RegexIterator>
     */
    public function filterWithRegex(string $regex): RecursiveIteratorIterator
    {
        return $this->iterator = new RecursiveIteratorIterator(iterator: new RegexIterator(iterator: $this->iterator, pattern: $regex));
    }

    /**
     * Filter files with a callback
     * @param callable $callback
     * @return RecursiveIteratorIterator<CallbackFilterIterator>
     */
    public function filterWithCallbackSimple(callable $callback): RecursiveIteratorIterator
    {
        return $this->iterator = new RecursiveIteratorIterator(iterator: new CallbackFilterIterator(iterator: $this->iterator, callback: $callback));
    }

    /**
     * Filter files recursively with a callback
     * @param callable $callback
     * @return RecursiveIteratorIterator<RecursiveCallbackFilterIterator>
     */
    public function filterWithCallbackRecursive(callable $callback): RecursiveIteratorIterator
    {
        return $this->iterator = new RecursiveIteratorIterator(iterator: new RecursiveCallbackFilterIterator(iterator: $this, callback: $callback));
    }
    /**
     * List files and folders
     * @return RecursiveIteratorIterator<Directory>
     */
    public function listFilesAndFolders(): RecursiveIteratorIterator
    {
        return $this->iterator  = new RecursiveIteratorIterator(iterator: $this, mode: RecursiveIteratorIterator::SELF_FIRST);
    }
    
}