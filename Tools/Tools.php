<?php 
/*
 * File: Tools.php
 * Project: GamerHelpDesk
 * Created Date: September 2025
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

namespace Tools;

use GamerHelpDesk\Http\Router\
{
    RouteAttribute,
    Router
};
use GamerHelpDesk\Exception\
{
    GamerHelpDeskException,
    GamerHelpDeskExceptionEnum
};
use GamerHelpDesk\View\View;

/**
 * Tools class
 * 
 * 
 * @package Tools
 * @version 1.0.0
 */
class Tools
{
    public function __construct(public string $view_path = VIEW_PATH ."views". DIRECTORY_SEPARATOR)
    {
    }

    #[RouteAttribute(verb: 'GET', route: '/image-editor', method: __METHOD__)]
    public function imageEdit(): void
    {
        $view = new View(view_name: $this->view_path .'image-editor');
        $view->assign(name: 'title', value: 'Image edit');
        echo $view->render();
    }   

    #[RouteAttribute(verb: 'GET', route: '/back-up-database', method: __METHOD__)]
    public function backUpDatabase(): void
    {
        $view = new View(view_name: $this->view_path .'back-up-database');
        $view->assign(name: 'title', value: 'Back up database');
        echo $view->render();
    }

    #[RouteAttribute(verb: 'GET', route: '/back-up-media', method: __METHOD__)]
    public function BackUpFile(): void
    {
        $view = new View(view_name: $this->view_path .'back-up-media');
        $view->assign(name: 'title', value: 'Back up file');
        echo $view->render();
    }

    #[RouteAttribute(verb: 'GET', route: '/download-zip-files', method: __METHOD__)]
    public function downloadFiles(): void
    {
        $view = new View(view_name: $this->view_path .'download-zip-files');
        $view->assign(name: 'title', value: 'Download zip file');
        echo $view->render();
    }

    #[RouteAttribute(verb: 'GET', route: '/add-service', method: __METHOD__)]
    public function addService(): void
    {
        $view = new View(view_name: $this->view_path .'add-service');
        $view->assign(name: 'title', value: 'Add service');
        echo $view->render();
    }

    #[RouteAttribute(verb: 'GET', route: '/remove-service', method: __METHOD__)]
    public function removeService(): void
    {
        $view = new View(view_name: $this->view_path .'remove-service');
        $view->assign(name: 'title', value: 'Remove service');
        echo $view->render();
    }

    #[RouteAttribute(verb: 'GET', route: '/service-settings', method: __METHOD__)]
    public function serviceSettings(): void
    {
        $view = new View(view_name: $this->view_path .'service-settings');
        $view->assign(name: 'title', value: 'Service settings');
        echo $view->render();
    }
}