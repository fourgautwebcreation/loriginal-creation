<?php 

namespace entitiesManagers;

class Manager{
	private $entityManager;
	public function __construct( $manager ){
		$paths = array(__DIR__.'/../../entities');
		$isDevMode = false;
		try{
			$dbParams = self::getManager($manager);
			$config = \Doctrine\ORM\Tools\Setup::createAnnotationMetadataConfiguration($paths, $isDevMode);
			$this->entityManager = \Doctrine\ORM\EntityManager::create(self::getManager($manager), $config);
		}
		catch( \Exception $e){
			echo $e->getMessage();
		}
		
	}
	private function getManager($manager){

			if( defined('\\entitiesManagers\\configsManager::'.$manager) )
				return constant('\\entitiesManagers\\configsManager::'.$manager);
			else
				throw new \Exception('DB params not founded');
		
	}

	public function get(){
		return $this->entityManager;
	}
}