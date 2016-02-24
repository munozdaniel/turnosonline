<?php
namespace Curriculum;

class Tipodocumento extends \Phalcon\Mvc\Model
{

    /**
     *
     * @var integer
     */
    public $tipodocumento_id;

    public function setTipodocumentoId($tipodocumento_id)
    {
        $this->tipodocumento_id=$tipodocumento_id;
    }
    public function getTipodocumentoId()
    {
        return $this->tipodocumento_id;
    }
    /**
     *
     * @var string
     */
    public $tipodocumento_descripcion;

    public function setTipodocumentoDescripcion($tipodocumento_descripcion)
    {
        $this->tipodocumento_descripcion=$tipodocumento_descripcion;
    }
    public function getTipodocumentoDescripcion()
    {
        return $this->tipodocumento_descripcion;
    }
    /**
     * Initialize method for model.
     */
    public function initialize()
    {
        $this->hasMany('tipodocumento_id', 'Curriculum\Persona', 'persona_tipoDocumentoId', array('alias' => 'Persona'));
    }

    /**
     * Returns table name mapped in the model.
     *
     * @return string
     */
    public function getSource()
    {
        return 'tipodocumento';
    }

    /**
     * Allows to query a set of records that match the specified conditions
     *
     * @param mixed $parameters
     * @return Tipodocumento[]
     */
    public static function find($parameters = null)
    {
        return parent::find($parameters);
    }

    /**
     * Allows to query the first record that match the specified conditions
     *
     * @param mixed $parameters
     * @return Tipodocumento
     */
    public static function findFirst($parameters = null)
    {
        return parent::findFirst($parameters);
    }

}
