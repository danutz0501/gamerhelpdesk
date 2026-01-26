<?php
/*
 * File: FileSYstem.php
 * Project: GamerHelpDesk
 * Created Date: January 2026
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

use GamerHelpDesk\Exception\
{
    GamerHelpDeskException,
    GamerHelpDeskExceptionEnum
};
use RecursiveDirectoryIterator;
use RecursiveIteratorIterator;

/**
 * FileSystem class
 */
class FileSystem
{
    
    /**
     * Reads the content of a file.
     *
     * @param string $filePath The path to the file.
     * @return string The content of the file.
     * @throws GamerHelpDeskException If the file does not exist or is not readable.
     */
    public function readFile(string $filePath): string
    {
        if (!file_exists($filePath)) 
        {
            throw new GamerHelpDeskException(case: GamerHelpDeskExceptionEnum::FileSystemException, custom_message:"File not found: " . $filePath);
        }

        if (!is_readable($filePath)) 
        {
            throw new GamerHelpDeskException(case: GamerHelpDeskExceptionEnum::FileSystemException, custom_message:"File is not readable: " . $filePath);
        }

        return file_get_contents($filePath);
    }

    /**
     * Writes content to a file.
     *
     * @param string $filePath The path to the file.
     * @param string $content The content to write.
     * @param bool $append Whether to append to the file (true) or overwrite (false).
     * @throws GamerHelpDeskException If the file cannot be written.
     */
    public function writeFile(string $filePath, string $content, bool $append = false): void
    {
        if ($append)
        {
            $content = $this->readFile($filePath) . $content;
        }
        $result = file_put_contents($filePath, $content);
        if ($result === false) 
        {
            throw new GamerHelpDeskException(case: GamerHelpDeskExceptionEnum::FileSystemException, custom_message:"Failed to write to file: " . $filePath);
        }
    }

    /**
     * Deletes a file securely within a specified base path.
     *
     * @param string $filePath The path to the file to delete.
     * @param string $allowedBasePath The base path within which the file deletion is allowed.
     * @throws GamerHelpDeskException If the file does not exist, is outside the allowed base path, or cannot be deleted.
     */
    public function deleteFile(string $filePath, string $allowedBasePath): void
    {
        $filePath        = realpath($filePath);
        $allowedBasePath = realpath($allowedBasePath);

        if (!file_exists($filePath)) 
        {
            throw new GamerHelpDeskException(case: GamerHelpDeskExceptionEnum::FileSystemException, custom_message:"File not found: " . $filePath);
        }

        if (strpos($filePath, $allowedBasePath) !== 0) 
        {
            throw new GamerHelpDeskException(case: GamerHelpDeskExceptionEnum::FileSystemException, custom_message:"Unauthorized file deletion attempt: " . $filePath);
        }

        if (!unlink($filePath)) 
        {
            throw new GamerHelpDeskException(case: GamerHelpDeskExceptionEnum::FileSystemException, custom_message:"Failed to delete file: " . $filePath);
        }
    }

    /**
     * Deletes a directory and its contents securely within a specified base path.
     *
     * @param string $directoryPath The path to the directory to delete.
     * @param string $allowedBasePath The base path within which the directory deletion is allowed.
     * @throws GamerHelpDeskException If the directory does not exist, is outside the allowed base path, or cannot be deleted.
     */
    public function deleteDirectory(string $directoryPath, string $allowedBasePath): void
    {
        $directoryPath    = realpath($directoryPath);
        $allowedBasePath  = realpath($allowedBasePath);

        if (!is_dir($directoryPath)) 
        {
            throw new GamerHelpDeskException(case: GamerHelpDeskExceptionEnum::FileSystemException, custom_message:"Directory not found: " . $directoryPath);
        }

        if (strpos($directoryPath, $allowedBasePath) !== 0) 
        {
            throw new GamerHelpDeskException(case: GamerHelpDeskExceptionEnum::FileSystemException, custom_message:"Unauthorized directory deletion attempt: " . $directoryPath);
        }

        $items = new RecursiveIteratorIterator(
            new RecursiveDirectoryIterator($directoryPath, RecursiveDirectoryIterator::SKIP_DOTS),
            RecursiveIteratorIterator::CHILD_FIRST
        );

        foreach ($items as $item) 
        {
            if ($item->isDir()) 
            {
                if(!rmdir($item->getPathname())) 
                {
                    throw new GamerHelpDeskException(case: GamerHelpDeskExceptionEnum::FileSystemException, custom_message:"Failed to delete directory: " . $item->getPathname());
                }
            }
            else 
            {
                if(!unlink($item->getPathname())) 
                {
                    throw new GamerHelpDeskException(case: GamerHelpDeskExceptionEnum::FileSystemException, custom_message:"Failed to delete file: " . $item->getPathname());
                }
            }
        }

        if(!rmdir($directoryPath))
            {
                throw new GamerHelpDeskException(case: GamerHelpDeskExceptionEnum::FileSystemException, custom_message:"Failed to delete directory: " . $directoryPath);
            }
    }

    /**
     * Creates a directory if it does not exist.
     *
     * @param string $directoryPath The path to the directory to create.
     * @param int $permissions The permissions to set on the directory.
     * @param bool $recursive Whether to create directories recursively.
     * @throws GamerHelpDeskException If the directory cannot be created.
     */
    public function createDirectory(string $directoryPath, int $permissions = 0755, bool $recursive = true): void
    {
        if (!is_dir($directoryPath)) 
        {
            if (!mkdir($directoryPath, $permissions, $recursive)) 
            {
                throw new GamerHelpDeskException(case: GamerHelpDeskExceptionEnum::FileSystemException, custom_message:"Failed to create directory: " . $directoryPath);
            }
        }
    }

    /**
     * Lists the files in a directory.
     *
     * @param string $directoryPath The path to the directory.
     * @return array An array of file paths.
     * @throws GamerHelpDeskException If the directory does not exist.
     */
    public function listFilesInDirectory(string $directoryPath): array
    {
        if (!is_dir($directoryPath)) 
        {
            throw new GamerHelpDeskException(case: GamerHelpDeskExceptionEnum::FileSystemException, custom_message:"Directory not found: " . $directoryPath);
        }

        $files = [];
        $dirIterator = new RecursiveDirectoryIterator($directoryPath, RecursiveDirectoryIterator::SKIP_DOTS);
        $iterator    = new RecursiveIteratorIterator($dirIterator);

        foreach ($iterator as $fileInfo) 
        {
            if ($fileInfo->isFile()) 
            {
                $files[] = $fileInfo->getPathname();
            }
        }

        return $files;
    }
}