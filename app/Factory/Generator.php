<?php

namespace App\Factory;

class Generator
{
    private GeneratorInterface $generator;

    public function __construct(GeneratorInterface $generator)
    {
        $this->generator = $generator;
    }

    public function get($id, array $data)
    {
        return $this->generator->get($id, $data);
    }
}
