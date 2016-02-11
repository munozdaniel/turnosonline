<?php
namespace Curriculum;

class Puesto extends \Phalcon\Mvc\Model
{

    /**
     *
     * @var integer
     */
    protected $puesto_id;

    /**
     *
     * @var string
     */
    protected $puesto_nombre;

    /**
     *
     * @var integer
     */
    protected $puesto_dependenciaId;

    /**
     *
     * @var integer
     */
    protected $puesto_habilitado;

    /**
     * Method to set the value of field puesto_id
     *
     * @param integer $puesto_id
     * @return $this
     */
    public function setPuestoId($puesto_id)
    {
        $this->puesto_id = $puesto_id;

        return $this;
    }

    /**
     * Method to set the value of field puesto_nombre
     *
     * @param string $puesto_nombre
     * @return $this
     */
    public function setPuestoNombre($puesto_nombre)
    {
        $this->puesto_nombre = $puesto_nombre;

        return $this;
    }

    /**
     * Method to set the value of field puesto_dependenciaId
     *
     * @param integer $puesto_dependenciaId
     * @return $this
     */
    public function setPuestoDependenciaid($puesto_dependenciaId)
    {
        $this->puesto_dependenciaId = $puesto_dependenciaId;

        return $this;
    }

    /**
     * Method to set the value of field puesto_habilitado
     *
     * @param integer $puesto_habilitado
     * @return $this
     */
    public function setPuestoHabilitado($puesto_habilitado)
    {
        $this->puesto_habilitado = $puesto_habilitado;

        return $this;
    }

    /**
     * Returns the value of field puesto_id
     *
     * @return integer
     */
    public function getPuestoId()
    {
        return $this->puesto_id;
    }

    /**
     * Returns the value of field puesto_nombre
     *
     * @return string
     */
    public function getPuestoNombre()
    {
        return $this->puesto_nombre;
    }

    /**
     * Returns the value of field puesto_dependenciaId
     *
     * @return integer
     */
    public function getPuestoDependenciaid()
    {
        return $this->puesto_dependenciaId;
    }

    /**
     * Returns the value of field puesto_habilitado
     *
     * @return integer
     */
    public function getPuestoHabilitado()
    {
        return $this->puesto_habilitado;
    }

    /**
     * Initialize method for model.
     */
    public function initialize()
    {
        $this->hasMany('puesto_id', 'Curriculum\Empleo', 'empleo_puestoId', array('alias' => 'Empleo'));
        $this->belongsTo('puesto_dependenciaId', 'Curriculum\Dependencia', 'dependencia_id', array('alias' => 'Dependencia'));
    }

    /**
     * Returns table name mapped in the model.
     *
     * @return string
     */
    public function getSource()
    {
        return 'puesto';
    }

    /**
     * Allows to query a set of records that match the specified conditions
     *
     * @param mixed $parameters
     * @return Puesto[]
     */
    public static function find($parameters = null)
    {
        return parent::find($parameters);
    }

    /**
     * Allows to query the first record that match the specified conditions
     *
     * @param mixed $parameters
     * @return Puesto
     */
    public static function findFirst($parameters = null)
    {
        return parent::findFirst($parameters);
    }

}
