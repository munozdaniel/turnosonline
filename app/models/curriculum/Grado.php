<?php
namespace Curriculum;

class Grado extends \Phalcon\Mvc\Model
{

    /**
     *
     * @var integer
     */
    protected $grado_id;

    /**
     *
     * @var string
     */
    protected $grado_nombre;

    /**
     * Method to set the value of field grado_id
     *
     * @param integer $grado_id
     * @return $this
     */
    public function setGradoId($grado_id)
    {
        $this->grado_id = $grado_id;

        return $this;
    }

    /**
     * Method to set the value of field grado_nombre
     *
     * @param string $grado_nombre
     * @return $this
     */
    public function setGradoNombre($grado_nombre)
    {
        $this->grado_nombre = $grado_nombre;

        return $this;
    }

    /**
     * Returns the value of field grado_id
     *
     * @return integer
     */
    public function getGradoId()
    {
        return $this->grado_id;
    }

    /**
     * Returns the value of field grado_nombre
     *
     * @return string
     */
    public function getGradoNombre()
    {
        return $this->grado_nombre;
    }

    /**
     * Initialize method for model.
     */
    public function initialize()
    {
        $this->hasMany('grado_id', 'Curriculum\Formacion', 'formacion_gradoId', array('alias' => 'Formacion'));
    }

    /**
     * Returns table name mapped in the model.
     *
     * @return string
     */
    public function getSource()
    {
        return 'grado';
    }

    /**
     * Allows to query a set of records that match the specified conditions
     *
     * @param mixed $parameters
     * @return Grado[]
     */
    public static function find($parameters = null)
    {
        return parent::find($parameters);
    }

    /**
     * Allows to query the first record that match the specified conditions
     *
     * @param mixed $parameters
     * @return Grado
     */
    public static function findFirst($parameters = null)
    {
        return parent::findFirst($parameters);
    }

}
