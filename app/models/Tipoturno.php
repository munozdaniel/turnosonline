<?php

class Tipoturno extends \Phalcon\Mvc\Model
{

    /**
     *
     * @var integer
     */
    protected $tipoTurno_id;

    /**
     *
     * @var string
     */
    protected $tipoTurno_nombre;

    /**
     * Method to set the value of field tipoTurno_id
     *
     * @param integer $tipoTurno_id
     * @return $this
     */
    public function setTipoturnoId($tipoTurno_id)
    {
        $this->tipoTurno_id = $tipoTurno_id;

        return $this;
    }

    /**
     * Method to set the value of field tipoTurno_nombre
     *
     * @param string $tipoTurno_nombre
     * @return $this
     */
    public function setTipoturnoNombre($tipoTurno_nombre)
    {
        $this->tipoTurno_nombre = $tipoTurno_nombre;

        return $this;
    }

    /**
     * Returns the value of field tipoTurno_id
     *
     * @return integer
     */
    public function getTipoturnoId()
    {
        return $this->tipoTurno_id;
    }

    /**
     * Returns the value of field tipoTurno_nombre
     *
     * @return string
     */
    public function getTipoturnoNombre()
    {
        return $this->tipoTurno_nombre;
    }

    /**
     * Initialize method for model.
     */
    public function initialize()
    {
        $this->hasMany('tipoTurno_id', 'Solicitudturno', 'solicitudTurno_tipoTurnoId', array('alias' => 'Solicitudturno'));
    }

    /**
     * Returns table name mapped in the model.
     *
     * @return string
     */
    public function getSource()
    {
        return 'tipoturno';
    }

    /**
     * Allows to query a set of records that match the specified conditions
     *
     * @param mixed $parameters
     * @return Tipoturno[]
     */
    public static function find($parameters = null)
    {
        return parent::find($parameters);
    }

    /**
     * Allows to query the first record that match the specified conditions
     *
     * @param mixed $parameters
     * @return Tipoturno
     */
    public static function findFirst($parameters = null)
    {
        return parent::findFirst($parameters);
    }


    public static function buscarTipoPorId($tipoTurno_id){
        $tipoTurno = Tipoturno::findFirst(array('tipoTurno_id=:tipoTurno_id:',
            'bind'=>array('tipoTurno_id'=>$tipoTurno_id)));
        if(!$tipoTurno)
            return "DESCONOCIDO";
        else
            return $tipoTurno->getTipoturnoNombre();

    }
}
