<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Validation\ValidatesRequests;
use App\Models\Slider;
use Illuminate\Support\Facades\View;
use Illuminate\Routing\Controller as BaseController;

class Controller extends BaseController
{
    use AuthorizesRequests, ValidatesRequests;
    protected $slider;
    public function __construct()
    {
        $this->slider = Slider::orderBy('slider_id','DESC')->where('slider_status','1')->take(4)->get();
        View::share([
            'slider' => $this->slider,
        ]);
    }
}
