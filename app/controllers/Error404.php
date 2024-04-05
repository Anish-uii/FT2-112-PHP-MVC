<?php
class Error404
{
    use Controller;
    public function index()
    {
        $this->view("error404");
    }
}