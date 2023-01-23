<?php

namespace Raygun4php;

class RaygunClientMessage
{
    public $Name;
    public $Version;
    public $ClientUrl;

    public function __construct()
    {
        $this->Name = "Raygun4php";
        $this->Version = "2.1.1";
        $this->ClientUrl = "https://github.com/MindscapeHQ/raygun4php";
    }
}
