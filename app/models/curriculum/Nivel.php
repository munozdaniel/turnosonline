<?php
namespace Curriculum;

class Nivel extends \Phalcon\Mvc\Model
{

    /**
     *
     * @var integer
     */
    protected $nivel_id;

    /**
     *
     * @var string
     */
    protected $nivel_nombre;

    /**
     * Method to set the value of field nivel_id
     *
     * @param integer $nivel_id
     * @return $this
     */
    public function setNivelId($nivel_id)
    {
        $this->nivel_id = $nivel_id;

        return $this;
    }

    /**
     * Method to set the value of field nivel_nombre
     *
     * @param string $nivel_nombre
     * @return $this
     */
    public function setNivelNombre($nivel_nombre)
    {
        $this->nivel_nombre = $nivel_nombre;

        return $this;
    }

    /**
     * Returns the value of field nivel_id
     *
     * @return integer
     */
    public function getNivelId()
    {
        return $this->nivel_id;
    }

    /**
     * Returns the value of field nivel_nombre
     *
     * @return string
     */
    public function getNivelNombre()
    {
        return $this->nivel_nombre;
    }

    /**
     * Initialize method for model.
     */
    public function initialize()
    {
        $this->hasMany('nivel_id', 'Idiomas', 'idiomas_nivelId', array('alias' => 'Idiomas'));
        $this->hasMany('nivel_id', 'Informatica', 'informatica_nivelId', array('alias' => 'Informatica'));
    }

    /**
     * Returns table name mapped in the model.
     *
     * @return string
     */
    public function getSource()
    {
        return 'nivel';
    }

    /**
     * Allows to query a set of records that match the specified conditions
     *
     * @param mixed $parameters
     * @return Nivel[]
     */
    public static function find($parameters = null)
    {
        return parent::find($parameters);
    }

    /**
     * Allows to query the first record that match the specified conditions
     *
     * @param mixed $parameters
     * @return Nivel
     */
    public static function findFirst($parameters = null)
    {
        return parent::findFirst($parameters);
    }

}
