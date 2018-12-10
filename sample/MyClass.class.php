<?php
/**
* Classe que manipula a tabela de pessoas
* @author Anderson Freitas
* @table=tb_pessoa
*/

/**
 * TbArea
 *
 * @ORM\Table(name="tb_area")
 * @ORM\Entity
 */
class MyClass
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $id;

    /**
     * @var int
     *
     * @ORM\Column(name="id_projeto", type="integer", nullable=false)
     */
    private $idProjeto;

    /**
     * @var string
     *
     * @ORM\Column(name="nome", type="string", length=255, nullable=false)
     */
    private $nome;

    /**
     * @var string
     *
     * @ORM\Column(name="codigo", type="string", length=10, nullable=false)
     */
    private $codigo;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="criado", type="datetime", nullable=false, options={"default"="CURRENT_TIMESTAMP"})
     */
    private $criado = 'CURRENT_TIMESTAMP';

    /**
     * @var \DateTime|null
     *
     * @ORM\Column(name="excluido", type="datetime", nullable=true)
     */
    private $excluido;

    /**
     * @var int
     *
     * @ORM\Column(name="id_usuario", type="integer", nullable=false)
     */
    private $idUsuario;



    /**
     * Get id.
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set idProjeto.
     *
     * @param int $idProjeto
     *
     * @return TbArea
     */
    public function setIdProjeto($idProjeto)
    {
        $this->idProjeto = $idProjeto;

        return $this;
    }

    /**
     * Get idProjeto.
     *
     * @return int
     */
    public function getIdProjeto()
    {
        return $this->idProjeto;
    }

    /**
     * Set nome.
     *
     * @param string $nome
     *
     * @return TbArea
     */
    public function setNome($nome)
    {
        $this->nome = $nome;

        return $this;
    }

    /**
     * Get nome.
     *
     * @return string
     */
    public function getNome()
    {
        return $this->nome;
    }

    /**
     * Set codigo.
     *
     * @param string $codigo
     *
     * @return TbArea
     */
    public function setCodigo($codigo)
    {
        $this->codigo = $codigo;

        return $this;
    }

    /**
     * Get codigo.
     *
     * @return string
     */
    public function getCodigo()
    {
        return $this->codigo;
    }

    /**
     * Set criado.
     *
     * @param \DateTime $criado
     *
     * @return TbArea
     */
    public function setCriado($criado)
    {
        $this->criado = $criado;

        return $this;
    }

    /**
     * Get criado.
     *
     * @return \DateTime
     */
    public function getCriado()
    {
        return $this->criado;
    }

    /**
     * Set excluido.
     *
     * @param \DateTime|null $excluido
     *
     * @return TbArea
     */
    public function setExcluido($excluido = null)
    {
        $this->excluido = $excluido;

        return $this;
    }

    /**
     * Get excluido.
     *
     * @return \DateTime|null
     */
    public function getExcluido()
    {
        return $this->excluido;
    }

    /**
     * Set idUsuario.
     *
     * @param int $idUsuario
     *
     * @return TbArea
     */
    public function setIdUsuario($idUsuario)
    {
        $this->idUsuario = $idUsuario;

        return $this;
    }

    /**
     * Get idUsuario.
     *
     * @return int
     */
    public function getIdUsuario()
    {
        return $this->idUsuario;
    }
}
