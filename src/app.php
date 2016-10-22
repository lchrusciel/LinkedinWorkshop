<?php

use GraphAware\Neo4j\Client\ClientBuilder;
use Silex\Application;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use App\Model\User;
use App\Repository\Neo4jUserRepository;
use App\Repository\UserRepository;

$app = new Application(['debug' => true]);

$app['config'] = \Symfony\Component\Yaml\Yaml::parse(file_get_contents(__DIR__ . '/../settings.yml'));
$app['neo4j-client'] = function ($app) {
    return ClientBuilder::create()
        ->addConnection('default', $app['config']['database']['connection'])
        ->build();
};
$app['user_repository'] = function () use ($app) {
    return new Neo4jUserRepository($app['neo4j-client']);
};

$app->before(function (Request $request) {
if (0 === strpos($request->headers->get('Content-Type'), 'application/json')) {
        $data = json_decode($request->getContent(), true);
        $request->request->replace(is_array($data) ? $data : []);
    }
});

$app->get('/users/', function () use ($app) {
    /** @var UserRepository $userRepository */
    $userRepository = $app['user_repository'];

    $users = $userRepository->findAll();

    return $app->json($users);
});

$app->post('/users/', function (Request $request) use ($app) {
    /** @var UserRepository $userRepository */
    $userRepository = $app['user_repository'];

    $userRepository->add(new User($request->request->get('firstName'), $request->request->get('lastName')));

    return $app->json([], Response::HTTP_CREATED);
});

$app->delete('/users/', function (Request $request) use ($app) {
    /** @var UserRepository $userRepository */
    $userRepository = $app['user_repository'];

    $userRepository->delete(new User($request->request->get('firstName'), $request->request->get('lastName')));

    return $app->json([], Response::HTTP_NO_CONTENT);
});

return $app;