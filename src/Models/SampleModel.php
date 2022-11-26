<?php

namespace App\Models;

class SampleModel
{
    public readonly string $name;
    public readonly ChildModel $child;

    public function __construct(ChildModel $child)
    {
        $this->name = 'SampleModel';
        $this->child = $child;
    }
}