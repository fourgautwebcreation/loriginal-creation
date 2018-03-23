<?php 

use entitiesManagers as globalManager;

$constructor = new globalManager\Manager('MAIN_MANAGER');
$entityManager = $constructor->get();
