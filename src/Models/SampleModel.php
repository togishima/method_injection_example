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

    public static function find(int $id): self
    {
        return new self(new ChildModel());
    }
}