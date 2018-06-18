<?php
include_once INTERNAL_ROOT_PORTAL.'/includes.sys/driver.php';
include_once INTERNAL_ROOT_PORTAL.'/includes.sys/metodos.php';

class BlockDAO {
	// ira receber uma conexao
	public $p = null;

	// construtor
	public function BlockDAO(){
		$this->p = new Conexao();
	}

	// realiza uma insercao
	public function Gravar( $objeto, $tabela ){

		try{
			//Verifica se tem upload e retira o indice
			if($objeto['upload'] != ""){
				unset($objeto['upload']);
			}

			$campos = array_keys($objeto);

			$fields = implode(',', array_keys($objeto));
			$values = ':' . str_replace(',', ',:', $fields);

			$query 	= "INSERT INTO ".$tabela." ({$fields}) VALUES ({$values})";

			$stmt = $this->p->prepare($query);

			foreach($campos as $item){
				if($item != 'upload'){
					$stmt->bindValue($item, $objeto[$item]);
				}
			}

			if(!$stmt->execute()){
				return $stmt->errorInfo();
			}else{
				return $this->p->lastInsertId();
			}

			// fecho a conex���������o
			$this->p->__destruct();
			// caso ocorra um erro, retorna o erro;
		}catch ( PDOException $ex ){
			echo "Mensagem de erro: ".$ex->getMessage(); }
	}

	// realiza um Update
	public function Atualizar($tabela, $objetos){
		try{

			$campos = array_keys($objetos);
			$values = '';

			foreach ($campos as $item){
				if($item != 'id'){
					$values .= $item." = :".$item.", ";
				}
			}

			$values = substr($values, 0, -2);

			$stmt = $this->p->prepare("UPDATE ".$tabela." SET {$values} WHERE id = ".$objetos['id']);
			$this->p->beginTransaction();

			foreach ($campos as $item){
				if($item != 'id'){
					$stmt->bindValue($item, $objetos[$item]);
				}
			}

			// executo a query preparada e verificando se ocorreu bem.
			if(!$stmt->execute()){
				return $stmt->errorInfo();
			}else{
				$this->p->commit();
				return 1;
			}

			// fecho a conex���������o
			$this->p->__destruct();
		}catch ( PDOException $ex ){
			echo "Erro: ".$ex->getMessage();
		}
	}

	// remove um registro
	public function Deletar($tabela, $id){
		try{
			$stmt = $this->p->prepare("UPDATE ".$tabela." SET excluido = NOW() WHERE id=?");
			$this->p->beginTransaction();
			$stmt->bindValue(1, $id );

			// executo a query preparada e verificando se ocorreu bem.
			if(!$stmt->execute()){
				return $stmt->errorInfo();
			}else{
				$this->p->commit();
				return 1;
			}

			// fecho a conex���������o
			$this->p->__destruct();

			// caso ocorra um erro, retorna o erro;
		}catch ( PDOException $ex ){
			echo "Erro: ".$ex->getMessage(); }
	}

	// remove um registro
	public function ApagarDefinitivamente($tabela, $id){
		try{
			$stmt = $this->p->prepare("DELETE FROM ".$tabela." WHERE id=?");
			$this->p->beginTransaction();
			$stmt->bindValue(1, $id );

			// executo a query preparada e verificando se ocorreu bem.
			if(!$stmt->execute()){
				return $stmt->errorInfo();
			}else{
				$this->p->commit();
				return 1;
			}

			// fecho a conex���������o
			$this->p->__destruct();

			// caso ocorra um erro, retorna o erro;
		}catch ( PDOException $ex ){
			echo "Erro: ".$ex->getMessage(); }
	}

	//Lista  todos os registros
	public function Listar($tabela, $campos, $where = 1 , $query=null){
		try{

			if( $query == null ){

				unset($campos['acao']);

				print_r($campos);

				$fields = implode(',', $campos);

				$stmt = $this->p->query("SELECT {$fields} FROM ".$tabela." WHERE {$where}");

				$confirm = "return confirm('Deseja remover esse registro?');";

				if($stmt->rowCount() > 0){
					foreach ( $stmt as $item ) {

						echo '<tr>';

						foreach ($campos as $row){
							if($row != 'id'){
								echo '	<td>' . $item [$row] . '</td>';
							}
						}

						echo '	<td>';
						echo '		<a class="btn btn-warning" href="edit.php?id='.$item['id'].'"><span class="glyphicon glyphicon-edit" aria-hidden="true"></span> Editar</a>';
						echo '		<a onclick="' . $confirm . '" class="btn btn-danger" href="index.php?id='.$item['id'].'&cmd=del"><span class="glyphicon glyphicon-trash" aria-hidden="true"></span> Remover</a>';
						echo '	</td>';
						echo '</tr>';
					}
				}

			}else{
				unset($campos['acao']);
				$keys = array_keys($campos);
				$fields = "";

				foreach ($keys as $item){
					$fields .= $item.' as '.str_replace(' ', '_', $campos[$item]).', ';
				}

				$fields = substr($fields, 0, -2);

				$stmt = $this->p->query("SELECT {$fields} FROM ".$tabela." WHERE {$where}");
			}
			$this->p->__destruct();
			return $stmt;
		}catch ( PDOException $ex ){
			echo "Erro: ".$ex->getMessage(); }
	}

	//Lista  todos os registros
	public function Query($query){
		try{
			$stmt = $this->p->query($query);

			$this->p->__destruct();

			return $stmt;
		}catch ( PDOException $ex ){
			echo "Erro: ".$ex->getMessage(); }
	}
}
?>