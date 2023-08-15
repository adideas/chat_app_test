<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;

/**
 * Эта анотация написана для упрощения создания контролеров
 *
 * @method index()
 * @method edit()
 * @method store()
 * @method show()
 * @method update()
 * @method destroy()
 */
class Controller extends BaseController
{
    use AuthorizesRequests, ValidatesRequests;
}
