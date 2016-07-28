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
     * @var string
     */
    protected $solicitudTurno_fechaRespuestaEnviada;

    /**
     *
     * @var string
     */
    protected $solicitudTurno_causa;
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
    protected $solicitudTurno_tipoTurnoId;

    /**
     *
     * @var integer
     */
    protected $solicitudTurno_estadoAsistenciaId;

    /**
     *
     * @var integer
     */
    protected $solicitudTurno_sanciones;


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
     * Method to set the value of field solicitudTurno_causa
     *
     * @param string $solicitudTurno_causa
     * @return $this
     */
    public function setSolicitudturnoCausa($solicitudTurno_causa)
    {
        $this->solicitudTurno_causa = $solicitudTurno_causa;

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
     * Method to set the value of field solicitudTurno_tipoTurnoId
     *
     * @param integer $solicitudTurno_tipoTurnoId
     * @return $this
     */
    public function setSolicitudturnoTipoturnoid($solicitudTurno_tipoTurnoId)
    {
        $this->solicitudTurno_tipoTurnoId = $solicitudTurno_tipoTurnoId;

        return $this;
    }
    /**
     * Method to set the value of field solicitudTurno_estadoAsistenciaId
     *
     * @param integer $solicitudTurno_estadoAsistenciaId
     * @return $this
     */
    public function setSolicitudturnoEstadoasistenciaid($solicitudTurno_estadoAsistenciaId)
    {
        $this->solicitudTurno_estadoAsistenciaId = $solicitudTurno_estadoAsistenciaId;

        return $this;
    }

    /**
     * Method to set the value of field solicitudTurno_sanciones
     *
     * @param integer $solicitudTurno_sanciones
     * @return $this
     */
    public function setSolicitudturnoSanciones($solicitudTurno_sanciones)
    {
        $this->solicitudTurno_sanciones = $solicitudTurno_sanciones;

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
     * Returns the value of field solicitudTurno_fechaRespuestaEnviada
     *
     * @return string
     */
    public function getSolicitudturnoFecharespuestaenviada()
    {
        return $this->solicitudTurno_fechaRespuestaEnviada;
    }

    /**
     * Returns the value of field solicitudTurno_causa
     *
     * @return string
     */
    public function getSolicitudturnoCausa()
    {
        return $this->solicitudTurno_causa;
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
     * Returns the value of field solicitudTurno_tipoTurnoId
     *
     * @return integer
     */
    public function getSolicitudturnoTipoturnoid()
    {
        return $this->solicitudTurno_tipoTurnoId;
    }
    /**
     * Returns the value of field solicitudTurno_estadoAsistenciaId
     *
     * @return integer
     */
    public function getSolicitudturnoEstadoasistenciaid()
    {
        return $this->solicitudTurno_estadoAsistenciaId;
    }

    /**
     * Returns the value of field solicitudTurno_sanciones
     *
     * @return integer
     */
    public function getSolicitudturnoSanciones()
    {
        return $this->solicitudTurno_sanciones;
    }

    /**
     * Initialize method for model.
     */
    public function initialize()
    {
        $this->belongsTo('solicitudTurno_tipoTurnoId', 'Tipoturno', 'tipoTurno_id', array('alias' => 'Tipoturno'));
        $this->belongsTo('solicitudTurno_estadoAsistenciaId', 'Estadoasistencia', 'estadoAsistencia_id', array('alias' => 'Estadoasistencia'));
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


    public static function accionVerSolicitudesOnline()
    {
        $fechaTurnos = Fechasturnos::findFirstByFechasTurnos_activo(1);//Obtengo el periodo activo.
        $solicitudesOnline = array();
        if (!empty($fechaTurnos)) {
            $ffI = $fechaTurnos->fechasTurnos_inicioSolicitud;
            $ffF = $fechaTurnos->fechasTurnos_finSolicitud;

            $solicitudes = Solicitudturno::find();

            foreach ($solicitudes as $unaSolicitud) {
                $ffPedido = date('Y-m-d', strtotime($unaSolicitud->solicitudTurno_fechaPedido));
                if ($unaSolicitud->solicitudTurno_manual == 0 and $unaSolicitud->solicitudTurno_respuestaEnviada == 'NO'
                    and $ffPedido <= $ffF and $ffPedido >= $ffI
                )
                    $solicitudesOnline[] = (array)$unaSolicitud;
            }
        }
        return $solicitudesOnline;
    }

    /**
     * Busca todas las solicitudes que fueron enviadas.
     * @return array
     */
    public static function accionVerSolicitudesConRespuestaEnviada($tipoTurno = null)
    {
        $fechaTurnos = Fechasturnos::findFirst(array('fechasTurnos_activo=1'));//Obtengo el periodo activo.
        $solicitudesOnline = array();

        if ($fechaTurnos) {
            $fechaSolicitudInicial = $fechaTurnos->getFechasturnosIniciosolicitud();
            $fechaSolicitudFinal = $fechaTurnos->getFechasturnosFinsolicitud();
            if ($tipoTurno != null) {
                $solicitudes = Solicitudturno::find(array('solicitudTurnos_fechasTurnos = :fechasTurnos_id:
                     AND solicitudTurno_tipoTurnoId=:tipoTurno:',
                    'bind' => array('fechasTurnos_id' => $fechaTurnos->getFechasturnosId(), 'tipoTurno' => $tipoTurno),
                    'order' => 'solicitudTurno_fechaProcesamiento DESC'));
            } else {
                $solicitudes = Solicitudturno::find(array('solicitudTurnos_fechasTurnos = :fechasTurnos_id:',
                    'bind' => array('fechasTurnos_id' => $fechaTurnos->getFechasturnosId()),
                    'order' => 'solicitudTurno_fechaProcesamiento DESC'));
            }
            foreach ($solicitudes as $unaSolicitud) {
                if ($unaSolicitud->getSolicitudturnoRespuestaenviada() == 'SI') {
                    $unaSolicitud->solicitudTurno_idCodificado = base64_encode($unaSolicitud->solicitudTurno_id); //24/02
                    $solicitudesOnline[] = $unaSolicitud->toArray();
                }
            }
        }
        return $solicitudesOnline;
    }


    /**
     *
     * @param $legajo
     * @param $nombreCompleto
     * @param $documento
     * @param $email
     * @param $numTelefono
     * @param $fechasTurnos_id
     * @param int $tipo Si no ingresa nada se considera que es un turno online
     * @return bool
     */
    public static function accionAgregarUnaSolicitudOnline($legajo, $nombreCompleto, $documento, $email, $numTelefono, $fechasTurnos_id, $tipo = 1)
    {
        $unaSolicitud = new Solicitudturno();

        $unaSolicitud->assign(array(
            'solicitudTurno_legajo' => $legajo,
            'solicitudTurno_nomApe' => $nombreCompleto,
            'solicitudTurno_documento' => $documento,
            'solicitudTurno_email' => $email,
            'solicitudTurno_numTelefono' => $numTelefono,
            'solicitudTurno_fechaPedido' => date('Y-m-d'),
            'solicitudTurno_estado' => 'PENDIENTE',
            'solicitudTurno_nickUsuario' => '-',
            'solicitudTurno_respuestaEnviada' => 'NO',
            'solicitudTurno_fechaComprobacion' => NULL,
            'solicitudTurno_observaciones' => '-',
            'solicitudTurno_tipoTurnoId' => $tipo,
            'solicitudTurnos_fechasTurnos' => $fechasTurnos_id
        ));

        if ($unaSolicitud->save())
            return true;
        else {
            foreach ($unaSolicitud->getMessages() as $message) {
                echo $message, "<br>";
            }
            return false;
        }
    }

    /**
     * Dada una solicitud se actualizan los datos en el modelo.
     * @param $solicitud
     * @return bool|Solicitudturno
     */
    public static function actualizarCodigoSolicitud($solicitud)
    {
        $solicitud = Solicitudturno::findFirst(array('solicitudTurno_id=solicitudTurno_id',
            'bind' => array('solicitudTurno' => $solicitud['solicitudTurno_id'])));
        $solicitud->setSolicitudturnoCodigo($solicitud['solicitudTurno_codigo']);
        if (!$solicitud->update())
            return false;
        return $solicitud;
    }

    /**
     * Generar numero aleatorio.
     * @return string
     */
    private function getRandomCode()
    {
        $an = "0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ";
        $su = strlen($an) - 1;
        return substr($an, rand(0, $su), 1) .
        substr($an, rand(0, $su), 1) .
        substr($an, rand(0, $su), 1) .
        substr($an, rand(0, $su), 1) .
        substr($an, rand(0, $su), 1) .
        substr($an, rand(0, $su), 1) .
        substr($an, rand(0, $su), 1);
    }

}
