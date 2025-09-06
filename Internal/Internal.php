<?php 
/*
 * File: Internal.php
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

namespace Internal;

use GamerHelpDesk\Http\Router\Router;
use GamerHelpDesk\Exception\
{
    GamerHelpDeskException,
    GamerHelpDeskExceptionEnum,
};
use GamerHelpDesk\View\View;

class Internal
{
    protected Router $router;

    public function __construct(public string $view_path = VIEW_PATH ."views". DIRECTORY_SEPARATOR,)
    {
        $this->router = Router::getInstance();
    }

    public function index()
    {
        $view = new View(view_name: $this->view_path .'internal');
        $view->assign(name: 'title', value: 'Internal');
        echo $view->render();
    }

    public function speedDial(): void
    {
        $view = new View(view_name: $this->view_path .'speed-dial');
        $view->assign(name: 'title', value: 'Speed Dial');
        echo $view->render();
    }

    public function services()
    {
        $view = new View(view_name: $this->view_path .'services');
        $view->assign(name: 'title', value: 'Services');
        echo $view->render();
    }

    public function notes()
    {
        $view = new View(view_name: $this->view_path .'notes');
        $view->assign(name: 'title', value: 'Notes');
        echo $view->render();
    }
}