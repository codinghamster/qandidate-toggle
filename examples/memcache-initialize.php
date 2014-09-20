<?php

require_once __DIR__ . '/../vendor/autoload.php';

use Qandidate\Toggle\Operator\LessThan;
use Qandidate\Toggle\OperatorCondition;
use Qandidate\Toggle\Toggle;
use Qandidate\Toggle\ToggleCollection\MemcacheCollection;
use Qandidate\Toggle\ToggleManager;

// Create the ToggleManager
$memcache   = new \Memcached('toggle_demo');
$memcache->addServer('localhost', 11211);
$collection = new MemcacheCollection($memcache);
$manager    = new ToggleManager($collection);

// A toggle that will be active is the user id is less than 42
$operator  = new LessThan(42);
$condition = new OperatorCondition('user_id', $operator);
$toggle    = new Toggle('toggling', array($condition));

// Add the toggle to the manager
$manager->add($toggle);


var_dump($collection->all());