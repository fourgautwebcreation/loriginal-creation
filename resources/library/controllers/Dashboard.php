<?php 

namespace controllers;

class Dashboard implements \interfaces\controllersInterface{

	private $type;
	private $datas;
	private $redirect;
	private $template = 'admin/dashboard.twig';

	public function __construct( \Symfony\Component\HttpFoundation\Request $request, \Doctrine\ORM\EntityManager $entityManager ){

		$this->entityManager = $entityManager;
		$this->request = $request;

		if( !isset( $_SESSION['id'] ) ){
			$this->type = 'redirect';
			$this->redirect = 'index.php?part=admin';
		}
		else{
			$user = $this->entityManager->getRepository('entities\User')->find($_SESSION['id']);
			$this->type = 'html';
			$this->datas = array('user' => $user);
		}
		
	}

	public function getTemplate():string{
		return $this->template;
	}

	public function getDatas(){
		return $this->datas;
	}

	public function getType():string{
		return $this->type;
	}

	public function getRedirect():string{
		return $this->redirect;
	}
}