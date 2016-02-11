<?php

class Poblaciones extends \Phalcon\Mvc\Model
{

    /**
     *
     * @var integer
     */
    public $idpoblacion;

    /**
     *
     * @var integer
     */
    public $idprovincia;

    /**
     *
     * @var string
     */
    public $poblacion;

    /**
     *
     * @var string
     */
    public $poblacionseo;

    /**
     *
     * @var integer
     */
    public $postal;

    /**
     *
     * @var double
     */
    public $latitud;

    /**
     *
     * @var double
     */
    public $longitud;

    /**
     * Returns table name mapped in the model.
     *
     * @return string
     */
    public function getSource()
    {
        return 'poblaciones';
    }

    /**
     * Allows to query a set of records that match the specified conditions
     *
     * @param mixed $parameters
     * @return Poblaciones[]
     */
    public static function find($parameters = null)
    {
        return parent::find($parameters);
    }

    /**
     * Allows to query the first record that match the specified conditions
     *
     * @param mixed $parameters
     * @return Poblaciones
     */
    public static function findFirst($parameters = null)
    {
        return parent::findFirst($parameters);
    }

}
