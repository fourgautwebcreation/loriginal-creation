<?php 

namespace rooter;

use Symfony\Component\HttpFoundation\Request;

class Rooter{

	public function __construct( $entityManager ){
		$this->entityManager = $entityManager;
		$this->request = Request::createFromGlobals();
			$postRequest = $this->request->request;
			$getRequest = $this->request->query;

		$this->tplFolder = __DIR__.'/../../templates';
		$loader = new \Twig_Loader_Filesystem($this->tplFolder);
		$twig = new \Twig_Environment($loader, array());

		$controller = null;
		$route = null;

		if( count($postRequest) == 0 && count($getRequest) == 0 ){
			$route = 'home';
		}
		else{
			$route = ( $postRequest->get('part') !== null ? $postRequest->get('part') : ( $getRequest->get('part') !== null  ? $getRequest->get('part') : 'home' ) );
		}

		$route = ucfirst($route);
		$namespace = '\\controllers\\'.$route;

		if( class_exists( $namespace ) ){
			$controller = new $namespace( $this->request, $this->entityManager );

			if( $controller->getType() == 'html' ){
				echo $twig->render($controller->getTemplate(), $controller->getDatas());
			}

			elseif( $controller->getType() == 'json' ){
				header('Content-Type:Application/json');
				echo json_encode($controller->getDatas());
			}

			elseif( $controller->getType() == 'redirect' ){
				header('location:'.$controller->getRedirect());
			}
		}

		else{
			echo $route.' not found';
		}
		
	}

}