<?php
namespace Curriculum;

class Estado extends \Phalcon\Mvc\Model
{

    /**
     *
     * @var integer
     */
    protected $estado_id;

    /**
     *
     * @var string
     */
    protected $estado_nombre;

    /**
     * Method to set the value of field estado_id
     *
     * @param integer $estado_id
     * @return $this
     */
    public function setEstadoId($estado_id)
    {
        $this->estado_id = $estado_id;

        return $this;
    }

    /**
     * Method to set the value of field estado_nombre
     *
     * @param string $estado_nombre
     * @return $this
     */
    public function setEstadoNombre($estado_nombre)
    {
        $this->estado_nombre = $estado_nombre;

        return $this;
    }

    /**
     * Returns the value of field estado_id
     *
     * @return integer
     */
    public function getEstadoId()
    {
        return $this->estado_id;
    }

    /**
     * Returns the value of field estado_nombre
     *
     * @return string
     */
    public function getEstadoNombre()
    {
        return $this->estado_nombre;
    }

    /**
     * Initialize method for model.
     */
    public function initialize()
    {
        $this->hasMany('estado_id', 'Formacion', 'formacion_estadoId', array('alias' => 'Formacion'));
    }

    /**
     * Returns table name mapped in the model.
     *
     * @return string
     */
    public function getSource()
    {
        return 'estado';
    }

    /**
     * Allows to query a set of records that match the specified conditions
     *
     * @param mixed $parameters
     * @return Estado[]
     */
    public static function find($parameters = null)
    {
        return parent::find($parameters);
    }

    /**
     * Allows to query the first record that match the specified conditions
     *
     * @param mixed $parameters
     * @return Estado
     */
    public static function findFirst($parameters = null)
    {
        return parent::findFirst($parameters);
    }

}
