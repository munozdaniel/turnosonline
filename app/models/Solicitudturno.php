<?php

class Solicitudturno extends \Phalcon\Mvc\Model
{

    /**
     *
     * @var integer
     */
    protected $solicitudTurno_id;

    /**
     *
     * @var integer
     */
    protected $solicitudTurno_legajo;

    /**
     *
     * @var string
     */
    protected $solicitudTurno_nomApe;

    /**
     *
     * @var integer
     */
    protected $solicitudTurno_documento;

    /**
     *
     * @var string
     */
    protected $solicitudTurno_email;

    /**
     *
     * @var string
     */
    protected $solicitudTurno_numTelefono;

    /**
     *
     * @var string
     */
    protected $solicitudTurno_fechaPedido;

    /**
     *
     * @var string
     */
    protected $solicitudTurno_estado;

    /**
     *
     * @var string
     */
    protected $solicitudTurno_nickUsuario;

    /**
     *
     * @var integer
     */
    protected $solicitudTurno_numero;

    /**
     *
     * @var string
     */
    protected $solicitudTurno_codigo;

    /**
     *
     * @var string
     */
    protected $solicitudTurno_fechaProcesamiento;

    /**
     *
     * @var string
     */
    protected $solicitudTurno_respuestaEnviada;

    /**
     *
     * @var integer
     */
    protected $solicitudTurno_respuestaChequeada;

    /**
     *
     * @var string
     */
    protected $solicitudTurno_fechaRespuestaEnviada;

    /**
     *
     * @var integer
     */
    protected $solicitudTurno_montoMax;

    /**
     *
     * @var integer
     */
    protected $solicitudTurno_montoPosible;

    /**
     *
     * @var integer
     */
    protected $solicitudTurno_cantCuotas;

    /**
     *
     * @var integer
     */
    protected $solicitudTurno_valorCuota;

    /**
     *
     * @var string
     */
    protected $solicitudTurno_observaciones;

    /**
     *
     * @var string
     */
    protected $solicitudTurno_fechaConfirmacion;

    /**
     *
     * @var integer
     */
    protected $solicitudTurnos_fechasTurnos;

    /**
     *
     * @var integer
     */
    protected $solicitudTurno_tipo;

    /**
     *
     * @var integer
     */
    protected $solicitudTurno_habilitado;

    /**
     * Method to set the value of field solicitudTurno_id
     *
     * @param integer $solicitudTurno_id
     * @return $this
     */
    public function setSolicitudturnoId($solicitudTurno_id)
    {
        $this->solicitudTurno_id = $solicitudTurno_id;

        return $this;
    }

    /**
     * Method to set the value of field solicitudTurno_legajo
     *
     * @param integer $solicitudTurno_legajo
     * @return $this
     */
    public function setSolicitudturnoLegajo($solicitudTurno_legajo)
    {
        $this->solicitudTurno_legajo = $solicitudTurno_legajo;

        return $this;
    }

    /**
     * Method to set the value of field solicitudTurno_nomApe
     *
     * @param string $solicitudTurno_nomApe
     * @return $this
     */
    public function setSolicitudturnoNomape($solicitudTurno_nomApe)
    {
        $this->solicitudTurno_nomApe = $solicitudTurno_nomApe;

        return $this;
    }

    /**
     * Method to set the value of field solicitudTurno_documento
     *
     * @param integer $solicitudTurno_documento
     * @return $this
     */
    public function setSolicitudturnoDocumento($solicitudTurno_documento)
    {
        $this->solicitudTurno_documento = $solicitudTurno_documento;

        return $this;
    }

    /**
     * Method to set the value of field solicitudTurno_email
     *
     * @param string $solicitudTurno_email
     * @return $this
     */
    public function setSolicitudturnoEmail($solicitudTurno_email)
    {
        $this->solicitudTurno_email = $solicitudTurno_email;

        return $this;
    }

