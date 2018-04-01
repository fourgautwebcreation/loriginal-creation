<?php 

namespace controllers;

class Animations implements \interfaces\controllersInterface{

	private $type;
	private $datas;
	private $redirect;
	private $template = 'animations.twig';

	public function __construct(){
		$this->type = 'html';
		$this->datas = array('name' => 'fabien');
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