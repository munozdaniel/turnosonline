<?php
namespace Curriculum;
use Phalcon\Mvc\Model\Validator\PresenceOf;
use Phalcon\Mvc\Model\Validator\Uniqueness;

class Idiomas extends \Phalcon\Mvc\Model
{

    /**
     *
     * @var integer
     */
    protected $idiomas_id;

    /**
     *
     * @var integer
     */
    protected $idiomas_curriculumId;

    /**
     *
     * @var string
     */
    protected $idiomas_nombre;

    /**
     *
     * @var integer
     */
    protected $idiomas_nivelId;

    /**
     *
     * @var integer
     */
    protected $idiomas_habilitado;

    /**
     * Method to set the value of field idiomas_id
     *
     * @param integer $idiomas_id
     * @return $this
     */
    public function setIdiomasId($idiomas_id)
    {
        $this->idiomas_id = $idiomas_id;

        return $this;
    }

    /**
     * Method to set the value of field idiomas_curriculumId
     *
     * @param integer $idiomas_curriculumId
     * @return $this
     */
    public function setIdiomasCurriculumid($idiomas_curriculumId)
    {
        $this->idiomas_curriculumId = $idiomas_curriculumId;

        return $this;
    }

    /**
     * Method to set the value of field idiomas_nombre
     *
     * @param string $idiomas_nombre
     * @return $this
     */
    public function setIdiomasNombre($idiomas_nombre)
    {
        $this->idiomas_nombre = $idiomas_nombre;

        return $this;
    }

    /**
     * Method to set the value of field idiomas_nivelId
     *
     * @param integer $idiomas_nivelId
     * @return $this
     */
    public function setIdiomasNivelid($idiomas_nivelId)
    {
        $this->idiomas_nivelId = $idiomas_nivelId;

        return $this;
    }

    /**
     * Method to set the value of field nivel_habilitado
     *
     * @param integer $nivel_habilitado
     * @return $this
     */
    public function setIdiomasHabilitado($idiomas_habilitado)
    {
        $this->idiomas_habilitado = $idiomas_habilitado;

        return $this;
    }

    /**
     * Returns the value of field idiomas_id
     *
     * @return integer
     */
    public function getIdiomasId()
    {
        return $this->idiomas_id;
    }

    /**
     * Returns the value of field idiomas_curriculumId
     *
     * @return integer
     */
    public function getIdiomasCurriculumid()
    {
        return $this->idiomas_curriculumId;
    }

    /**
     * Returns the value of field idiomas_nombre
     *
     * @return string
     */
    public function getIdiomasNombre()
    {
        return $this->idiomas_nombre;
    }

    /**
     * Returns the value of field idiomas_nivelId
     *
     * @return integer
     */
    public function getIdiomasNivelid()
    {
        return $this->idiomas_nivelId;
    }

    /**
     * Returns the value of field nivel_habilitado
     *
     * @return integer
     */
    public function getIdiomasHabilitado()
    {
        return $this->idiomas_habilitado;
    }

    /**
     * Initialize method for model.
     */
    public function initialize()
    {
        $this->belongsTo('idiomas_curriculumId', 'Curriculum\Curriculum', 'curriculum_id', array('alias' => 'Curriculum'));
        $this->belongsTo('idiomas_nivelId', 'Curriculum\Nivel', 'nivel_id', array('alias' => 'Nivel'));
    }

    /**
     * Returns table name mapped in the model.
     *
     * @return string
     */
    public function getSource()
    {
        return 'idiomas';
    }

    /**
     * Allows to query a set of records that match the specified conditions
     *
     * @param mixed $parameters
     * @return Idiomas[]
     */
    public static function find($parameters = null)
    {
        return parent::find($parameters);
    }

    /**
     * Allows to query the first record that match the specified conditions
     *
     * @param mixed $parameters
     * @return Idiomas
     */
    public static function findFirst($parameters = null)
    {
        return parent::findFirst($parameters);
    }
    public function validation()
    {
        $this->validate(new Uniqueness(array(
            "field"   => array("idiomas_nombre",'idiomas_curriculumId'),
            "message" => "El Idioma seleccionado ya fue agregado"
        )));

        if ($this->validationHasFailed() == true) {
            return false;
        }
    }
}
