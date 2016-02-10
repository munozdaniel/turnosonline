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
    protected $curriculum_habilitado;

    /**
     *
     * @var string
     */
    protected $curriculum_fechaCreacion;

    /**
     *
     * @var string
     */
    protected $curriculum_ultimaModificacion;

    /**
     *
     * @var string
     */
    protected $curriculum_adjunto;

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
     * Method to set the value of field curriculum_fechaCreacion
     *
     * @param string $curriculum_fechaCreacion
     * @return $this
     */
    public function setCurriculumFechacreacion($curriculum_fechaCreacion)
    {
        $this->curriculum_fechaCreacion = $curriculum_fechaCreacion;

        return $this;
    }

    /**
     * Method to set the value of field curriculum_ultimaModificacion
     *
     * @param string $curriculum_ultimaModificacion
     * @return $this
     */
    public function setCurriculumUltimamodificacion($curriculum_ultimaModificacion)
    {
        $this->curriculum_ultimaModificacion = $curriculum_ultimaModificacion;

        return $this;
    }

    /**
     * Method to set the value of field curriculum_adjunto
     *
     * @param string $curriculum_adjunto
     * @return $this
     */
    public function setCurriculumAdjunto($curriculum_adjunto)
    {
        $this->curriculum_adjunto = $curriculum_adjunto;

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
     * @return string
     */
    public function getCurriculumFechacreacion()
    {
        return $this->curriculum_fechaCreacion;
    }

    /**
     * Returns the value of field curriculum_ultimaModificacion
     *
     * @return string
     */
    public function getCurriculumUltimamodificacion()
    {
        return $this->curriculum_ultimaModificacion;
    }

    /**
     * Returns the value of field curriculum_adjunto
     *
     * @return string
     */
    public function getCurriculumAdjunto()
    {
        return $this->curriculum_adjunto;
    }

    /**
     * Initialize method for model.
     */
    public function initialize()
    {
        $this->hasMany('curriculum_id', 'Curriculum\Conocimientos', 'conocimientos_curriculumId', array('alias' => 'Conocimientos'));
        $this->hasMany('curriculum_id', 'Curriculum\Empleo', 'empleo_curriculumId', array('alias' => 'Empleo'));
        $this->hasMany('curriculum_id', 'Curriculum\Experiencia', 'experiencia_curriculumId', array('alias' => 'Experiencia'));
        $this->hasMany('curriculum_id', 'Curriculum\Formacion', 'formacion_curriculumId', array('alias' => 'Formacion'));
        $this->hasMany('curriculum_id', 'Curriculum\Idiomas', 'idiomas_curriculumId', array('alias' => 'Idiomas'));
        $this->hasMany('curriculum_id', 'Curriculum\Informatica', 'informatica_curriculumId', array('alias' => 'Informatica'));
        $this->hasMany('curriculum_id', 'Curriculum\Persona', 'persona_curriculumId', array('alias' => 'Persona'));
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
