<?php

namespace App\Http\Controllers\web\v1;

use App\Http\Controllers\Controller;
use Illuminate\Contracts\View\View;

class IndexController extends Controller
{
    public function __invoke(): View
    {
        /**
         * @link resources/views/welcome.blade.php
         */
        return view('welcome');
    }
}
