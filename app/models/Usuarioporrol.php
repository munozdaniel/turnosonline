<?php

class Usuarioporrol extends \Phalcon\Mvc\Model
{

    /**
     *
     * @var integer
     */
    public $usuario_id;

    /**
     *
     * @var integer
     */
    public $rol_id;

    /**
     * Initialize method for model.
     */
    public function initialize()
    {
        $this->belongsTo('rol_id', 'Rol', 'rol_id', array('alias' => 'Rol'));
    }

    /**
     * Returns table name mapped in the model.
     *
     * @return string
     */
    public function getSource()
    {
        return 'usuarioporrol';
    }

    /**
     * Allows to query a set of records that match the specified conditions
     *
     * @param mixed $parameters
     * @return Usuarioporrol[]
     */
    public static function find($parameters = null)
    {
        return parent::find($parameters);
    }

    /**
     * Allows to query the first record that match the specified conditions
     *
     * @param mixed $parameters
     * @return Usuarioporrol
     */
    public static function findFirst($parameters = null)
    {
        return parent::findFirst($parameters);
    }

}
