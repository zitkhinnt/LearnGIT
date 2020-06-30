<?php

namespace Modules\Horserace\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;

class HorseraceController extends Controller
{
  /**
   * Display a listing of the resource.
   * @return Response
   */
  public function index()
  {
    return view('horserace::index');
  }

  public function error()
  {
    return view('horserace::error.error');
  }


}
