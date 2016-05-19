<?php

class Estadoasistencia extends \Phalcon\Mvc\Model
{

    /**
     *
     * @var integer
     */
    protected $estadoAsistencia_id;

    /**
     *
     * @var string
     */
    protected $estadoAsistencia_nombre;

    /**
     *
     * @var string
     */
    protected $estadoAsistencia_descripcion;

    /**
     * Method to set the value of field estadoAsistencia_id
     *
     * @param integer $estadoAsistencia_id
     * @return $this
     */
    public function setEstadoasistenciaId($estadoAsistencia_id)
    {
        $this->estadoAsistencia_id = $estadoAsistencia_id;

        return $this;
    }

    /**
     * Method to set the value of field estadoAsistencia_nombre
     *
     * @param string $estadoAsistencia_nombre
     * @return $this
     */
    public function setEstadoasistenciaNombre($estadoAsistencia_nombre)
    {
        $this->estadoAsistencia_nombre = $estadoAsistencia_nombre;

        return $this;
    }

    /**
     * Method to set the value of field estadoAsistencia_descripcion
     *
     * @param string $estadoAsistencia_descripcion
     * @return $this
     */
    public function setEstadoasistenciaDescripcion($estadoAsistencia_descripcion)
    {
        $this->estadoAsistencia_descripcion = $estadoAsistencia_descripcion;

        return $this;
    }

    /**
     * Returns the value of field estadoAsistencia_id
     *
     * @return integer
     */
    public function getEstadoasistenciaId()
    {
        return $this->estadoAsistencia_id;
    }

    /**
     * Returns the value of field estadoAsistencia_nombre
     *
     * @return string
     */
    public function getEstadoasistenciaNombre()
    {
        return $this->estadoAsistencia_nombre;
    }

    /**
     * Returns the value of field estadoAsistencia_descripcion
     *
     * @return string
     */
    public function getEstadoasistenciaDescripcion()
    {
        return $this->estadoAsistencia_descripcion;
    }

    /**
     * Initialize method for model.
     */
    public function initialize()
    {
        $this->setSource("'estadoAsistencia'");
    }

    /**
     * Returns table name mapped in the model.
     *
     * @return string
     */
    public function getSource()
    {
        return 'estadoAsistencia';
    }

    /**
     * Allows to query a set of records that match the specified conditions
     *
     * @param mixed $parameters
     * @return Estadoasistencia[]
     */
    public static function find($parameters = null)
    {
        return parent::find($parameters);
    }

    /**
     * Allows to query the first record that match the specified conditions
     *
     * @param mixed $parameters
     * @return Estadoasistencia
     */
    public static function findFirst($parameters = null)
    {
        return parent::findFirst($parameters);
    }

}
