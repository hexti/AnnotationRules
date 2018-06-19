<?php

/**
* Class that implements a connection to the database
* @author Anderson Freitas
*/

class Conexao extends PDO {

	private $user = null;
	private $pass = null;
	private $dsn = null;
	public $handle = null;

	function __construct() {
		try {
			if ( $this->handle == null ) {
				$this->loadConfig();
				$dbh = parent::__construct( $this->dsn , $this->user , $this->pass );
				$this->handle = $dbh;
				return $this->handle;
			}
		}
		catch ( PDOException $e ) {
			echo 'Conexão falhou. Erro: ' . $e->getMessage( );
			return false;
		}
	}
	function __destruct( ) {
		$this->handle = NULL;
	}

	function loadConfig(){
		$config = parse_ini_file('config.ini');
		$this->dsn = 'mysql:host='.$conig['db_host'].';port='.$config['db_port'].';dbname='.$config['db_name'].';charset='.$config['db_charset'];
		$this->user = $config['db_user'];
		$this->pass = $config['db_pass'];
	}
}