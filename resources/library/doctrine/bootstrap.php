<?php 

use entitiesManagers as globalManager;

$constructor = new globalManager\Manager();
$entityManager = $constructor->get();
