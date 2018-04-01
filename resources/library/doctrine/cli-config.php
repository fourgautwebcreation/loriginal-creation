<?php
require_once __DIR__."/../../../vendor/autoload.php";

use Doctrine\ORM\Tools\Console\ConsoleRunner;
use entitiesManagers as globalManager;

$constructor = new globalManager\Manager();
$entityManager = $constructor->get();

return ConsoleRunner::createHelperSet($entityManager);