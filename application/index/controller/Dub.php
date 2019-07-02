<?php
namespace app\index\controller;

class Dub extends BaseHome
{
    public function index()
    {
        return $this->fetch();
    }
}