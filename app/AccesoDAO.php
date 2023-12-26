<?php
include_once "config.php";
require_once "Cliente.php";

class AccesoDAO {
    private static $modelo = null;
    private $dbh = null;
    private $stmt_clientes = null;
    private $stmt_cliente = null;
    private $stmt_borrcliente = null;
    private $stmt_crearcliente = null;
    private $stmt_modcliente = null;
    
    public static function getModelo(){
        if (self::$modelo == null){
            self::$modelo = new AccesoDAO();
        }
        return self::$modelo;
    }
    
    

   // Constructor privado  Patron singleton
   
    private function __construct(){
        
        try {
            $dsn = "mysql:host=".SERVER_DB.";dbname=".DATABASE.";charset=utf8";
            $this->dbh = new PDO($dsn,DB_USER,DB_PASSWD);
            $this->dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $e){
            echo "Error de conexión ".$e->getMessage();
            exit();
        }
        // Construyo las consultas
        $this->stmt_clientes  = $this->dbh->prepare("Select * from Clientes limit :primero ,:cuantos ");
        $this->stmt_cliente = $this->dbh->prepare("Select * from Clientes Where id = :id");
        $this->stmt_borrcliente   = $this->dbh->prepare("Delete from Clientes where id =:id");
        $this->stmt_crearcliente = $this->dbh->prepare("Insert into Clientes (first_name,last_name,email,gender,ip_address,telefono) Values(?,?,?,?,?,?)");
        $this->stmt_modcliente = $this->dbh->prepare("Update Clientes set first_name=:nombre, last_name=:apellidos, email=:email, gender=:genero, ip_address=:dir_ip, telefono=:telefono Where id =:id");
    }
        

    // Cierro la conexión anulando todos los objectos relacioanado con la conexión PDO (stmt)
    public static function closeModelo(){
        if (self::$modelo != null){
            $obj = self::$modelo;
            $obj->dbh = null; //Cierro la conexion
            self::$modelo = null; // Borro el objeto.
        }
    }


    // Devuelvo la lista de Clientes
    public function getClientes (int $primero, int $cuantos):array {
        $tuser = [];
        $this->stmt_clientes->setFetchMode(PDO::FETCH_CLASS, 'Cliente');
        $this->stmt_clientes->bindParam(":cuantos",$cuantos,PDO::PARAM_INT);
        $this->stmt_clientes->bindParam(":primero",$primero,PDO::PARAM_INT);
        if ( $this->stmt_clientes->execute() ){
             $tuser = $this->stmt_clientes->fetchAll();
        }
        return $tuser;
    }

    public function getCliente($id) : object {
        $cliente = [];
        $this->stmt_cliente->setFetchMode(PDO::FETCH_CLASS, 'Cliente');
        $this->stmt_cliente->bindParam(":id",$id,PDO::PARAM_INT);
        if ($this->stmt_cliente->execute()) {
            $cliente = $this->stmt_cliente->fetchAll();
        }
        return $cliente[0];
    }

    public function borrarCliente($id) : bool {
        $this->stmt_borrcliente->bindValue(':id', $id);
        $this->stmt_borrcliente->execute();
        $resu = ($this->stmt_borrcliente->rowCount () == 1);
        return $resu;
    }

    public function crearCliente($cliente) : bool {            
        $this->stmt_crearcliente->execute( [$cliente->first_name, $cliente->last_name, $cliente->email, $cliente->gender, $cliente->ip_address, $cliente->telefono]);
        $resu = ($this->stmt_crearcliente->rowCount () == 1);
        return $resu;
    }

    public function modCliente($cliente) : bool {
        $this->stmt_modcliente->bindValue(":id",$cliente->id);
        $this->stmt_modcliente->bindValue(':nombre',$cliente->first_name);
        $this->stmt_modcliente->bindValue(':apellidos',$cliente->last_name);
        $this->stmt_modcliente->bindValue(':email',$cliente->email);
        $this->stmt_modcliente->bindValue(':genero',$cliente->gender);
        $this->stmt_modcliente->bindValue(':dir_ip',$cliente->ip_address);
        $this->stmt_modcliente->bindValue(':telefono',$cliente->telefono);
        $this->stmt_modcliente->execute();
        $resu = ($this->stmt_modcliente->rowCount () == 1);
        return $resu;
    }

    public function totalClientes ():int{
        $resu = $this->dbh->query(" Select Count(*) from Clientes");
        $valor = $resu->fetch();
        return ($valor[0]); 
    }
    
     // Evito que se pueda clonar el objeto. (SINGLETON)
     public function __clone()
     { 
         trigger_error('La clonación no permitida', E_USER_ERROR); 
     }
 

}