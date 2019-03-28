<?php

namespace App;

use App\Controllers\ApiController;


class RequestHandler  {


    public static function handle() 
    {
        $request = $_REQUEST;

        $action = $_REQUEST['a'] ?? 'view';

        $controller = new ApiController($request);

        switch ($action) {
            case 'view':
            return $controller->index();
            break;

            case 'add':
            return $controller->store();
            break;

            case 'deleteAll':
            return $controller->deleteAll();
            break;
        }

    }
}