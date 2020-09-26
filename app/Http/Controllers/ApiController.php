<?php

namespace App\Http\Controllers;

use App\Traits\ApiResponser;
use Illuminate\Http\Request;

// como todas las clases heredan de esta, todas heredan Controller::class
class ApiController extends Controller
{
	use ApiResponser;
}
