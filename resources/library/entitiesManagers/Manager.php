<?php 

namespace entitiesManagers;

class Manager{

	private $entityManager;
	private $databasesConf = __DIR__.'/databases.json';
	private $configurations;

	public function __construct(){

		$paths = array(realpath(__DIR__.'/../entities/'), realpath(__DIR__.'/../repositories/'));
		$isDevMode = false;
		$conf = ( $isDevMode == true ) ? 'dev' : 'prod';

		try{
			$manager = self::getManager($conf);
			$config = \Doctrine\ORM\Tools\Setup::createAnnotationMetadataConfiguration($paths, $isDevMode);
			$this->entityManager = \Doctrine\ORM\EntityManager::create($manager, $config);
		}
		catch( \Exception $e){
			echo $e->getMessage();
		}
		
	}
	private function getManager($conf){
		if( self::getConfs() !== false ){
			if( is_array( $this->configurations ) ){;
				return $this->configurations[$conf];
			}
			
			else{
				throw new \Exception('DB params not founded for '.$conf);
			}
		}	
	}

	private function getConfs(){
		$json = file_get_contents($this->databasesConf);
		$this->configurations = json_decode( $json, true );
	}

	public function get(){
		return $this->entityManager;
	}
}