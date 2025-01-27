<?php
/*
 * File: File.php
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

namespace GamerHelpDesk\FileSystem\File;

use SimpleXMLElement;
use SplFileObject;

class File extends SplFileObject
{
    /**
     * Summary of __construct
     * @param string $filename
     */
    public function __construct(private readonly string $filename)
    {
        parent::__construct(filename:$this->filename);
    }

    /**
     * A simple read function to read the file
     * @param string $filename
     * @return bool|string
     */
    public function read(string $filename): bool|string
    {
        if($this->isReadable())
        {
            return file_get_contents(filename: $this->filename);
        }
        return false;
    }

    /**
     * A simple write function to write to the file
     * @param string $filename
     * @param string $content
     * @return bool|int
     */
    public function write(string $filename, string $content): bool
    {
        if($this->isWritable())
        {
            return file_put_contents($this->filename, $content);
        }
        return false;
    }

    /**
     * A simple move function to move a file
     * @param string $filename
     * @param string $destination
     * @return bool
     */
    public function move(string $filename, string $destination): bool
    {
        return rename(from: $filename, to: $destination);
    }

    /**
     * A simple copy function to copy a file
     * @param string $filename
     * @param string $destination
     * @return bool
     */
    public function copy(string $filename, string $destination): bool
    {
        return copy(from:$filename, to: $destination);
    }

    /**
     * A simple delete function to delete a file
     * @param string $filename
     * @return bool
     */
    public function delete(string $filename): bool
    {
        return unlink($filename);
    }

    /**
     * A simple function to check if a file exists
     * @param string $filename
     * @return bool
     */
    public function exists(string $filename): bool
    {
        return file_exists(filename: $filename);
    }

    /**
     * Write a file with Gzip and Base64 encoding
     * @param string $filename
     * @param string $content
     * @return bool|int
     */
    public function writeGzipBase64(string $filename, string $content): bool
    {
        if($this->isWritable())
        {
            return file_put_contents(filename: $filename, data: base64_encode(string: gzencode($content)));
        }
        return false;
    }

    /**
     * Read a file with Gzip and Base64 encoding
     * @param string $filename
     * @return bool|string
     */
    public function readGzipBase64(string $filename): bool|string
    {
        if($this->isReadable())
        {
            return file_get_contents(filename: gzdecode(data: base64_decode(string: $filename)));
        }
        return false;
    }

    public function readXml(string $filename): bool|SimpleXMLElement
    {
        if($this->isReadable())
        {
            return simplexml_load_file(filename: $filename, class_name: 'SimpleXMLElement', options: LIBXML_NOCDATA);
        }
        return false;
    }

}