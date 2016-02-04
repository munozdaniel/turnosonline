<?php
namespace Curriculum;

class Empleo extends \Phalcon\Mvc\Model
{

    /**
     *
     * @var integer
     */
    protected $empleo_id;

    /**
     *
     * @var integer
     */
    protected $empleo_curriculumId;

    /**
     *
     * @var string
     */
    protected $empleo_disponibilidad;

    /**
     *
     * @var integer
     */
    protected $empleo_carnet;

    /**
     *
     * @var integer
     */
    protected $empleo_sectorInteresId;

    /**
     *
     * @var integer
     */
    protected $empleo_puestoId;

    /**
     *
     * @var integer
     */
    protected $empleo_habilitado;

    /**
     * Method to set the value of field empleo_id
     *
     * @param integer $empleo_id
     * @return $this
     */
    public function setEmpleoId($empleo_id)
    {
        $this->empleo_id = $empleo_id;

        return $this;
    }

    /**
     * Method to set the value of field empleo_curriculumId
     *
     * @param integer $empleo_curriculumId
     * @return $this
     */
    public function setEmpleoCurriculumid($empleo_curriculumId)
    {
        $this->empleo_curriculumId = $empleo_curriculumId;

        return $this;
    }

    /**
     * Method to set the value of field empleo_disponibilidad
     *
     * @param string $empleo_disponibilidad
     * @return $this
     */
    public function setEmpleoDisponibilidad($empleo_disponibilidad)
    {
        $this->empleo_disponibilidad = $empleo_disponibilidad;

        return $this;
    }

    /**
     * Method to set the value of field empleo_carnet
     *
     * @param integer $empleo_carnet
     * @return $this
     */
    public function setEmpleoCarnet($empleo_carnet)
    {
        $this->empleo_carnet = $empleo_carnet;

        return $this;
    }

    /**
     * Method to set the value of field empleo_sectorInteresId
     *
     * @param integer $empleo_sectorInteresId
     * @return $this
     */
    public function setEmpleoSectorinteresid($empleo_sectorInteresId)
    {
        $this->empleo_sectorInteresId = $empleo_sectorInteresId;

        return $this;
    }

    /**
     * Method to set the value of field empleo_puestoId
     *
     * @param integer $empleo_puestoId
     * @return $this
     */
    public function setEmpleoPuestoid($empleo_puestoId)
    {
        $this->empleo_puestoId = $empleo_puestoId;

        return $this;
    }

    /**
     * Method to set the value of field empleo_habilitado
     *
     * @param integer $empleo_habilitado
     * @return $this
     */
    public function setEmpleoHabilitado($empleo_habilitado)
    {
        $this->empleo_habilitado = $empleo_habilitado;

        return $this;
    }

    /**
     * Returns the value of field empleo_id
     *
     * @return integer
     */
    public function getEmpleoId()
    {
        return $this->empleo_id;
    }

    /**
     * Returns the value of field empleo_curriculumId
     *
     * @return integer
     */
    public function getEmpleoCurriculumid()
    {
        return $this->empleo_curriculumId;
    }

    /**
     * Returns the value of field empleo_disponibilidad
     *
     * @return string
     */
    public function getEmpleoDisponibilidad()
    {
        return $this->empleo_disponibilidad;
    }

    /**
     * Returns the value of field empleo_carnet
     *
     * @return integer
     */
    public function getEmpleoCarnet()
    {
        return $this->empleo_carnet;
    }

    /**
     * Returns the value of field empleo_sectorInteresId
     *
     * @return integer
     */
    public function getEmpleoSectorinteresid()
    {
        return $this->empleo_sectorInteresId;
    }

    /**
     * Returns the value of field empleo_puestoId
     *
     * @return integer
     */
    public function getEmpleoPuestoid()
    {
        return $this->empleo_puestoId;
    }

    /**
     * Returns the value of field empleo_habilitado
     *
     * @return integer
     */
    public function getEmpleoHabilitado()
    {
        return $this->empleo_habilitado;
    }

    /**
     * Initialize method for model.
     */
    public function initialize()
    {
        $this->belongsTo('empleo_puestoId', 'Puesto', 'puesto_id', array('alias' => 'Puesto'));
        $this->belongsTo('empleo_sectorInteresId', 'Sectorinteres', 'sectorInteres_id', array('alias' => 'Sectorinteres'));
        $this->belongsTo('empleo_curriculumId', 'Curriculum', 'curriculum_id', array('alias' => 'Curriculum'));
    }

    /**
     * Returns table name mapped in the model.
     *
     * @return string
     */
    public function getSource()
    {
        return 'empleo';
    }

    /**
     * Allows to query a set of records that match the specified conditions
     *
     * @param mixed $parameters
     * @return Empleo[]
     */
    public static function find($parameters = null)
    {
        return parent::find($parameters);
    }

    /**
     * Allows to query the first record that match the specified conditions
     *
     * @param mixed $parameters
     * @return Empleo
     */
    public static function findFirst($parameters = null)
    {
        return parent::findFirst($parameters);
    }

}
