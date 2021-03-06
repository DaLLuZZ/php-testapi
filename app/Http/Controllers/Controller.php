<?php

namespace App\Http\Controllers;

use Laravel\Lumen\Routing\Controller as BaseController;

class Controller extends BaseController
{
    /**
     * Check the database response exists and
     * return 404 if it doesn't.
     *
     * @param mixed $databaseResponse
     */
    public function checkExists($databaseResponse): void
    {
        if (empty($databaseResponse)) {
            response()->json('Not Found', 404);
            die;
        }
    }
}
