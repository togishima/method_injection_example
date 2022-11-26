<?php

namespace App\Models;

class ChildModel
{
    public readonly string $childName; 

    public function __construct()
    {
        $this->name = 'ChildModel';
    }
}