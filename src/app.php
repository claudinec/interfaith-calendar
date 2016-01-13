<?php

use Silex\Application;
use Silex\Provider\TwigServiceProvider;
use Silex\Provider\UrlGeneratorServiceProvider;
use Silex\Provider\ValidatorServiceProvider;
use Silex\Provider\ServiceControllerServiceProvider;
use Silex\Provider\HttpFragmentServiceProvider;
use Symfony\Component\Yaml\Parser;

$app = new Application();
$app->register(new UrlGeneratorServiceProvider());
$app->register(new ValidatorServiceProvider());
$app->register(new ServiceControllerServiceProvider());
$app->register(new TwigServiceProvider());
$app->register(new HttpFragmentServiceProvider());

$app->get('/', function () use ($app) {
    // TODO Format dates nicely.
    // Now.
    $now = date("U");
    // One week from now.
    $oneweek = strtotime("+1 week");

    // Read YAML files.
    // TODO Read all files listed in religions.csv.
    $yaml = new Parser();
    try {
        $data = $yaml->parse(file_get_contents('../data/christian.yaml'));
    } catch (ParseException $e) {
        printf("Unable to parse the YAML string: %s", $e->getMessage());
    }

    // TODO Get events for these dates.

    // Render the template.
    return $app['twig']->render('calendar.twig', array(
        'now' => strftime("%F", $now),
        'oneweek' => strftime("%F", $oneweek),
        'timezone' => strftime("%Z", $now),
        'data' => $data,
    ));
});

return $app;