    /**
     * Method to set the value of field solicitudTurno_numTelefono
     *
     * @param string $solicitudTurno_numTelefono
     * @return $this
     */
    public function setSolicitudturnoNumtelefono($solicitudTurno_numTelefono)
    {
        $this->solicitudTurno_numTelefono = $solicitudTurno_numTelefono;

        return $this;
    }

    /**
     * Method to set the value of field solicitudTurno_fechaPedido
     *
     * @param string $solicitudTurno_fechaPedido
     * @return $this
     */
    public function setSolicitudturnoFechapedido($solicitudTurno_fechaPedido)
    {
        $this->solicitudTurno_fechaPedido = $solicitudTurno_fechaPedido;

        return $this;
    }

    /**
     * Method to set the value of field solicitudTurno_estado
     *
     * @param string $solicitudTurno_estado
     * @return $this
     */
    public function setSolicitudturnoEstado($solicitudTurno_estado)
    {
        $this->solicitudTurno_estado = $solicitudTurno_estado;

        return $this;
    }

    /**
     * Method to set the value of field solicitudTurno_nickUsuario
     *
     * @param string $solicitudTurno_nickUsuario
     * @return $this
     */
    public function setSolicitudturnoNickusuario($solicitudTurno_nickUsuario)
    {
        $this->solicitudTurno_nickUsuario = $solicitudTurno_nickUsuario;

        return $this;
    }

    /**
     * Method to set the value of field solicitudTurno_numero
     *
     * @param integer $solicitudTurno_numero
     * @return $this
     */
    public function setSolicitudturnoNumero($solicitudTurno_numero)
    {
        $this->solicitudTurno_numero = $solicitudTurno_numero;

        return $this;
    }

    /**
     * Method to set the value of field solicitudTurno_codigo
     *
     * @param string $solicitudTurno_codigo
     * @return $this
     */
    public function setSolicitudturnoCodigo($solicitudTurno_codigo)
    {
        $this->solicitudTurno_codigo = $solicitudTurno_codigo;

        return $this;
    }

    /**
     * Method to set the value of field solicitudTurno_fechaProcesamiento
     *
     * @param string $solicitudTurno_fechaProcesamiento
     * @return $this
     */
    public function setSolicitudturnoFechaprocesamiento($solicitudTurno_fechaProcesamiento)
    {
        $this->solicitudTurno_fechaProcesamiento = $solicitudTurno_fechaProcesamiento;

        return $this;
    }

    /**
     * Method to set the value of field solicitudTurno_respuestaEnviada
     *
     * @param string $solicitudTurno_respuestaEnviada
     * @return $this
     */
    public function setSolicitudturnoRespuestaenviada($solicitudTurno_respuestaEnviada)
    {
        $this->solicitudTurno_respuestaEnviada = $solicitudTurno_respuestaEnviada;

        return $this;
    }

    /**
     * Method to set the value of field solicitudTurno_respuestaChequeada
     *
     * @param integer $solicitudTurno_respuestaChequeada
     * @return $this
     */
    public function setSolicitudturnoRespuestachequeada($solicitudTurno_respuestaChequeada)
    {
        $this->solicitudTurno_respuestaChequeada = $solicitudTurno_respuestaChequeada;

        return $this;
    }

    /**
     * Method to set the value of field solicitudTurno_fechaRespuestaEnviada
     *
     * @param string $solicitudTurno_fechaRespuestaEnviada
     * @return $this
     */
    public function setSolicitudturnoFecharespuestaenviada($solicitudTurno_fechaRespuestaEnviada)
    {
        $this->solicitudTurno_fechaRespuestaEnviada = $solicitudTurno_fechaRespuestaEnviada;

        return $this;
    }

    /**
     * Method to set the value of field solicitudTurno_montoMax
     *
     * @param integer $solicitudTurno_montoMax
     * @return $this
     */
    public function setSolicitudturnoMontomax($solicitudTurno_montoMax)
    {
        $this->solicitudTurno_montoMax = $solicitudTurno_montoMax;

        return $this;
    }

    /**
     * Method to set the value of field solicitudTurno_montoPosible
     *
     * @param integer $solicitudTurno_montoPosible
     * @return $this
     */
    public function setSolicitudturnoMontoposible($solicitudTurno_montoPosible)
    {
        $this->solicitudTurno_montoPosible = $solicitudTurno_montoPosible;

        return $this;
    }

