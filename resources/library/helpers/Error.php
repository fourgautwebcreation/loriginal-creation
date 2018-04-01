<?php 

namespace helpers;

use ElephantIO\Client;
use ElephantIO\Engine\SocketIO\Version1X;

class Error extends \Error{

	public function __construct( $message ){
		parent::__construct( $message );
	}

}