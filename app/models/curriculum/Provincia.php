<?php
namespace Curriculum;

class Provincia extends \Phalcon\Mvc\Model
{

    /**
     *
     * @var integer
     */
    public $provincia_id;

    /**
     *
     * @var string
     */
    public $provincia_nombre;

    /**
     * Initialize method for model.
     */
    public function initialize()
    {
        $this->hasMany('provincia_id', 'Ciudad', 'ciudad_provinciaId', array('alias' => 'Ciudad'));
    }

    /**
     * Returns table name mapped in the model.
     *
     * @return string
     */
    public function getSource()
    {
        return 'provincia';
    }

    /**
     * Allows to query a set of records that match the specified conditions
     *
     * @param mixed $parameters
     * @return Provincia[]
     */
    public static function find($parameters = null)
    {
        return parent::find($parameters);
    }

    /**
     * Allows to query the first record that match the specified conditions
     *
     * @param mixed $parameters
     * @return Provincia
     */
    public static function findFirst($parameters = null)
    {
        return parent::findFirst($parameters);
    }

}
