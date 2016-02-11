<?php
namespace Curriculum;

class Tipodocumento extends \Phalcon\Mvc\Model
{

    /**
     *
     * @var integer
     */
    public $tipodocumento_id;

    /**
     *
     * @var string
     */
    public $tipodocumento_descripcion;

    /**
     * Initialize method for model.
     */
    public function initialize()
    {
        $this->hasMany('tipodocumento_id', 'Persona', 'persona_tipoDocumentoId', array('alias' => 'Persona'));
    }

    /**
     * Returns table name mapped in the model.
     *
     * @return string
     */
    public function getSource()
    {
        return 'tipodocumento';
    }

    /**
     * Allows to query a set of records that match the specified conditions
     *
     * @param mixed $parameters
     * @return Tipodocumento[]
     */
    public static function find($parameters = null)
    {
        return parent::find($parameters);
    }

    /**
     * Allows to query the first record that match the specified conditions
     *
     * @param mixed $parameters
     * @return Tipodocumento
     */
    public static function findFirst($parameters = null)
    {
        return parent::findFirst($parameters);
    }

}
