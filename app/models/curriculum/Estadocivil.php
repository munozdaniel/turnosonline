<?php
namespace Curriculum;

class Estadocivil extends \Phalcon\Mvc\Model
{

    /**
     *
     * @var integer
     */
    public $estadoCivil_id;

    /**
     *
     * @var string
     */
    public $estadoCivil_nombre;

    /**
     * Initialize method for model.
     */
    public function initialize()
    {
        $this->hasMany('estadoCivil_id', 'Persona', 'persona_estadoCivilId', array('alias' => 'Persona'));
    }

    /**
     * Returns table name mapped in the model.
     *
     * @return string
     */
    public function getSource()
    {
        return 'estadocivil';
    }

    /**
     * Allows to query a set of records that match the specified conditions
     *
     * @param mixed $parameters
     * @return Estadocivil[]
     */
    public static function find($parameters = null)
    {
        return parent::find($parameters);
    }

    /**
     * Allows to query the first record that match the specified conditions
     *
     * @param mixed $parameters
     * @return Estadocivil
     */
    public static function findFirst($parameters = null)
    {
        return parent::findFirst($parameters);
    }

}
