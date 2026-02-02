<?php 
/*
 * File: FileTypeEnum.php
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

/**
 * FileTypeEnum class
 * This class defines an enumeration for different file types used in the GamerHelpDesk application.
 * It helps in categorizing and managing various file formats.
 * 
 * @package GamerHelpDesk\FileSystem
 * @version 1.0.0
 */
enum FileTypeEnum: string {
    case TXT  = "txt";
    case JSON = "json";
    case CSV  = "csv";
    case PDF  = "pdf";
    case XML  = "xml";
    case DOC  = "doc";
    case DOCX = "docx";
    case XLS  = "xls";
    case XLSX = "xlsx";
    case PNG  = "png";
    case JPG  = "jpg";
    case JPEG = "jpeg";
    case WEBP = "webp";
    case SVG  = "svg";
    case GIF  = "gif";
    case MP3  = "mp3";
    case OGG  = "ogg";
    case WAV  = "wav";
    case MP4  = "mp4";
    case WEBM = "webm";
    case ZIP  = "zip";
    case RAR  = "rar";
    /*
     * Get the string value of the file type.
     *
     * @return string The string representation of the file type.
     */
    public function getValue(): string {
        return $this->value;
    }

    /*
     * Get the file extension associated with the file type.
     *
     * @param FileTypeEnum $fileType The file type enumeration.
     * @return string The file extension.
     */
    public static function getExtension(FileTypeEnum $fileType): string {
        return match ($fileType) {
            FileTypeEnum::TXT  => 'txt',
            FileTypeEnum::JSON => 'json',
            FileTypeEnum::CSV  => 'csv',
            FileTypeEnum::PDF  => 'pdf',
            FileTypeEnum::XML  => 'xml',
            FileTypeEnum::DOC  => 'doc',
            FileTypeEnum::DOCX => 'docx',
            FileTypeEnum::XLS  => 'xls',
            FileTypeEnum::XLSX => 'xlsx',
            FileTypeEnum::PNG  => 'png',
            FileTypeEnum::JPG  => 'jpg',
            FileTypeEnum::JPEG => 'jpeg',
            FileTypeEnum::WEBP => 'webp',
            FileTypeEnum::SVG  => 'svg',
            FileTypeEnum::GIF  => 'gif',
            FileTypeEnum::MP3  => 'mp3',
            FileTypeEnum::OGG  => 'ogg',
            FileTypeEnum::WAV  => 'wav',
            FileTypeEnum::MP4  => 'mp4',
            FileTypeEnum::WEBM => 'webm',
            FileTypeEnum::ZIP  => 'zip',
            FileTypeEnum::RAR  => 'rar',
        };
    }
}