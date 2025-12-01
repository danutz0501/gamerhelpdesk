<?php 
/*
 * File: FileTypeResponseEnum.php
 * Project: GamerHelpDesk
 * Created Date: December 2025
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

namespace GamerHelpDesk\Http\Response;

/**
 * FileTypeResponseEnum enum
 * Defines common file types for HTTP responses
 * @package GamerHelpDesk\Http\Response
 * @version 1.0.0
 */
enum FileTypeResponseEnum: string
{
    case JSON = 'application/json';
    case HTML = 'text/html';
    case XML = 'application/xml';
    case PLAIN = 'text/plain';
    case CSS = 'text/css';
    case JAVASCRIPT = 'application/javascript';
    case PDF = 'application/pdf';
    case ZIP = 'application/zip';
    case JPEG = 'image/jpeg';
    case PNG = 'image/png';
    case GIF = 'image/gif';

    /**
     *Returns the value of the current FileTypeResponseEnum type
     * @return string
     */
    public function getValue(): string
    {
        return $this->value;
    }

    /**
     *Returns the label for the current FileTypeResponseEnum type
     * @return string
     */
    public function label(): string
    {
        return static::getLabel(type: $this); 
    }

    /**
     * Returns the label for a given FileTypeResponseEnum type
     * @param FileTypeResponseEnum $type
     * @return string
     */
    public static function getLabel(FileTypeResponseEnum $type): string
    {
        return match($type) {
            FileTypeResponseEnum::JSON => 'application/json',
            FileTypeResponseEnum::HTML => 'text/html',
            FileTypeResponseEnum::XML => 'application/xml',
            FileTypeResponseEnum::PLAIN => 'text/plain',
            FileTypeResponseEnum::CSS => 'text/css',
            FileTypeResponseEnum::JAVASCRIPT => 'application/javascript',
            FileTypeResponseEnum::PDF => 'application/pdf',
            FileTypeResponseEnum::ZIP => 'application/zip',
            FileTypeResponseEnum::JPEG => 'image/jpeg',
            FileTypeResponseEnum::PNG => 'image/png',
            FileTypeResponseEnum::GIF => 'image/gif',
        };
    }
}