<?php header('Content-Type: text/plain');

class TPostRepository {}

class TPostController
{
    public function __construct(protected TPostRepository $tPostRepository) {}
}

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

// first file
$container = new Container();
$container->bind('tPostRepository',  function () {
    return new TPostRepository();
});

$container->bind('tPostController',  function () use($container) {
    return new TPostController($container->get('tPostRepository'));
});

$tPostRepository = $container->get('tPostRepository');
$tPostController = $container->get('tPostController');

// second file
$tPostRepository2 = $container->get('tPostRepository');
$tPostController2 = $container->get('tPostController');

var_dump($tPostRepository);
var_dump($tPostRepository2);

var_dump($tPostController);
var_dump($tPostController2);
