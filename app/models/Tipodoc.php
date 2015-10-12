<?php

class Tipodoc extends \Phalcon\Mvc\Model
{

    /**
     *
     * @var integer
     */
    public $tipodoc_id;

    /**
     *
     * @var string
     */
    public $tipodoc_nombre;

    /**
     * Initialize method for model.
     */
    public function initialize()
    {
        $this->setConnectionService('dbSujypweb');
        //Deberia ser de solo lectura
        $this->setReadConnectionService('dbSujypweb');
        $this->hasMany('tipodoc_id', 'Datospersona', 'datospersona_tipoDoc', array('alias' => 'Datospersona'));
    }

    /**
     * Returns table name mapped in the model.
     *
     * @return string
     */
    public function getSource()
    {
        return 'tipodoc';
    }

    /**
     * Allows to query a set of records that match the specified conditions
     *
     * @param mixed $parameters
     * @return Tipodoc[]
     */
    public static function find($parameters = null)
    {
        return parent::find($parameters);
    }

    /**
     * Allows to query the first record that match the specified conditions
     *
     * @param mixed $parameters
     * @return Tipodoc
     */
    public static function findFirst($parameters = null)
    {
        return parent::findFirst($parameters);
    }

}
