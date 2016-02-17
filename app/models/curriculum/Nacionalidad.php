<?php
namespace Curriculum;

class Nacionalidad extends \Phalcon\Mvc\Model
{

    /**
     *
     * @var integer
     */
    public $nacionalidad_id;

    public function setNacionalidadId($nacionalidad_id)
    {
        $this->nacionalidad_id=$nacionalidad_id;
    }
    public function getNacionalidadId()
    {
        return $this->nacionalidad_id;
    }
    /**
     *
     * @var string
     */
    public $nacionalidad_nombre;

    public function setNacionalidadNombre($nacionalidad_nombre)
    {
        $this->nacionalidad_nombre=$nacionalidad_nombre;
    }
    public function getNacionalidadNombre()
    {
        return $this->nacionalidad_nombre;
    }
    /**
     * Initialize method for model.
     */
    public function initialize()
    {
        $this->hasMany('nacionalidad_id', 'Curriculum\Persona', 'persona_nacionalidadId', array('alias' => 'Persona'));
    }

    /**
     * Returns table name mapped in the model.
     *
     * @return string
     */
    public function getSource()
    {
        return 'nacionalidad';
    }

    /**
     * Allows to query a set of records that match the specified conditions
     *
     * @param mixed $parameters
     * @return Nacionalidad[]
     */
    public static function find($parameters = null)
    {
        return parent::find($parameters);
    }

    /**
     * Allows to query the first record that match the specified conditions
     *
     * @param mixed $parameters
     * @return Nacionalidad
     */
    public static function findFirst($parameters = null)
    {
        return parent::findFirst($parameters);
    }

}
