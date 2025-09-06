<?php 
/*
 * File: Stream.php
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

namespace Stream;

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
 * Stream class
 * 
 * 
 * @package GamerHelpDesk\Stream
 * @version 1.0.0
 */
class Stream 
{
    protected Router $router;
    public function __construct(public string $view_path = VIEW_PATH ."views". DIRECTORY_SEPARATOR)
    {
        $this->router = Router::getInstance();
    }

    #[RouteAttribute(verb: 'GET', route: '/stream', method: __METHOD__)]
    public function index(): void
    {
        echo "Stream index";
    }

    #[RouteAttribute(verb: 'GET', route: '/stream-starting', method: __METHOD__,)]
    public function streamStarting(): void
    {
        $view = new View(view_name: $this->view_path .'stream-starting');
        $view->assign(name: 'title', value: 'Stream starting');
        echo $view->render();
    }   

    #[RouteAttribute(verb: 'GET', route: '/stream-ending', method: __METHOD__)]
    public function streamEnding(): void
    {
        $view = new View(view_name: $this->view_path .'stream-ending');
        $view->assign(name: 'title', value: 'Stream ending');
        echo $view->render();
    }

    #[RouteAttribute(verb: 'GET', route: '/stream-brb', method: __METHOD__)]
    public function streamBrb(): void
    {
        $view = new View(view_name: $this->view_path .'stream-brb');
        $view->assign(name: 'title', value: 'Stream brb');
        echo $view->render();
    }

    #[RouteAttribute(verb: 'GET', route: '/stream-settings', method: __METHOD__)]
    public function streamSettings(): void
    {
        $view = new View(view_name: $this->view_path .'stream-settings');
        $view->assign(name: 'title', value: 'Stream settings');
        echo $view->render();
    }

    #[RouteAttribute(verb: 'GET', route: '/create-slideshow', method: __METHOD__)]
    public function createSlideshow(): void
    {
        $view = new View(view_name: $this->view_path .'create-slideshow');
        $view->assign(name: 'title', value: 'Create slideshow');
        echo $view->render();
    }

    #[RouteAttribute(verb: 'GET', route: '/upload-video', method: __METHOD__)]
    public function uploadVideo(): void
    {
        $view = new View(view_name: $this->view_path .'upload-video');
        $view->assign(name: 'title', value: 'Upload video');
        echo $view->render();
    }

    #[RouteAttribute(verb: 'GET', route: '/upload-image', method: __METHOD__)]
    public function uploadImage(): void
    {
        $view = new View(view_name: $this->view_path .'upload-image');
        $view->assign(name: 'title', value: 'Upload image');
        echo $view->render();
    }

    #[RouteAttribute(verb: 'GET', route: '/upload-audio', method: __METHOD__)]
    public function uploadAudio(): void
    {
        $view = new View(view_name: $this->view_path .'upload-audio');
        $view->assign(name: 'title', value: 'Upload audio');
        echo $view->render();
    }

    //#[RouteAttribute(verb: 'GET', route: '/stream/create/{#id :number}-{#name :string}', method: __METHOD__)]
    //public function create(...$list)
    //{
    //    \GamerHelpDesk\Helper\DebugHelper\DebugHelper::debug(data: $list);
    //    list($id, $name) = $list;
    //    
    //    echo "Stream create id = " . $id ." name = " . $name;
    //}
}