<?php
namespace Curriculum;

class Formacion extends \Phalcon\Mvc\Model
{

    /**
     *
     * @var integer
     */
    protected $formacion_id;

    /**
     *
     * @var integer
     */
    protected $formacion_curriculumId;

    /**
     *
     * @var string
     */
    protected $formacion_institucion;

    /**
     *
     * @var integer
     */
    protected $formacion_gradoId;

    /**
     *
     * @var string
     */
    protected $formacion_titulo;

    /**
     *
     * @var integer
     */
    protected $formacion_estadoId;

    /**
     *
     * @var string
     */
    protected $formacion_fechaInicio;

    /**
     *
     * @var string
     */
    protected $formacion_fechaFinal;

    /**
     *
     * @var integer
     */
    protected $formacion_fechaActual;

    /**
     *
     * @var integer
     */
    protected $formacion_habilitado;

    /**
     * Method to set the value of field formacion_id
     *
     * @param integer $formacion_id
     * @return $this
     */
    public function setFormacionId($formacion_id)
    {
        $this->formacion_id = $formacion_id;

        return $this;
    }

    /**
     * Method to set the value of field formacion_curriculumId
     *
     * @param integer $formacion_curriculumId
     * @return $this
     */
    public function setFormacionCurriculumid($formacion_curriculumId)
    {
        $this->formacion_curriculumId = $formacion_curriculumId;

        return $this;
    }

    /**
     * Method to set the value of field formacion_institucion
     *
     * @param string $formacion_institucion
     * @return $this
     */
    public function setFormacionInstitucion($formacion_institucion)
    {
        $this->formacion_institucion = $formacion_institucion;

        return $this;
    }

    /**
     * Method to set the value of field formacion_gradoId
     *
     * @param integer $formacion_gradoId
     * @return $this
     */
    public function setFormacionGradoid($formacion_gradoId)
    {
        $this->formacion_gradoId = $formacion_gradoId;

        return $this;
    }

    /**
     * Method to set the value of field formacion_titulo
     *
     * @param string $formacion_titulo
     * @return $this
     */
    public function setFormacionTitulo($formacion_titulo)
    {
        $this->formacion_titulo = $formacion_titulo;

        return $this;
    }

    /**
     * Method to set the value of field formacion_estadoId
     *
     * @param integer $formacion_estadoId
     * @return $this
     */
    public function setFormacionEstadoid($formacion_estadoId)
    {
        $this->formacion_estadoId = $formacion_estadoId;

        return $this;
    }

    /**
     * Method to set the value of field formacion_fechaInicio
     *
     * @param string $formacion_fechaInicio
     * @return $this
     */
    public function setFormacionFechainicio($formacion_fechaInicio)
    {
        $this->formacion_fechaInicio = $formacion_fechaInicio;

        return $this;
    }

    /**
     * Method to set the value of field formacion_fechaFinal
     *
     * @param string $formacion_fechaFinal
     * @return $this
     */
    public function setFormacionFechafinal($formacion_fechaFinal)
    {
        $this->formacion_fechaFinal = $formacion_fechaFinal;

        return $this;
    }

    /**
     * Method to set the value of field formacion_fechaActual
     *
     * @param integer $formacion_fechaActual
     * @return $this
     */
    public function setFormacionFechaactual($formacion_fechaActual)
    {
        $this->formacion_fechaActual = $formacion_fechaActual;

        return $this;
    }

    /**
     * Method to set the value of field formacion_habilitado
     *
     * @param integer $formacion_habilitado
     * @return $this
     */
    public function setFormacionHabilitado($formacion_habilitado)
    {
        $this->formacion_habilitado = $formacion_habilitado;

        return $this;
    }

    /**
     * Returns the value of field formacion_id
     *
     * @return integer
     */
    public function getFormacionId()
    {
        return $this->formacion_id;
    }

    /**
     * Returns the value of field formacion_curriculumId
     *
     * @return integer
     */
    public function getFormacionCurriculumid()
    {
        return $this->formacion_curriculumId;
    }

    /**
     * Returns the value of field formacion_institucion
     *
     * @return string
     */
    public function getFormacionInstitucion()
    {
        return $this->formacion_institucion;
    }

    /**
     * Returns the value of field formacion_gradoId
     *
     * @return integer
     */
    public function getFormacionGradoid()
    {
        return $this->formacion_gradoId;
    }

    /**
     * Returns the value of field formacion_titulo
     *
     * @return string
     */
    public function getFormacionTitulo()
    {
        return $this->formacion_titulo;
    }

    /**
     * Returns the value of field formacion_estadoId
     *
     * @return integer
     */
    public function getFormacionEstadoid()
    {
        return $this->formacion_estadoId;
    }

    /**
     * Returns the value of field formacion_fechaInicio
     *
     * @return string
     */
    public function getFormacionFechainicio()
    {
        return $this->formacion_fechaInicio;
    }

    /**
     * Returns the value of field formacion_fechaFinal
     *
     * @return string
     */
    public function getFormacionFechafinal()
    {
        return $this->formacion_fechaFinal;
    }

    /**
     * Returns the value of field formacion_fechaActual
     *
     * @return integer
     */
    public function getFormacionFechaactual()
    {
        return $this->formacion_fechaActual;
    }

    /**
     * Returns the value of field formacion_habilitado
     *
     * @return integer
     */
    public function getFormacionHabilitado()
    {
        return $this->formacion_habilitado;
    }

    /**
     * Initialize method for model.
     */
    public function initialize()
    {
        $this->belongsTo('formacion_curriculumId', 'Curriculum', 'curriculum_id', array('alias' => 'Curriculum'));
        $this->belongsTo('formacion_gradoId', 'Grado', 'grado_id', array('alias' => 'Grado'));
        $this->belongsTo('formacion_estadoId', 'Estado', 'estado_id', array('alias' => 'Estado'));
    }

    /**
     * Returns table name mapped in the model.
     *
     * @return string
     */
    public function getSource()
    {
        return 'formacion';
    }

    /**
     * Allows to query a set of records that match the specified conditions
     *
     * @param mixed $parameters
     * @return Formacion[]
     */
    public static function find($parameters = null)
    {
        return parent::find($parameters);
    }

    /**
     * Allows to query the first record that match the specified conditions
     *
     * @param mixed $parameters
     * @return Formacion
     */
    public static function findFirst($parameters = null)
    {
        return parent::findFirst($parameters);
    }

}
