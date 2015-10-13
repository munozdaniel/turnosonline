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
     * @var integer
     */
    public $solicitudTurno_documento;

    /**
     *
     * @var string
     */
    public $solicitudTurno_email;

    /**
     *
     * @var string
     */
    public $solicitudTurno_numTelefono;

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
    public $solicitudTurno_nickUsuario;

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
     *
     * @var integer
     */
    public $solicitudTurno_montoMax;

    /**
     *
     * @var integer
     */
    public $solicitudTurno_montoPosible;

    /**
     *
     * @var integer
     */
    public $solicitudTurno_cantCuotas;

    /**
     *
     * @var integer
     */
    public $solicitudTurno_valorCuota;

    /**
     *
     * @var string
     */
    public $solicitudTurno_observaciones;

    /**
     *
     * @var integer
     */
    public $solicitudTurno_manual;

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
