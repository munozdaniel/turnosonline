<?php
namespace Curriculum;

class Experiencia extends \Phalcon\Mvc\Model
{

    /**
     *
     * @var integer
     */
    protected $experiencia_id;

    /**
     *
     * @var integer
     */
    protected $experiencia_curriculumId;

    /**
     *
     * @var string
     */
    protected $experiencia_empresa;

    /**
     *
     * @var string
     */
    protected $experiencia_rubro;

    /**
     *
     * @var string
     */
    protected $experiencia_cargo;

    /**
     *
     * @var string
     */
    protected $experiencia_tareas;

    /**
     *
     * @var string
     */
    protected $experiencia_fechaInicio;

    /**
     *
     * @var string
     */
    protected $experiencia_fechaFinal;

    /**
     *
     * @var integer
     */
    protected $experiencia_fechaActual;

    /**
     *
     * @var integer
     */
    protected $experiencia_habilitado;

    /**
     *
     * @var integer
     */
    protected $experiencia_provinciaId;

    /**
     * Method to set the value of field experiencia_id
     *
     * @param integer $experiencia_id
     * @return $this
     */
    public function setExperienciaId($experiencia_id)
    {
        $this->experiencia_id = $experiencia_id;

        return $this;
    }

    /**
     * Method to set the value of field experiencia_curriculumId
     *
     * @param integer $experiencia_curriculumId
     * @return $this
     */
    public function setExperienciaCurriculumid($experiencia_curriculumId)
    {
        $this->experiencia_curriculumId = $experiencia_curriculumId;

        return $this;
    }

    /**
     * Method to set the value of field experiencia_empresa
     *
     * @param string $experiencia_empresa
     * @return $this
     */
    public function setExperienciaEmpresa($experiencia_empresa)
    {
        $this->experiencia_empresa = $experiencia_empresa;

        return $this;
    }

    /**
     * Method to set the value of field experiencia_rubro
     *
     * @param string $experiencia_rubro
     * @return $this
     */
    public function setExperienciaRubro($experiencia_rubro)
    {
        $this->experiencia_rubro = $experiencia_rubro;

        return $this;
    }

    /**
     * Method to set the value of field experiencia_cargo
     *
     * @param string $experiencia_cargo
     * @return $this
     */
    public function setExperienciaCargo($experiencia_cargo)
    {
        $this->experiencia_cargo = $experiencia_cargo;

        return $this;
    }

    /**
     * Method to set the value of field experiencia_tareas
     *
     * @param string $experiencia_tareas
     * @return $this
     */
    public function setExperienciaTareas($experiencia_tareas)
    {
        $this->experiencia_tareas = $experiencia_tareas;

        return $this;
    }

    /**
     * Method to set the value of field experiencia_fechaInicio
     *
     * @param string $experiencia_fechaInicio
     * @return $this
     */
    public function setExperienciaFechainicio($experiencia_fechaInicio)
    {
        $this->experiencia_fechaInicio = $experiencia_fechaInicio;

        return $this;
    }

    /**
     * Method to set the value of field experiencia_fechaFinal
     *
     * @param string $experiencia_fechaFinal
     * @return $this
     */
    public function setExperienciaFechafinal($experiencia_fechaFinal)
    {
        $this->experiencia_fechaFinal = $experiencia_fechaFinal;

        return $this;
    }

    /**
     * Method to set the value of field experiencia_fechaActual
     *
     * @param integer $experiencia_fechaActual
     * @return $this
     */
    public function setExperienciaFechaactual($experiencia_fechaActual)
    {
        $this->experiencia_fechaActual = $experiencia_fechaActual;

        return $this;
    }

    /**
     * Method to set the value of field experiencia_habilitado
     *
     * @param integer $experiencia_habilitado
     * @return $this
     */
    public function setExperienciaHabilitado($experiencia_habilitado)
    {
        $this->experiencia_habilitado = $experiencia_habilitado;

        return $this;
    }

    /**
     * Method to set the value of field experiencia_provinciaId
     *
     * @param integer $experiencia_provinciaId
     * @return $this
     */
    public function setExperienciaProvinciaid($experiencia_provinciaId)
    {
        $this->experiencia_provinciaId = $experiencia_provinciaId;

        return $this;
    }

    /**
     * Returns the value of field experiencia_id
     *
     * @return integer
     */
    public function getExperienciaId()
    {
        return $this->experiencia_id;
    }

    /**
     * Returns the value of field experiencia_curriculumId
     *
     * @return integer
     */
    public function getExperienciaCurriculumid()
    {
        return $this->experiencia_curriculumId;
    }

    /**
     * Returns the value of field experiencia_empresa
     *
     * @return string
     */
    public function getExperienciaEmpresa()
    {
        return $this->experiencia_empresa;
    }

    /**
     * Returns the value of field experiencia_rubro
     *
     * @return string
     */
    public function getExperienciaRubro()
    {
        return $this->experiencia_rubro;
    }

    /**
     * Returns the value of field experiencia_cargo
     *
     * @return string
     */
    public function getExperienciaCargo()
    {
        return $this->experiencia_cargo;
    }

    /**
     * Returns the value of field experiencia_tareas
     *
     * @return string
     */
    public function getExperienciaTareas()
    {
        return $this->experiencia_tareas;
    }

    /**
     * Returns the value of field experiencia_fechaInicio
     *
     * @return string
     */
    public function getExperienciaFechainicio()
    {
        return $this->experiencia_fechaInicio;
    }

    /**
     * Returns the value of field experiencia_fechaFinal
     *
     * @return string
     */
    public function getExperienciaFechafinal()
    {
        return $this->experiencia_fechaFinal;
    }

    /**
     * Returns the value of field experiencia_fechaActual
     *
     * @return integer
     */
    public function getExperienciaFechaactual()
    {
        return $this->experiencia_fechaActual;
    }

    /**
     * Returns the value of field experiencia_habilitado
     *
     * @return integer
     */
    public function getExperienciaHabilitado()
    {
        return $this->experiencia_habilitado;
    }

    /**
     * Returns the value of field experiencia_provinciaId
     *
     * @return integer
     */
    public function getExperienciaProvinciaid()
    {
        return $this->experiencia_provinciaId;
    }

    /**
     * Initialize method for model.
     */
    public function initialize()
    {
        $this->belongsTo('experiencia_provinciaId', 'Curriculum\Provincia', 'provincia_id', array('alias' => 'Provincia'));
        $this->belongsTo('experiencia_curriculumId', 'Curriculum\Curriculum', 'curriculum_id', array('alias' => 'Curriculum'));
    }

    /**
     * Returns table name mapped in the model.
     *
     * @return string
     */
    public function getSource()
    {
        return 'experiencia';
    }

    /**
     * Allows to query a set of records that match the specified conditions
     *
     * @param mixed $parameters
     * @return Experiencia[]
     */
    public static function find($parameters = null)
    {
        return parent::find($parameters);
    }

    /**
     * Allows to query the first record that match the specified conditions
     *
     * @param mixed $parameters
     * @return Experiencia
     */
    public static function findFirst($parameters = null)
    {
        return parent::findFirst($parameters);
    }

}
