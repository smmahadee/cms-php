<?php

namespace App\Support;

class Container
{
    private array $instances = [];
    private array $recipies = [];

    public function bind(string $what, \Closure $recipe) {
        $this->recipies[$what] = $recipe;
    }

    public function get($what)
    {
        if (empty($this->instances[$what])) {
            if(empty($this->recipies[$what])) {
                echo "Could not build: {$what}.\n";
                die();
            }
            $this->instances[$what] = $this->recipies[$what]();
        }

        return $this->instances[$what];
    }
}