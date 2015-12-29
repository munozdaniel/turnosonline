<?php
namespace Curriculum;

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
     * Initialize method for model.
     */
    public function initialize()
    {
        $this->hasMany('curriculum_id', 'Experiencia', 'experiencia_curriculumId', array('alias' => 'Experiencia'));
        $this->hasMany('curriculum_id', 'Formacion', 'formacion_curriculumId', array('alias' => 'Formacion'));
        $this->hasMany('curriculum_id', 'Idiomas', 'idiomas_curriculumId', array('alias' => 'Idiomas'));
        $this->hasMany('curriculum_id', 'Informatica', 'informatica_curriculumId', array('alias' => 'Informatica'));
        $this->hasMany('curriculum_id', 'Persona', 'persona_curriculumId', array('alias' => 'Persona'));
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
