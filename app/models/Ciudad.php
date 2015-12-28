<?php

class Ciudad extends \Phalcon\Mvc\Model
{

    /**
     *
     * @var integer
     */
    public $ciudad_id;

    /**
     *
     * @var string
     */
    public $ciudad_nombre;

    /**
     *
     * @var integer
     */
    public $ciudad_provinciaId;

    /**
     * Initialize method for model.
     */
    public function initialize()
    {
        $this->hasMany('ciudad_id', 'Localidad', 'localidad_ciudadId', array('alias' => 'Localidad'));
        $this->belongsTo('ciudad_provinciaId', 'Provincia', 'provincia_id', array('alias' => 'Provincia'));
    }

    /**
     * Returns table name mapped in the model.
     *
     * @return string
     */
    public function getSource()
    {
        return 'ciudad';
    }

    /**
     * Allows to query a set of records that match the specified conditions
     *
     * @param mixed $parameters
     * @return Ciudad[]
     */
    public static function find($parameters = null)
    {
        return parent::find($parameters);
    }

    /**
     * Allows to query the first record that match the specified conditions
     *
     * @param mixed $parameters
     * @return Ciudad
     */
    public static function findFirst($parameters = null)
    {
        return parent::findFirst($parameters);
    }

}
