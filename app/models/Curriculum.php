<?php

class Curriculum extends \Phalcon\Mvc\Model
{

    /**
     *
     * @var integer
     */
    protected $curriculum_id;

    /**
     *
     * @var integer
     */
    protected $curriculum_personaId;

    /**
     *
     * @var integer
     */
    protected $curriculum_experienciaId;

    /**
     *
     * @var integer
     */
    protected $curriculum_formacionId;

    /**
     *
     * @var integer
     */
    protected $curriculum_idiomasId;

    /**
     *
     * @var integer
     */
    protected $curriculum_informaticaId;

    /**
     *
     * @var integer
     */
    protected $curriculum_habilitado;
    /**
     *
     * @var integer
     */
    protected $curriculum_fechaCreacion;

    /**
     * Method to set the value of field curriculum_id
     *
     * @param integer $curriculum_id
     * @return $this
     */
    public function setCurriculumId($curriculum_id)
    {
        $this->curriculum_id = $curriculum_id;

        return $this;
    }

    /**
     * Method to set the value of field curriculum_personaId
     *
     * @param integer $curriculum_personaId
     * @return $this
     */
    public function setCurriculumPersonaid($curriculum_personaId)
    {
        $this->curriculum_personaId = $curriculum_personaId;

        return $this;
    }

    /**
     * Method to set the value of field curriculum_experienciaId
     *
     * @param integer $curriculum_experienciaId
     * @return $this
     */
    public function setCurriculumExperienciaid($curriculum_experienciaId)
    {
        $this->curriculum_experienciaId = $curriculum_experienciaId;

        return $this;
    }

    /**
     * Method to set the value of field curriculum_formacionId
     *
     * @param integer $curriculum_formacionId
     * @return $this
     */
    public function setCurriculumFormacionid($curriculum_formacionId)
    {
        $this->curriculum_formacionId = $curriculum_formacionId;

        return $this;
    }

    /**
     * Method to set the value of field curriculum_idiomasId
     *
     * @param integer $curriculum_idiomasId
     * @return $this
     */
    public function setCurriculumIdiomasid($curriculum_idiomasId)
    {
        $this->curriculum_idiomasId = $curriculum_idiomasId;

        return $this;
    }

    /**
     * Method to set the value of field curriculum_informaticaId
     *
     * @param integer $curriculum_informaticaId
     * @return $this
     */
    public function setCurriculumInformaticaid($curriculum_informaticaId)
    {
        $this->curriculum_informaticaId = $curriculum_informaticaId;

        return $this;
    }

    /**
     * Method to set the value of field curriculum_habilitado
     *
     * @param integer $curriculum_habilitado
     * @return $this
     */
    public function setCurriculumHabilitado($curriculum_habilitado)
    {
        $this->curriculum_habilitado = $curriculum_habilitado;

        return $this;
    }
    /**
     * Method to set the value of field $curriculum_fechaCreacion
     *
     * @param integer $curriculum_fechaCreacion
     * @return $this
     */
    public function setCurriculumFechaCreacion($curriculum_fechaCreacion)
    {
        $this->curriculum_fechaCreacion = $curriculum_fechaCreacion;

        return $this;
    }
    /**
     * Returns the value of field curriculum_id
     *
     * @return integer
     */
    public function getCurriculumId()
    {
        return $this->curriculum_id;
    }

    /**
     * Returns the value of field curriculum_personaId
     *
     * @return integer
     */
    public function getCurriculumPersonaid()
    {
        return $this->curriculum_personaId;
    }

    /**
     * Returns the value of field curriculum_experienciaId
     *
     * @return integer
     */
    public function getCurriculumExperienciaid()
    {
        return $this->curriculum_experienciaId;
    }

    /**
     * Returns the value of field curriculum_formacionId
     *
     * @return integer
     */
    public function getCurriculumFormacionid()
    {
        return $this->curriculum_formacionId;
    }

    /**
     * Returns the value of field curriculum_idiomasId
     *
     * @return integer
     */
    public function getCurriculumIdiomasid()
    {
        return $this->curriculum_idiomasId;
    }

    /**
     * Returns the value of field curriculum_informaticaId
     *
     * @return integer
     */
    public function getCurriculumInformaticaid()
    {
        return $this->curriculum_informaticaId;
    }

    /**
     * Returns the value of field curriculum_habilitado
     *
     * @return integer
     */
    public function getCurriculumHabilitado()
    {
        return $this->curriculum_habilitado;
    }

    /**
     * Returns the value of field curriculum_fechaCreacion
     *
     * @return integer
     */
    public function getCurriculumFechaCreacion()
    {
        return $this->curriculum_fechaCreacion;
    }

    /**
     * Initialize method for model.
     */
    public function initialize()
    {
        $this->belongsTo('curriculum_informaticaId', 'Informatica', 'informatica_id', array('alias' => 'Informatica'));
        $this->belongsTo('curriculum_personaId', 'Persona', 'persona_id', array('alias' => 'Persona'));
        $this->belongsTo('curriculum_experienciaId', 'Experiencia', 'experiencia_id', array('alias' => 'Experiencia'));
        $this->belongsTo('curriculum_formacionId', 'Formacion', 'formacion_id', array('alias' => 'Formacion'));
        $this->belongsTo('curriculum_idiomasId', 'Idiomas', 'idiomas_id', array('alias' => 'Idiomas'));
    }

    /**
     * Returns table name mapped in the model.
     *
     * @return string
     */
    public function getSource()
    {
        return 'curriculum';
    }

    /**
     * Allows to query a set of records that match the specified conditions
     *
     * @param mixed $parameters
     * @return Curriculum[]
     */
    public static function find($parameters = null)
    {
        return parent::find($parameters);
    }

    /**
     * Allows to query the first record that match the specified conditions
     *
     * @param mixed $parameters
     * @return Curriculum
     */
    public static function findFirst($parameters = null)
    {
        return parent::findFirst($parameters);
    }

}
