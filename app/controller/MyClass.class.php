<?php
/**
* Classe que manipula a tabela de pessoas
* @author Anderson Freitas
* @table=tb_pessoa
*/
class MyClass {
	/**
	* @column(name=id, type=serial, sequence=id);
	*/
	private $id;

	/**
	* @column(name=nome, type=string,notnull=true,size=80);
	*/
	private $nome;
}