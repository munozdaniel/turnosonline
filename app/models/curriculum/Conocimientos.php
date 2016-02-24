<?php
namespace Curriculum;

use Phalcon\Mvc\Model\Validator\PresenceOf;
use Phalcon\Mvc\Model\Validator\Uniqueness;

class Conocimientos extends \Phalcon\Mvc\Model
{

    /**
     *
     * @var integer
     */
    protected $conocimientos_id;

    /**
     *
     * @var integer
     */
    protected $conocimientos_curriculumId;

    /**
     *
     * @var string
     */
    protected $conocimientos_nombre;

    /**
     *
     * @var integer
     */
    protected $conocimientos_nivelId;

    /**
     *
     * @var integer
     */
    protected $conocimientos_habilitado;

    /**
     * Method to set the value of field conocimientos_id
     *
     * @param integer $conocimientos_id
     * @return $this
     */
    public function setConocimientosId($conocimientos_id)
    {
        $this->conocimientos_id = $conocimientos_id;

        return $this;
    }

    /**
     * Method to set the value of field conocimientos_curriculumId
     *
     * @param integer $conocimientos_curriculumId
     * @return $this
     */
    public function setConocimientosCurriculumid($conocimientos_curriculumId)
    {
        $this->conocimientos_curriculumId = $conocimientos_curriculumId;

        return $this;
    }

    /**
     * Method to set the value of field conocimientos_nombre
     *
     * @param string $conocimientos_nombre
     * @return $this
     */
    public function setConocimientosNombre($conocimientos_nombre)
    {
        $this->conocimientos_nombre = $conocimientos_nombre;

        return $this;
    }

    /**
     * Method to set the value of field conocimientos_nivelId
     *
     * @param integer $conocimientos_nivelId
     * @return $this
     */
    public function setConocimientosNivelid($conocimientos_nivelId)
    {
        $this->conocimientos_nivelId = $conocimientos_nivelId;

        return $this;
    }

    /**
     * Method to set the value of field conocimientos_habilitado
     *
     * @param integer $conocimientos_habilitado
     * @return $this
     */
    public function setConocimientosHabilitado($conocimientos_habilitado)
    {
        $this->conocimientos_habilitado = $conocimientos_habilitado;

        return $this;
    }

    /**
     * Returns the value of field conocimientos_id
     *
     * @return integer
     */
    public function getConocimientosId()
    {
        return $this->conocimientos_id;
    }

    /**
     * Returns the value of field conocimientos_curriculumId
     *
     * @return integer
     */
    public function getConocimientosCurriculumid()
    {
        return $this->conocimientos_curriculumId;
    }

    /**
     * Returns the value of field conocimientos_nombre
     *
     * @return string
     */
    public function getConocimientosNombre()
    {
        return $this->conocimientos_nombre;
    }

    /**
     * Returns the value of field conocimientos_nivelId
     *
     * @return integer
     */
    public function getConocimientosNivelid()
    {
        return $this->conocimientos_nivelId;
    }

    /**
     * Returns the value of field conocimientos_habilitado
     *
     * @return integer
     */
    public function getConocimientosHabilitado()
    {
        return $this->conocimientos_habilitado;
    }

    /**
     * Initialize method for model.
     */
    public function initialize()
    {
        $this->belongsTo('conocimientos_curriculumId', 'Curriculum\Curriculum', 'curriculum_id', array('alias' => 'Curriculum'));
        $this->belongsTo('conocimientos_nivelId', 'Curriculum\Nivel', 'nivel_id', array('alias' => 'Nivel'));
    }

    /**
     * Returns table name mapped in the model.
     *
     * @return string
     */
    public function getSource()
    {
        return 'conocimientos';
    }

    /**
     * Allows to query a set of records that match the specified conditions
     *
     * @param mixed $parameters
     * @return Conocimientos[]
     */
    public static function find($parameters = null)
    {
        return parent::find($parameters);
    }

    /**
     * Allows to query the first record that match the specified conditions
     *
     * @param mixed $parameters
     * @return Conocimientos
     */
    public static function findFirst($parameters = null)
    {
        return parent::findFirst($parameters);
    }
    public function validation()
    {

        $this->validate(new Uniqueness(array(
            "field"   => array('conocimientos_nombre','conocimientos_curriculumId'),
            "message" => "La Aptitud/Curso seleccionado ya fue agregada"
        )));
        $this->validate(new PresenceOf(array(
        "field" => 'conocimientos_nombre',
        "message" => 'La Aptitud/Curso es requerida'
        )));
        $this->validate(new PresenceOf(array(
            "field" => 'conocimientos_nivelId',
            "message" => 'El Nivel es requerido'
        )));
        if ($this->validationHasFailed() == true) {
            return false;
        }
        return true;
    }
}
