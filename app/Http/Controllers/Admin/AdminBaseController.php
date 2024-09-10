<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class AdminBaseController extends Controller
{
    protected $pageTitle;
    protected $data = [];

    public function __construct()
    {
        $this->pageTitle = 'Default Title';
    }

    protected function setTitle($title)
    {
        $this->pageTitle = $title;
    }

    protected function getTitle()
    {
        return $this->pageTitle;
    }

    protected function prepareData()
    {
        return array_merge($this->data, ['pageTitle' => $this->getTitle()]);
    }
}