<?php

class Acceso extends \Phalcon\Mvc\Model
{

    /**
     *
     * @var integer
     */
    public $acceso_id;

    /**
     *
     * @var integer
     */
    public $rol_id;

    /**
     *
     * @var integer
     */
    public $pagina_id;

    /**
     * Initialize method for model.
     */
    public function initialize()
    {
        $this->belongsTo('rol_id', 'Rol', 'rol_id', array('alias' => 'Rol'));
        $this->belongsTo('pagina_id', 'Pagina', 'pagina_id', array('alias' => 'Pagina'));
    }

    /**
     * Returns table name mapped in the model.
     *
     * @return string
     */
    public function getSource()
    {
        return 'acceso';
    }

    /**
     * Allows to query a set of records that match the specified conditions
     *
     * @param mixed $parameters
     * @return Acceso[]
     */
    public static function find($parameters = null)
    {
        return parent::find($parameters);
    }

    /**
     * Allows to query the first record that match the specified conditions
     *
     * @param mixed $parameters
     * @return Acceso
     */
    public static function findFirst($parameters = null)
    {
        return parent::findFirst($parameters);
    }

}
