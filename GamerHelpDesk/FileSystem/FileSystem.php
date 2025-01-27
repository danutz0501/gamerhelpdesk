<?php
/*
 * File: FileSystem.php
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
declare(strict_types=1);

namespace GamerHelpDesk\FileSystem;

use GamerHelpDesk\FileSystem\File\File;
use GamerHelpDesk\FileSystem\Directory\Directory;

class FileSystem
{

    /**
     * Instance of File
     * @var File
     * @access private set
     * @access public get
     */
    public private(set) File $file
    {
        get
        {
            return $this->file;
        }
    }

    /**
     * Instance of Directory
     * @var Directory
     * @access private set
     * @access public get
     */
    public private(set) Directory $directory
    {
        get
        {
            return $this->directory;
        }
    }

    /**
     * Summary of __construct
     */
    public function __construct()
    {

    }

    /**
     * Create a File object
     * @param string $filename
     * @return File
     */
    public function createFileObject(string $filename): File
    {
        return $this->file = new File($filename);
    }

    /**
     * Create a Directory object
     * @param string $directory
     * @return Directory
     */
    public function createDirectoryObject(string $directory): Directory
    {
        return $this->directory = new Directory($directory);
    }
}

