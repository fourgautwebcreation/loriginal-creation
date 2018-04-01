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

		if( $route == 'home' ){
			$controller = new \controllers\Home();
		}

		if( $route == 'immo' ){
			$controller = new \controllers\Immo();
		}
		
		if( $route == 'animations' ){
			$controller = new \controllers\Animations();
		}

		if( $route == 'contact' ){
			$controller = new \controllers\Contact();
		}

		if( $route == 'api' ){
			$controller = new \controllers\Api( $this->request, $this->entityManager );
		}

		if( $route == 'admin' ){
			$controller = new \controllers\Admin( $this->request, $this->entityManager );
		}


		if( $route == 'dashboard' ){
			$controller = new \controllers\Dashboard( $this->request, $this->entityManager );
		}

		if( $controller == null ){
			echo $route.' not found';
		}

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

}