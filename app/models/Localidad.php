<?php

class Localidad extends \Phalcon\Mvc\Model
{

    /**
     *
     * @var integer
     */
    public $localidad_id;

    /**
     *
     * @var integer
     */
    public $localidad_codigoPostal;

    /**
     *
     * @var string
     */
    public $localidad_domicilio;

    /**
     *
     * @var integer
     */
    public $localidad_ciudadId;

    /**
     * Initialize method for model.
     */
    public function initialize()
    {
        $this->hasMany('localidad_id', 'Persona', 'persona_localidadId', array('alias' => 'Persona'));
        $this->belongsTo('localidad_ciudadId', 'Ciudad', 'ciudad_id', array('alias' => 'Ciudad'));
    }

    /**
     * Returns table name mapped in the model.
     *
     * @return string
     */
    public function getSource()
    {
        return 'localidad';
    }

    /**
     * Allows to query a set of records that match the specified conditions
     *
     * @param mixed $parameters
     * @return Localidad[]
     */
    public static function find($parameters = null)
    {
        return parent::find($parameters);
    }

    /**
     * Allows to query the first record that match the specified conditions
     *
     * @param mixed $parameters
     * @return Localidad
     */
    public static function findFirst($parameters = null)
    {
        return parent::findFirst($parameters);
    }

}
