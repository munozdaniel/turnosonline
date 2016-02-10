<?php
namespace Curriculum;

class Informatica extends \Phalcon\Mvc\Model
{

    /**
     *
     * @var integer
     */
    protected $informatica_id;

    /**
     *
     * @var integer
     */
    protected $informatica_curriculumId;

    /**
     *
     * @var string
     */
    protected $informatica_nombre;

    /**
     *
     * @var integer
     */
    protected $informatica_nivelId;

    /**
     *
     * @var integer
     */
    protected $informatica_habilitado;

    /**
     * Method to set the value of field informatica_id
     *
     * @param integer $informatica_id
     * @return $this
     */
    public function setInformaticaId($informatica_id)
    {
        $this->informatica_id = $informatica_id;

        return $this;
    }

    /**
     * Method to set the value of field informatica_curriculumId
     *
     * @param integer $informatica_curriculumId
     * @return $this
     */
    public function setInformaticaCurriculumid($informatica_curriculumId)
    {
        $this->informatica_curriculumId = $informatica_curriculumId;

        return $this;
    }

    /**
     * Method to set the value of field informatica_nombre
     *
     * @param string $informatica_nombre
     * @return $this
     */
    public function setInformaticaNombre($informatica_nombre)
    {
        $this->informatica_nombre = $informatica_nombre;

        return $this;
    }

    /**
     * Method to set the value of field informatica_nivelId
     *
     * @param integer $informatica_nivelId
     * @return $this
     */
    public function setInformaticaNivelid($informatica_nivelId)
    {
        $this->informatica_nivelId = $informatica_nivelId;

        return $this;
    }

    /**
     * Method to set the value of field informatica_habilitado
     *
     * @param integer $informatica_habilitado
     * @return $this
     */
    public function setInformaticaHabilitado($informatica_habilitado)
    {
        $this->informatica_habilitado = $informatica_habilitado;

        return $this;
    }

    /**
     * Returns the value of field informatica_id
     *
     * @return integer
     */
    public function getInformaticaId()
    {
        return $this->informatica_id;
    }

    /**
     * Returns the value of field informatica_curriculumId
     *
     * @return integer
     */
    public function getInformaticaCurriculumid()
    {
        return $this->informatica_curriculumId;
    }

    /**
     * Returns the value of field informatica_nombre
     *
     * @return string
     */
    public function getInformaticaNombre()
    {
        return $this->informatica_nombre;
    }

    /**
     * Returns the value of field informatica_nivelId
     *
     * @return integer
     */
    public function getInformaticaNivelid()
    {
        return $this->informatica_nivelId;
    }

    /**
     * Returns the value of field informatica_habilitado
     *
     * @return integer
     */
    public function getInformaticaHabilitado()
    {
        return $this->informatica_habilitado;
    }

    /**
     * Initialize method for model.
     */
    public function initialize()
    {
        $this->belongsTo('informatica_curriculumId', 'Curriculum\Curriculum', 'curriculum_id', array('alias' => 'Curriculum'));
        $this->belongsTo('informatica_nivelId', 'Curriculum\Nivel', 'nivel_id', array('alias' => 'Nivel'));
    }

    /**
     * Returns table name mapped in the model.
     *
     * @return string
     */
    public function getSource()
    {
        return 'informatica';
    }

    /**
     * Allows to query a set of records that match the specified conditions
     *
     * @param mixed $parameters
     * @return Informatica[]
     */
    public static function find($parameters = null)
    {
        return parent::find($parameters);
    }

    /**
     * Allows to query the first record that match the specified conditions
     *
     * @param mixed $parameters
     * @return Informatica
     */
    public static function findFirst($parameters = null)
    {
        return parent::findFirst($parameters);
    }

}
