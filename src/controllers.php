<?php

use Symfony\Component\Form\FormError;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Validator\Constraints as Assert;

$app->match('/', function() use ($app) {
    $app['session']->getFlashBag()->add('warning', 'Warning flash message');
    $app['session']->getFlashBag()->add('info', 'Info flash message');
    $app['session']->getFlashBag()->add('success', 'Success flash message');
    $app['session']->getFlashBag()->add('error', 'Error flash message');

    return $app['twig']->render('index.html.twig');
})->bind('homepage');


$app->get('/task', function() use ($app) {
    $tasks = $app['db']->fetchAll('SELECT * FROM task');
    return new Response(json_encode($tasks), 200, array('Content-Type' => 'application/json'));
})->bind('task');

$app->get('/task/{id}', function($id) use ($app) {
    $task = $app['db']->fetchAll('SELECT * FROM task WHERE id = :id')->setParameter('id', $id);
    return new Response(json_encode($task), 200, array('Content-Type' => 'application/json'));
})->bind('login');

$app->post('/task', function(Request $request) use ($app) {
    if (!$data = $request->get('task')) {
        return new Response ('Missing Parameters.', 400);
    }

    // Persist to the database
    $now = new \DateTime();
    $insertData = array(
        'created_at' => $now->format('Y-m-d'),
        'title' => $data['title']
    );

    $app['db']->insert('task', $insertData);

    return new Response ('Task created.', 200);
})->bind('doctrine');

$app->put('/task/{id}', function(Request $request, $id) use ($app) {
    if (!$data = $request->get('task')) {
        return new Response ('Missing Parameters.', 400);
    }

    // Persist to the database
    $app['db']->update('task', $data, $id);

    return new Response ('Task updated.', 200);
})->bind('form');

$app->delete('/task/{id}', function($id) use ($app) {
    $app['db']->delete('task', $id);

    return new Response('Task Deleted.', 200);
})->bind('logout');

return $app;
