<?php

class Provincias extends \Phalcon\Mvc\Model
{

    /**
     *
     * @var integer
     */
    public $idprovincia;

    /**
     *
     * @var string
     */
    public $provincia;

    /**
     *
     * @var string
     */
    public $provinciaseo;

    /**
     *
     * @var string
     */
    public $provincia3;

    /**
     * Returns table name mapped in the model.
     *
     * @return string
     */
    public function getSource()
    {
        return 'provincias';
    }

    /**
     * Allows to query a set of records that match the specified conditions
     *
     * @param mixed $parameters
     * @return Provincias[]
     */
    public static function find($parameters = null)
    {
        return parent::find($parameters);
    }

    /**
     * Allows to query the first record that match the specified conditions
     *
     * @param mixed $parameters
     * @return Provincias
     */
    public static function findFirst($parameters = null)
    {
        return parent::findFirst($parameters);
    }

}
