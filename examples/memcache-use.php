<?php

require_once __DIR__ . '/../vendor/autoload.php';

use Qandidate\Toggle\Context;
use Qandidate\Toggle\ToggleCollection\MemcacheCollection;
use Qandidate\Toggle\ToggleManager;

// Create the ToggleManager
$memcache   = new \Memcached('toggle_demo');
$memcache->addServer('localhost', 11211);
$collection = new MemcacheCollection($memcache);
$manager    = new ToggleManager($collection);

// Create and check a new context for a user with id 42
$context = new Context();
$context->set('user_id', 42);
var_dump($manager->active('toggling', $context)); // false

// Create and check a new context for a user with id 21
$context = new Context();
$context->set('user_id', 21);
var_dump($manager->active('toggling', $context)); // true
