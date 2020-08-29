<?php 

require_once 'DAO.php';

/**
 * Representa el DAO de la entidad "Empresa"
 */
class EmpresaDAO implements DAO
{

	//------------------------------------------
	// Atributos
	//----------------------------------------

	/**
	 * Referencia a la conexion con la base de datos
	 * @var Object
	 */
	private $conexion;

	/**
	 * Referencia a un objeto EmpresaDAO
	 * @var EmpresaDAO
	 */
	private static $empresaDAO;

	//------------------------------------------
	// Constructor
	//------------------------------------------

	/**
	 * Constructor de la clase
	 *
	 * @param Object $conexion
	 */
    private function __construct($conexion)
    {
		$this->conexion=$conexion;
		mysqli_set_charset($this->conexion, "utf8");
	}

	//------------------------------------------
	// Métodos
	//------------------------------------------

	/**
	 * Método para crear una nueva empresa
	 *
	 * @param Empresa $empresa
	 * @return void
	 */
    public function crear($empresa)
    {
		$sql = "INSERT INTO EMPRESA VALUES(".$empresa->getNit().",'".$empresa->getRazonSocial()."','".$empresa->getRazonComercial()."','".$empresa->getDescripcion()."','".$empresa->getOtrosBeneficios()."','".$empresa->getEstadoEmpresa()."','".$empresa->getLogoEmpresa()."');";

		mysqli_query($this->conexion,$sql);
	}

	/**
	 * Método para consultar una empresa por su NIT 
	 *
	 * @param int $codigo
	 * @return Empresa
	 */
    public function consultar($codigo)
    {
		$sql = "SELECT * FROM EMPRESA WHERE nit_empresa = $codigo";

		if(!$result=mysqli_query($this->conexion,$sql))die();
		$row=mysqli_fetch_array($result);

		$empresa = new Empresa();
		$empresa->setNit($row[0]);
        $empresa->setRazonSocial($row[1]);
        $empresa->setRazonComercial($row[2]);
        $empresa->setDescripcion($row[3]);
        $empresa->setOtrosBeneficios($row[4]);
        $empresa->setEstadoEmpresa($row[5]);
        $empresa->setNit($row[6]);
        $empresa->setLogoEmpresa($row[7]);

		return $empresa;

	}

	/**
	 * Método que actualiza una empresa
	 *
	 * @param Empresa $empresa
	 * @return void
	 */
    public function actualizar($empresa)
    {
		$sql = "UPDATE EMPRESA SET razon_social = '".$empresa->getRazonSocial()."', razon_comercial = '".$empresa->getRazonComercial()."', descripcion_empresa = '".$empresa->getDescripcion()."', otros_beneficios = '".$empresa->getOtrosBenficios()."', estado_empresa = '".$empresa->getLogoEmpresa()."' WHERE nit_empresa = ".$empresa->getNit();
		mysqli_query($this->conexion,$sql);
    }
    
    /**
	 * Método que elimina una empresa
     * 
	 * @param int $codigo
	 * @return void
	 */
    public function eliminar($codigo)
    {
		$sql = "UPDATE EMPRESA SET estado_empresa = 'I' WHERE nit_empresa = ".$codigo;
		mysqli_query($this->conexion,$sql);
	}

	/**
	 * Método para obtener la lista de todas las empresa
	 *
	 * @return Empresa[]
	 */
    public function listar()
    {
		$sql = "SELECT * FROM EMPRESA";

		if(!$result = mysqli_query($this->conexion, $sql))die();

		$empresaArray = array();

        while ($row = mysqli_fetch_array($result)) 
        {
			$empresa = new Empresa();
			$empresa->setcodigo($row[0]);
			$empresa->setnombre($row[1]);
			$empresaArray[] = $empresa;
		}

		return $empresaArray;
	}


	/**
	 * Método para obtener un objeto CiudadDAO
	 *
	 * @param Object $conexion
	 * @return EmpresaDAO
	 */

    public static function obtenerEmpresaDAO($conexion)
    {
        if(self::$empresaDAO==null)
        {
			self::$empresaDAO = new EmpresaDAO($conexion);
        }
        
		return self::$empresaDAO;
	}

}

?>