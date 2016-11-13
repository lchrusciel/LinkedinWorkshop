<?php

use GraphAware\Neo4j\Client\ClientBuilder;
use Silex\Application;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use App\Model\User;
use App\Model\Friends;
use App\Model\Knows;
use App\Model\Competence;
use App\Repository\Neo4jUserRepository;
use App\Repository\Neo4jCompetenceRepository;
use App\Repository\UserRepository;
use App\Repository\CompetenceRepository;
use App\Repository\RelationRepository;
use App\Repository\Neo4jRelationRepository;
use Ramsey\Uuid\Uuid;

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
$app['competence_repository'] = function () use ($app) {
    return new Neo4jCompetenceRepository($app['neo4j-client']);
};
$app['relationships_repository'] = function () use ($app) {
    return new Neo4jRelationRepository($app['neo4j-client']);
};

$app->before(function (Request $request) {
if (0 === strpos($request->headers->get('Content-Type'), 'application/json')) {
        $data = json_decode($request->getContent(), true);
        $request->request->replace(is_array($data) ? $data : []);
    }
});

$app->get('/users/{uuid}', function (Request $request) use ($app) {
    return $app->json($app['user_repository']->find($request->attributes->get('uuid')));
});

$app->get('/users/', function () use ($app) {
    /** @var UserRepository $userRepository */
    $userRepository = $app['user_repository'];

    $users = $userRepository->findAll();

    return $app->json($users);
});

$app->post('/users/', function (Request $request) use ($app) {
    $user = new User(Uuid::uuid4(), $request->request->get('firstName'), $request->request->get('lastName'));

    $app['user_repository']->add($user);

    return $app->json($user, Response::HTTP_CREATED);
});

$app->delete('/users/', function (Request $request) use ($app) {
    $app['user_repository']->delete($request->request->get('uuid'));

    return $app->json([], Response::HTTP_NO_CONTENT);
});

$app->get('/competences/{uuid}', function (Request $request) use ($app) {
    return $app->json($app['competence_repository']->find($request->attributes->get('uuid')));
});

$app->get('/competences/', function () use ($app) {
    /** @var UserRepository $competenceRepository */
    $competenceRepository = $app['competence_repository'];

    $competences = $competenceRepository->findAll();

    return $app->json($competences);
});

$app->post('/competences/', function (Request $request) use ($app) {
    /** @var CompetenceRepository $competenceRepository */
    $competenceRepository = $app['competence_repository'];
    $competence = new Competence(Uuid::uuid4(), $request->request->get('name'));

    $competenceRepository->add($competence);

    return $app->json($competence, Response::HTTP_CREATED);
});

$app->delete('/competences/', function (Request $request) use ($app) {
    $app['competence_repository']->delete($request->request->get('uuid'));

    return $app->json([], Response::HTTP_NO_CONTENT);
});

$app->post('/knows/', function (Request $request) use ($app) {
    /** @var RelationRepository $relationshipsRepository */
    $relationshipsRepository = $app['relationships_repository'];
    /** @var UserRepository $userRepository */
    $userRepository = $app['user_repository'];
    /** @var CompetenceRepository $competenceRepository */
    $competenceRepository = $app['competence_repository'];

    $user = $userRepository->find($request->request->get('user'));
    $competence = $competenceRepository->find($request->request->get('competence'));

    $relationshipsRepository->connect(new Knows($user, $competence));

    return $app->json([], Response::HTTP_CREATED);
});

$app->post('/friends/', function (Request $request) use ($app) {
    /** @var RelationRepository $relationshipsRepository */
    $relationshipsRepository = $app['relationships_repository'];
    /** @var UserRepository $userRepository */
    $userRepository = $app['user_repository'];

    $user1 = $userRepository->find($request->request->get('user1'));
    $user2 = $userRepository->find($request->request->get('user2'));

    $relationshipsRepository->connect(new Friends($user1, $user2));

    return $app->json([], Response::HTTP_CREATED);
});

return $app;