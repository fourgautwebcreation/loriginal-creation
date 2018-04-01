<?php 

namespace controllers;

class Admin implements \interfaces\controllersInterface{

	private $type;
	private $datas;
	private $redirect;
	private $template = 'admin/index.twig';

	public function __construct( \Symfony\Component\HttpFoundation\Request $request, \Doctrine\ORM\EntityManager $entityManager ){
		$this->entityManager = $entityManager;
		$this->request = $request;
		if( $this->request->query->get('action') !== null ){

			// Connexion
			if( $this->request->query->get('action') == 'connexion'){
				if( $this->request->request->get('pass') !== null && $this->request->request->get('pseudo') !== null ){
					$pseudo = trim( $this->request->request->get('pseudo') );
					$pass = md5( $this->request->request->get('pass') );
					$user = $this->entityManager->getRepository('entities\User')->findOneBy(
						array('pseudo' => $pseudo, 'pass' => $pass)
					);

					if( $user !== null ){
						$_SESSION['id'] = $user->getId();
						$this->type = 'redirect';
						$this->redirect = 'index.php?part=dashboard';
					}
					else{
						$this->type = 'html';
						$this->datas = array();
					}

				}	
				else{	
					new \helpers\Error('Empty parameters for connexion');
				}
			}

			// Déconnexion
			elseif( $this->request->query->get('action') == 'deconnexion'){
				session_unset();
				session_destroy();
				$this->redirect = 'index.php?part=admin';
				$this->type = 'redirect';
			}

		}
		else{
			$this->type = 'html';
			$this->datas = array();
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