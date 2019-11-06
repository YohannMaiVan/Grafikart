<?php
require 'vendor/autoload.php';

die($_GET['url']);

$router = new App\Router\Router($_GET['url']);

$router->get('/', function() {echo "Homepage";});
$router->get('/posts', function() { echo 'Tous les articles'; });
$router->get('/posts/:slug-:id', function($slug, $id) use($router) { echo $router->url('posts.show', ['id' => 1, 'slug' => 'salut-les-gens']); }, 'posts.show')->with('id', '[0-9]+')->with('slug', '[a-z\-0-9]+');
$router->get('/posts/:id', function($id) { 
    ?>
        <form action="" method="POST">
            <input type="text" name="name">
            <button type="submit">Envoyer</button>
        </form>
    <?php
});
$router->post('/posts/:id', function($id) { echo 'Poster pour l\'article ' . $id; });

$router->run();