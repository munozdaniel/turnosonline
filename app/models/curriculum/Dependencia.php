<?php
namespace Curriculum;

class Dependencia extends \Phalcon\Mvc\Model
{

    /**
     *
     * @var integer
     */
    protected $dependencia_id;

    /**
     *
     * @var string
     */
    protected $dependencia_nombre;

    /**
     *
     * @var integer
     */
    protected $dependencia_habilitado;

    /**
     * Method to set the value of field dependencia_id
     *
     * @param integer $dependencia_id
     * @return $this
     */
    public function setDependenciaId($dependencia_id)
    {
        $this->dependencia_id = $dependencia_id;

        return $this;
    }

    /**
     * Method to set the value of field dependencia_nombre
     *
     * @param string $dependencia_nombre
     * @return $this
     */
    public function setDependenciaNombre($dependencia_nombre)
    {
        $this->dependencia_nombre = $dependencia_nombre;

        return $this;
    }

    /**
     * Method to set the value of field dependencia_habilitado
     *
     * @param integer $dependencia_habilitado
     * @return $this
     */
    public function setDependenciaHabilitado($dependencia_habilitado)
    {
        $this->dependencia_habilitado = $dependencia_habilitado;

        return $this;
    }

    /**
     * Returns the value of field dependencia_id
     *
     * @return integer
     */
    public function getDependenciaId()
    {
        return $this->dependencia_id;
    }

    /**
     * Returns the value of field dependencia_nombre
     *
     * @return string
     */
    public function getDependenciaNombre()
    {
        return $this->dependencia_nombre;
    }

    /**
     * Returns the value of field dependencia_habilitado
     *
     * @return integer
     */
    public function getDependenciaHabilitado()
    {
        return $this->dependencia_habilitado;
    }

    /**
     * Initialize method for model.
     */
    public function initialize()
    {
        $this->hasMany('dependencia_id', 'Puesto', 'puesto_dependenciaId', array('alias' => 'Puesto'));
    }

    /**
     * Returns table name mapped in the model.
     *
     * @return string
     */
    public function getSource()
    {
        return 'dependencia';
    }

    /**
     * Allows to query a set of records that match the specified conditions
     *
     * @param mixed $parameters
     * @return Dependencia[]
     */
    public static function find($parameters = null)
    {
        return parent::find($parameters);
    }

    /**
     * Allows to query the first record that match the specified conditions
     *
     * @param mixed $parameters
     * @return Dependencia
     */
    public static function findFirst($parameters = null)
    {
        return parent::findFirst($parameters);
    }

}
