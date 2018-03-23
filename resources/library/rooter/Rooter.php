<?php 

namespace rooter;

use Symfony\Component\HttpFoundation\Request;

class Rooter{

	public function __construct(){
		$this->request = Request::createFromGlobals();
			$postRequest = $this->request->request;

		$this->tplFolder = __DIR__.'/../../templates';
		$loader = new \Twig_Loader_Filesystem($this->tplFolder);
		$twig = new \Twig_Environment($loader, array());

		$controller = null;
		$route = null;

		if( count($postRequest) == 0 ){
			$route = 'home';
		}
		else{
			$part = $postRequest->get('part');
			$route = ( $part == null ? 'home' : $part );
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

		if( $controller->getType() == 'html' ){
			echo $twig->render($controller->getTemplate(), $controller->getDatas());
		}
	}

}