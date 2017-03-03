#!/usr/bin/env php
<?php

use GuzzleHttp\HandlerStack;
use Solarium\Core\Client\Client;
use Solarium\QueryType\Select\Query\FilterQuery;
use TwoDotsTwice\UiTDBSearchSolarium\QueryType\Search\Document;
use TwoDotsTwice\UiTDBSearchSolarium\QueryType\Search\Result;
use TwoDotsTwice\UiTDBSearchSolarium\QueryType\Search\Query;

require 'vendor/autoload.php';

if ($_SERVER['argc'] < 2) {
    print "You need to specify exactly one argument, containing the keywords you want to search for." . PHP_EOL;
    exit(1);
}

date_default_timezone_set('Europe/Brussels');

// See http://tools.uitdatabank.be/docs/search-api-v2-getting-started.
// and http://documentatie.uitdatabank.be/content/search_api/index.html.
$config = [
    'endpoint' => [
        'acc' => [
            'host' => 'acc.uitid.be',
            'port' => '80',
            'path' => '/uitid/rest/searchv2',
            'timeout' => 20,
        ]
    ]
];

$client = new Client($config);

$stack = HandlerStack::create();
$stack->push(
    new \GuzzleHttp\Subscriber\Oauth\Oauth1(
        [
            // These might be outdated, you can find the latest test keys
            // at http://documentatie.uitdatabank.be/content/omgevingen/latest/index.html
            'consumer_key' => 'BAAC107B-632C-46C6-A254-13BC2CE19C6C',
            'consumer_secret' => 'ec9a0e8c2cdc52886bc545e14f888612',
        ]
    )
);

$guzzleAdapter = new Solarium\Core\Client\Adapter\Guzzle(
    [
        'handler' => $stack,
        'auth' => 'oauth',
    ]
);

$client->setAdapter($guzzleAdapter);

$client->registerQueryType($client::QUERY_SELECT, Query::class);

/** @var Query $query */
$query = $client->createSelect();

$onlyEvents = (new FilterQuery())
    ->setQuery('type:event')
    ->setKey('type');

$query
    ->setGroup('event')
    ->addFilterQuery($onlyEvents)
    ->setQuery($_SERVER['argv'][1]);

/** @var Result $result */
$result = $client->execute($query);

print "Result count: {$result->getNumFound()}" . PHP_EOL;

/** @var Document $document */
foreach ($result->getDocuments() as $document) {
    $type = $document->type;
    $cdbid = $document->item->getCdbId();
    $title = $document->item
        ->getDetails()
        ->getDetailByLanguage('nl')
        ->getTitle();

    print "{$type} {$cdbid}: {$title}" . PHP_EOL;
}

