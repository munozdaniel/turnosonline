<?php

class Pagina extends \Phalcon\Mvc\Model
{

    /**
     *
     * @var integer
     */
    public $pagina_id;

    /**
     *
     * @var string
     */
    public $pagina_nombreControlador;

    /**
     *
     * @var string
     */
    public $pagina_nombreAccion;

    /**
     * Initialize method for model.
     */
    public function initialize()
    {
        $this->hasMany('pagina_id', 'Acceso', 'pagina_id', array('alias' => 'Acceso'));
    }

    /**
     * Returns table name mapped in the model.
     *
     * @return string
     */
    public function getSource()
    {
        return 'pagina';
    }

    /**
     * Allows to query a set of records that match the specified conditions
     *
     * @param mixed $parameters
     * @return Pagina[]
     */
    public static function find($parameters = null)
    {
        return parent::find($parameters);
    }

    /**
     * Allows to query the first record that match the specified conditions
     *
     * @param mixed $parameters
     * @return Pagina
     */
    public static function findFirst($parameters = null)
    {
        return parent::findFirst($parameters);
    }

}
