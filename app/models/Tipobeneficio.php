<?php

class Tipobeneficio extends \Phalcon\Mvc\Model
{

    /**
     *
     * @var integer
     */
    public $tipobeneficio_id;

    /**
     *
     * @var string
     */
    public $tipobeneficio_grupo;

    /**
     *
     * @var string
     */
    public $tipobeneficio_nombre;

    /**
     *
     * @var integer
     */
    public $tipobeneficio_validez;

    /**
     * Initialize method for model.
     */
    public function initialize()
    {
        $this->setConnectionService('dbSujypweb');
        //Deberia ser de solo lectura
        $this->setReadConnectionService('dbSujypweb');
        $this->hasMany('tipobeneficio_id', 'Datosbeneficio', 'datosbeneficio_tipoBeneficio', array('alias' => 'Datosbeneficio'));
    }

    /**
     * Returns table name mapped in the model.
     *
     * @return string
     */
    public function getSource()
    {
        return 'tipobeneficio';
    }

    /**
     * Allows to query a set of records that match the specified conditions
     *
     * @param mixed $parameters
     * @return Tipobeneficio[]
     */
    public static function find($parameters = null)
    {
        return parent::find($parameters);
    }

    /**
     * Allows to query the first record that match the specified conditions
     *
     * @param mixed $parameters
     * @return Tipobeneficio
     */
    public static function findFirst($parameters = null)
    {
        return parent::findFirst($parameters);
    }

}
