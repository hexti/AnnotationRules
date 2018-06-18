<?php

/**
* Class that implements a connection to the database
* @author Anderson Freitas
*/

class Conexao extends PDO {

	private $config = parse_ini_file('config.ini');
	private $dsn = 'mysql:host='.$conig['db_host'].';port='.$config['db_port'].';dbname='.$config['db_name'].';charset='.$config['db_charset'];
	public $handle = null;

	function __construct() {
		try {
			if ( $this->handle == null ) {
				$dbh = parent::__construct( $this->dsn , $this->config['db_user'] , $this->config['db_pass'] );
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
}