    /**
     * Method to set the value of field solicitudTurno_cantCuotas
     *
     * @param integer $solicitudTurno_cantCuotas
     * @return $this
     */
    public function setSolicitudturnoCantcuotas($solicitudTurno_cantCuotas)
    {
        $this->solicitudTurno_cantCuotas = $solicitudTurno_cantCuotas;

        return $this;
    }

    /**
     * Method to set the value of field solicitudTurno_valorCuota
     *
     * @param integer $solicitudTurno_valorCuota
     * @return $this
     */
    public function setSolicitudturnoValorcuota($solicitudTurno_valorCuota)
    {
        $this->solicitudTurno_valorCuota = $solicitudTurno_valorCuota;

        return $this;
    }

    /**
     * Method to set the value of field solicitudTurno_observaciones
     *
     * @param string $solicitudTurno_observaciones
     * @return $this
     */
    public function setSolicitudturnoObservaciones($solicitudTurno_observaciones)
    {
        $this->solicitudTurno_observaciones = $solicitudTurno_observaciones;

        return $this;
    }

    /**
     * Method to set the value of field solicitudTurno_fechaConfirmacion
     *
     * @param string $solicitudTurno_fechaConfirmacion
     * @return $this
     */
    public function setSolicitudturnoFechaconfirmacion($solicitudTurno_fechaConfirmacion)
    {
        $this->solicitudTurno_fechaConfirmacion = $solicitudTurno_fechaConfirmacion;

        return $this;
    }

    /**
     * Method to set the value of field solicitudTurnos_fechasTurnos
     *
     * @param integer $solicitudTurnos_fechasTurnos
     * @return $this
     */
    public function setSolicitudturnosFechasturnos($solicitudTurnos_fechasTurnos)
    {
        $this->solicitudTurnos_fechasTurnos = $solicitudTurnos_fechasTurnos;

        return $this;
    }

    /**
     * Method to set the value of field solicitudTurno_tipo
     *
     * @param integer $solicitudTurno_tipo
     * @return $this
     */
    public function setSolicitudturnoTipo($solicitudTurno_tipo)
    {
        $this->solicitudTurno_tipo = $solicitudTurno_tipo;

        return $this;
    }

    /**
     * Method to set the value of field solicitudTurno_habilitado
     *
     * @param integer $solicitudTurno_habilitado
     * @return $this
     */
    public function setSolicitudturnoHabilitado($solicitudTurno_habilitado)
    {
        $this->solicitudTurno_habilitado = $solicitudTurno_habilitado;

        return $this;
    }

    /**
     * Returns the value of field solicitudTurno_id
     *
     * @return integer
     */
    public function getSolicitudturnoId()
    {
        return $this->solicitudTurno_id;
    }

    /**
     * Returns the value of field solicitudTurno_legajo
     *
     * @return integer
     */
    public function getSolicitudturnoLegajo()
    {
        return $this->solicitudTurno_legajo;
    }

    /**
     * Returns the value of field solicitudTurno_nomApe
     *
     * @return string
     */
    public function getSolicitudturnoNomape()
    {
        return $this->solicitudTurno_nomApe;
    }

    /**
     * Returns the value of field solicitudTurno_documento
     *
     * @return integer
     */
    public function getSolicitudturnoDocumento()
    {
        return $this->solicitudTurno_documento;
    }

    /**
     * Returns the value of field solicitudTurno_email
     *
     * @return string
     */
    public function getSolicitudturnoEmail()
    {
        return $this->solicitudTurno_email;
    }

    /**
     * Returns the value of field solicitudTurno_numTelefono
     *
     * @return string
     */
    public function getSolicitudturnoNumtelefono()
    {
        return $this->solicitudTurno_numTelefono;
    }

    /**
     * Returns the value of field solicitudTurno_fechaPedido
     *
     * @return string
     */
    public function getSolicitudturnoFechapedido()
    {
        return $this->solicitudTurno_fechaPedido;
    }

