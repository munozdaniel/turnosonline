<?php

class Solicitudturno extends \Phalcon\Mvc\Model
{

    /**
     *
     * @var integer
     */
    public $solicitudTurno_id;

    /**
     *
     * @var integer
     */
    public $solicitudTurno_legajo;

    /**
     *
     * @var string
     */
    public $solicitudTurno_nomApe;

    /**
     *
     * @var string
     */
    public $solicitudTurno_email;

    /**
     *
     * @var string
     */
    public $solicitudTurno_numCelular;

    /**
     *
     * @var string
     */
    public $solicitudTurno_fechaPedido;

    /**
     *
     * @var string
     */
    public $solicitudTurno_estado;

    /**
     *
     * @var string
     */
    public $solicitudTurno_fechaProcesamiento;

    /**
     *
     * @var string
     */
    public $solicitudTurno_respuestaEnviada;

    /**
     *
     * @var integer
     */
    public $solicitudTurno_respuestaChequeada;

    /**
     *
     * @var string
     */
    public $solicitudTurno_fechaRespuestaEnviada;

    /**
     * Returns table name mapped in the model.
     *
     * @return string
     */
    public function getSource()
    {
        return 'solicitudturno';
    }

    /**
     * Allows to query a set of records that match the specified conditions
     *
     * @param mixed $parameters
     * @return Solicitudturno[]
     */
    public static function find($parameters = null)
    {
        return parent::find($parameters);
    }

    /**
     * Allows to query the first record that match the specified conditions
     *
     * @param mixed $parameters
     * @return Solicitudturno
     */
    public static function findFirst($parameters = null)
    {
        return parent::findFirst($parameters);
    }

}
