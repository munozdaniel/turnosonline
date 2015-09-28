<?php

class Rol extends \Phalcon\Mvc\Model
{

    /**
     *
     * @var integer
     */
    public $rol_id;

    /**
     *
     * @var string
     */
    public $rol_nombre;

    /**
     *
     * @var string
     */
    public $rol_descripcion;

    /**
     * Initialize method for model.
     */
    public function initialize()
    {
        $this->hasMany('rol_id', 'Acceso', 'rol_id', array('alias' => 'Acceso'));
        $this->hasMany('rol_id', 'Usuarioporrol', 'rol_id', array('alias' => 'Usuarioporrol'));
    }

    /**
     * Returns table name mapped in the model.
     *
     * @return string
     */
    public function getSource()
    {
        return 'rol';
    }

    /**
     * Allows to query a set of records that match the specified conditions
     *
     * @param mixed $parameters
     * @return Rol[]
     */
    public static function find($parameters = null)
    {
        return parent::find($parameters);
    }

    /**
     * Allows to query the first record that match the specified conditions
     *
     * @param mixed $parameters
     * @return Rol
     */
    public static function findFirst($parameters = null)
    {
        return parent::findFirst($parameters);
    }

}
