<?php
namespace Curriculum;

class Nacionalidad extends \Phalcon\Mvc\Model
{

    /**
     *
     * @var integer
     */
    public $nacionalidad_id;

    /**
     *
     * @var string
     */
    public $nacionalidad_nombre;

    /**
     * Initialize method for model.
     */
    public function initialize()
    {
        $this->hasMany('nacionalidad_id', 'Persona', 'persona_nacionalidadId', array('alias' => 'Persona'));
    }

    /**
     * Returns table name mapped in the model.
     *
     * @return string
     */
    public function getSource()
    {
        return 'nacionalidad';
    }

    /**
     * Allows to query a set of records that match the specified conditions
     *
     * @param mixed $parameters
     * @return Nacionalidad[]
     */
    public static function find($parameters = null)
    {
        return parent::find($parameters);
    }

    /**
     * Allows to query the first record that match the specified conditions
     *
     * @param mixed $parameters
     * @return Nacionalidad
     */
    public static function findFirst($parameters = null)
    {
        return parent::findFirst($parameters);
    }

}
