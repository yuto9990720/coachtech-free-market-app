<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;

// Laravel 10 の標準的な親コントローラー
class Controller extends BaseController
{
    use AuthorizesRequests, ValidatesRequests;
}