    /**
     * Returns the value of field solicitudTurno_estado
     *
     * @return string
     */
    public function getSolicitudturnoEstado()
    {
        return $this->solicitudTurno_estado;
    }

    /**
     * Returns the value of field solicitudTurno_nickUsuario
     *
     * @return string
     */
    public function getSolicitudturnoNickusuario()
    {
        return $this->solicitudTurno_nickUsuario;
    }

    /**
     * Returns the value of field solicitudTurno_numero
     *
     * @return integer
     */
    public function getSolicitudturnoNumero()
    {
        return $this->solicitudTurno_numero;
    }

    /**
     * Returns the value of field solicitudTurno_codigo
     *
     * @return string
     */
    public function getSolicitudturnoCodigo()
    {
        return $this->solicitudTurno_codigo;
    }

    /**
     * Returns the value of field solicitudTurno_fechaProcesamiento
     *
     * @return string
     */
    public function getSolicitudturnoFechaprocesamiento()
    {
        return $this->solicitudTurno_fechaProcesamiento;
    }

    /**
     * Returns the value of field solicitudTurno_respuestaEnviada
     *
     * @return string
     */
    public function getSolicitudturnoRespuestaenviada()
    {
        return $this->solicitudTurno_respuestaEnviada;
    }

    /**
     * Returns the value of field solicitudTurno_respuestaChequeada
     *
     * @return integer
     */
    public function getSolicitudturnoRespuestachequeada()
    {
        return $this->solicitudTurno_respuestaChequeada;
    }

    /**
     * Returns the value of field solicitudTurno_fechaRespuestaEnviada
     *
     * @return string
     */
    public function getSolicitudturnoFecharespuestaenviada()
    {
        return $this->solicitudTurno_fechaRespuestaEnviada;
    }

    /**
     * Returns the value of field solicitudTurno_montoMax
     *
     * @return integer
     */
    public function getSolicitudturnoMontomax()
    {
        return $this->solicitudTurno_montoMax;
    }

    /**
     * Returns the value of field solicitudTurno_montoPosible
     *
     * @return integer
     */
    public function getSolicitudturnoMontoposible()
    {
        return $this->solicitudTurno_montoPosible;
    }

    /**
     * Returns the value of field solicitudTurno_cantCuotas
     *
     * @return integer
     */
    public function getSolicitudturnoCantcuotas()
    {
        return $this->solicitudTurno_cantCuotas;
    }

    /**
     * Returns the value of field solicitudTurno_valorCuota
     *
     * @return integer
     */
    public function getSolicitudturnoValorcuota()
    {
        return $this->solicitudTurno_valorCuota;
    }

    /**
     * Returns the value of field solicitudTurno_observaciones
     *
     * @return string
     */
    public function getSolicitudturnoObservaciones()
    {
        return $this->solicitudTurno_observaciones;
    }

    /**
     * Returns the value of field solicitudTurno_fechaConfirmacion
     *
     * @return string
     */
    public function getSolicitudturnoFechaconfirmacion()
    {
        return $this->solicitudTurno_fechaConfirmacion;
    }

    /**
     * Returns the value of field solicitudTurnos_fechasTurnos
     *
     * @return integer
     */
    public function getSolicitudturnosFechasturnos()
    {
        return $this->solicitudTurnos_fechasTurnos;
    }

    /**
     * Returns the value of field solicitudTurno_tipo
     *
     * @return integer
     */
    public function getSolicitudturnoTipo()
    {
        return $this->solicitudTurno_tipo;
    }

    /**
     * Returns the value of field solicitudTurno_habilitado
     *
     * @return integer
     */
    public function getSolicitudturnoHabilitado()
    {
        return $this->solicitudTurno_habilitado;
    }

    /**
     * Initialize method for model.
     */
    public function initialize()
    {
        $this->belongsTo('solicitudTurnos_fechasTurnos', 'Fechasturnos', 'fechasTurnos_id', array('alias' => 'Fechasturnos'));
    }

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
