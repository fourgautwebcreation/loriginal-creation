<?php 

namespace controllers;

class Api implements \interfaces\controllersInterface{

	private $type;
	private $redirect;
	private $datas;

	public function __construct(\Symfony\Component\HttpFoundation\Request $request, \Doctrine\ORM\EntityManager $entityManager ){

		$this->entityManager = $entityManager;
		$this->request = $request;
		$this->type = 'json';

		$getRequest = $this->request->query;
		$postRequest = $this->request->request;

		if( 
			($getRequest->get('type') !== null && $getRequest->get('type') == 'category') OR 
			($postRequest->get('type') !== null && $postRequest->get('type') == 'category')
		){

			$parentID = ( $postRequest->get('parent') == null ? null : $postRequest->get('parent') );
			$category = null;
			if( $parentID !== null ){
				$parent = $this->entityManager->getRepository('entities\Category')->find( $parentID );
				$category = array(
					"id" => $parent->getId(),
					"img" => $parent->getImg(),
					"title" => $parent->getTitle(),
					"description" => $parent->getDescription()
				);
			}
			
			$children = $this->entityManager->getRepository('entities\Category')->findBy(
				array('parent' => $parentID )
			);

			$array = array();
			foreach( $children as $child ){
				$array[] = array( 
					"id" => $child->getId(),
					"img" => $child->getImg(),
					"title" => $child->getTitle(),
					"description" => $child->getDescription() 
				);
			}

			$this->datas = array('category' => $category, 'children' => $array);

		}

	}

	public function getTemplate():string{
		return $this->template;
	}

	public function getDatas():array{
		return $this->datas;
	}

	public function getType():string{
		return $this->type;
	}

	public function getRedirect():string{
		return $this->redirect;
	}

}