<?php
include_once 'producto.php';
class bocadillo extends producto{
    private $nombre_producto;
    private $oferta;
        
    public function __construct($id_producto,$tipo_producto,$nombre_producto,$precio_unidad,$oferta){
        Parent::__construct($id_producto,$tipo_producto,$precio_unidad);
        $this->nombre_producto = $nombre_producto;
        $this->oferta = $oferta;
    }

    public function getNombre_producto()
    {
        return $this->nombre_producto;
    }

    public function setNombre_producto($nombre_producto)
    {
        $this->nombre_producto = $nombre_producto;
    }

    public function getOferta()
    {
        return $this->oferta;
    }

    public function setOferta($oferta)
    {
        $this->oferta = $oferta;
    }
}
?>
