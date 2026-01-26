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
     * Constructor for FileSystem class.
     */
    public function __construct()
    {

    }

    /**
     * Reads the content of a file.
     *
     * @param string $filePath The path to the file.
     * @return string The content of the file.
     * @throws GamerHelpDeskException If the file does not exist or is not readable.
     */
    public function readFile(string $filePath): string
    {
        if (!file_exists(filename: $filePath)) 
        {
            throw new GamerHelpDeskException(case: GamerHelpDeskExceptionEnum::FileSystemException, custom_message:"File not found: " . $filePath);
        }

        if (!is_readable(filename: $filePath)) 
        {
            throw new GamerHelpDeskException(case: GamerHelpDeskExceptionEnum::FileSystemException, custom_message:"File is not readable: " . $filePath);
        }

        return file_get_contents(filename: $filePath);
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
            $content = $this->readFile(filePath: $filePath) . $content;
        }
        $result = file_put_contents(filename: $filePath, data: $content);
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
        $filePath        = realpath(path: $filePath);
        $allowedBasePath = realpath(path: $allowedBasePath);

        if (!file_exists(filename: $filePath)) 
        {
            throw new GamerHelpDeskException(case: GamerHelpDeskExceptionEnum::FileSystemException, custom_message:"File not found: " . $filePath);
        }

        if (strpos(haystack: $filePath, needle: $allowedBasePath) !== 0) 
        {
            throw new GamerHelpDeskException(case: GamerHelpDeskExceptionEnum::FileSystemException, custom_message:"Unauthorized file deletion attempt: " . $filePath);
        }

        if (!unlink(filename: $filePath)) 
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
        $directoryPath    = realpath(path: $directoryPath);
        $allowedBasePath  = realpath(path: $allowedBasePath);

        if (!is_dir(filename: $directoryPath)) 
        {
            throw new GamerHelpDeskException(case: GamerHelpDeskExceptionEnum::FileSystemException, custom_message:"Directory not found: " . $directoryPath);
        }

        if (strpos(haystack: $directoryPath, needle: $allowedBasePath) !== 0) 
        {
            throw new GamerHelpDeskException(case: GamerHelpDeskExceptionEnum::FileSystemException, custom_message:"Unauthorized directory deletion attempt: " . $directoryPath);
        }

        $items = new RecursiveIteratorIterator(
            iterator: new RecursiveDirectoryIterator(directory: $directoryPath, flags: RecursiveDirectoryIterator::SKIP_DOTS),
            mode: RecursiveIteratorIterator::CHILD_FIRST
        );

        foreach ($items as $item) 
        {
            if ($item->isDir()) 
            {
                if(!rmdir(directory: $item->getPathname())) 
                {
                    throw new GamerHelpDeskException(case: GamerHelpDeskExceptionEnum::FileSystemException, custom_message:"Failed to delete directory: " . $item->getPathname());
                }
            }
            else 
            {
                if(!unlink(filename: $item->getPathname())) 
                {
                    throw new GamerHelpDeskException(case: GamerHelpDeskExceptionEnum::FileSystemException, custom_message:"Failed to delete file: " . $item->getPathname());
                }
            }
        }

        if(!rmdir(directory: $directoryPath))
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
        if (!is_dir(filename: $directoryPath)) 
        {
            if (!mkdir(directory: $directoryPath, permissions: $permissions, recursive: $recursive)) 
            {
                throw new GamerHelpDeskException(case: GamerHelpDeskExceptionEnum::FileSystemException, custom_message:"Failed to create directory: " . $directoryPath);
            }
        }
    }

    /**
     * Copies a file from source to destination.
     *
     * @param string $sourcePath The path to the source file.
     * @param string $destinationPath The path to the destination file.
     * @param bool $overwrite Whether to overwrite the destination file if it exists.
     * @throws GamerHelpDeskException If the source file does not exist, the destination file exists and overwrite is false, or the copy fails.
     */
    public function copyFile(string $sourcePath, string $destinationPath, bool $overwrite = false): void
    {
        if (!file_exists(filename: $sourcePath)) 
        {
            throw new GamerHelpDeskException(case: GamerHelpDeskExceptionEnum::FileSystemException, custom_message:"Source file not found: " . $sourcePath);
        }

        if (file_exists(filename: $destinationPath) && !$overwrite) 
        {
            throw new GamerHelpDeskException(case: GamerHelpDeskExceptionEnum::FileSystemException, custom_message:"Destination file already exists and overwrite is set to false: " . $destinationPath);
        }

        if (!is_dir(filename: dirname(path: $destinationPath))) 
        {
            throw new GamerHelpDeskException(case: GamerHelpDeskExceptionEnum::FileSystemException, custom_message:"Destination directory does not exist: " . dirname(path: $destinationPath));
        }

        if (!copy(from: $sourcePath, to: $destinationPath)) 
        {
            throw new GamerHelpDeskException(case: GamerHelpDeskExceptionEnum::FileSystemException, custom_message:"Failed to copy file from " . $sourcePath . " to " . $destinationPath);
        }
    }

    /**
     * Moves a file from source to destination.
     *
     * @param string $sourcePath The path to the source file.
     * @param string $destinationPath The path to the destination file.
     * @param bool $overwrite Whether to overwrite the destination file if it exists.
     * @param bool $retry Whether to retry the move operation using copy and delete if rename fails.
     * @throws GamerHelpDeskException If the source file does not exist, the destination file exists and overwrite is false, or the move fails.
     */
    public function moveFile(string $sourcePath, string $destinationPath, bool $overwrite = false, bool $retry = false): void
    {
        if (!file_exists(filename: $sourcePath)) 
        {
            throw new GamerHelpDeskException(case: GamerHelpDeskExceptionEnum::FileSystemException, custom_message:"Source file not found: " . $sourcePath);
        }

        if (file_exists(filename: $destinationPath) && !$overwrite) 
        {
            throw new GamerHelpDeskException(case: GamerHelpDeskExceptionEnum::FileSystemException, custom_message:"Destination file already exists and overwrite is set to false: " . $destinationPath);
        }

        if (!is_dir(filename: dirname(path: $destinationPath))) 
        {
            throw new GamerHelpDeskException(case: GamerHelpDeskExceptionEnum::FileSystemException, custom_message:"Destination directory does not exist: " . dirname(path: $destinationPath));
        }

        if (!rename(from: $sourcePath, to: $destinationPath) && !$retry) 
        {
            throw new GamerHelpDeskException(case: GamerHelpDeskExceptionEnum::FileSystemException, custom_message:"Failed to move file from " . $sourcePath . " to " . $destinationPath);
        }

        if($retry)
            {
                if (!copy(from: $sourcePath, to: $destinationPath) && !unlink(filename: $sourcePath)) 
                {
                    throw new GamerHelpDeskException(case: GamerHelpDeskExceptionEnum::FileSystemException, custom_message:"Failed to move file from " . $sourcePath . " to " . $destinationPath);
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
        if (!is_dir(filename: $directoryPath)) 
        {
            throw new GamerHelpDeskException(case: GamerHelpDeskExceptionEnum::FileSystemException, custom_message:"Directory not found: " . $directoryPath);
        }

        $files = [];
        $dirIterator = new RecursiveDirectoryIterator(directory: $directoryPath, flags: RecursiveDirectoryIterator::SKIP_DOTS);
        $iterator    = new RecursiveIteratorIterator(iterator: $dirIterator);

        foreach ($iterator as $fileInfo) 
        {
            if ($fileInfo->isFile()) 
            {
                $files[] = $fileInfo->getPathname();
            }
        }

        return $files;
    }

    /**
     * Lists the content (files and directories) in a directory.
     *
     * @param string $directoryPath The path to the directory.
     * @return array An array of file and directory paths.
     * @throws GamerHelpDeskException If the directory does not exist.
     */
    public function listContentInDirectory(string $directoryPath): array
    {
        if (!is_dir(filename: $directoryPath)) 
        {
            throw new GamerHelpDeskException(case: GamerHelpDeskExceptionEnum::FileSystemException, custom_message:"Directory not found: " . $directoryPath);
        }

        $contents = [];
        $dirIterator = new RecursiveDirectoryIterator(directory: $directoryPath, flags: RecursiveDirectoryIterator::SKIP_DOTS);
        $iterator    = new RecursiveIteratorIterator(iterator: $dirIterator, mode: RecursiveIteratorIterator::SELF_FIRST);

        foreach ($iterator as $fileInfo) 
        {
            $contents[] = $fileInfo->getPathname();
        }

        return $contents;
    }
}