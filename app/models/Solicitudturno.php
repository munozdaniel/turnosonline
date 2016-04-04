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

    /**
     * @param $id
     */
    private static function actualizarRespYFechaEnviada($id)
    {
        $laSolicitud = Solicitudturno::findFirstBySolicitudTurno_id($id);
        $laSolicitud->solicitudTurno_respuestaEnviada = 'SI';
        $laSolicitud->solicitudTurno_fechaRespuestaEnviada= date('Y-m-d');
        $laSolicitud->save();
    }

    public static function cambiarRespuesta($id)
    {
        $laSolicitud = Solicitudturno::findFirstBySolicitudTurno_id($id);
        $laSolicitud->solicitudTurno_respuestaChequeada=1;
        $laSolicitud->save();
    }
    public static function accionVerSolicitudesOnline()
    {
        $fechaTurnos = Fechasturnos::findFirstByFechasTurnos_activo(1);//Obtengo el periodo activo.
        $solicitudesOnline= array();
        if(!empty($fechaTurnos)){
            $ffI = $fechaTurnos->fechasTurnos_inicioSolicitud;
            $ffF =$fechaTurnos->fechasTurnos_finSolicitud;

            $solicitudes = Solicitudturno::find();

            foreach($solicitudes as $unaSolicitud)
            {
                $ffPedido = date('Y-m-d',strtotime($unaSolicitud->solicitudTurno_fechaPedido));
                if($unaSolicitud->solicitudTurno_manual == 0 and $unaSolicitud->solicitudTurno_respuestaEnviada=='NO'
                    and $ffPedido <= $ffF and $ffPedido >= $ffI)
                    $solicitudesOnline[]= (array)$unaSolicitud;
            }
        }
        return $solicitudesOnline;
    }

    public static function accionVerSolicitudesConRespuestaEnviada()
    {
        $fechaTurnos = Fechasturnos::findFirstByFechasTurnos_activo(1);//Obtengo el periodo activo.
        $solicitudesOnline= array();

        if(!empty($fechaTurnos))
        {
            $ffI = $fechaTurnos->fechasTurnos_inicioSolicitud;
            $ffF = $fechaTurnos->fechasTurnos_finSolicitud;

            $solicitudes = Solicitudturno::find(array(
                "solicitudTurnos_fechasTurnos = {$fechaTurnos->fechasTurnos_id}",
                "order" => "solicitudTurno_codigo DESC")); // 11/02/2016 M.

            //$solicitudes = Solicitudturno::findBySolicitudTurnos_fechasTurnos($fechaTurnos->fechasTurnos_id);

            foreach($solicitudes as $unaSolicitud)
            {

                $ffPedido = date('Y-m-d',strtotime($unaSolicitud->solicitudTurno_fechaPedido));

                if($unaSolicitud->solicitudTurno_respuestaEnviada=='SI' and $ffPedido <= $ffF and $ffPedido >= $ffI)
                {
                    $unaSolicitud->solicitudTurno_fechaRespuestaEnviadaDate = date('d/m/Y',strtotime($unaSolicitud->solicitudTurno_fechaRespuestaEnviada));

                    $resp = $unaSolicitud->solicitudTurno_respuestaChequeada;
                    if($unaSolicitud->solicitudTurno_tipo == 0)//Online
                    {

                        if($resp == 0)
                            $unaSolicitud->solicitudTurno_respChequedaTexto="NO";
                        else
                        {   if($resp==1)
                            $unaSolicitud->solicitudTurno_respChequedaTexto="SI";
                        else
                            if($resp==2)
                                $unaSolicitud->solicitudTurno_respChequedaTexto="SI (Turno Cancelado)";
                        }
                    }else{
                        if($unaSolicitud->solicitudTurno_tipo == 1)//Manual
                        {
                            $unaSolicitud->solicitudTurno_respChequedaTexto="SI (Solicitud Manual)";
                        }else{//Personal
                            $unaSolicitud->solicitudTurno_respChequedaTexto="SI (Solicitud Personal)";
                        }
                    }
                    /*if($resp == 1)
                    {
                        if($unaSolicitud->solicitudTurno_manual == 1)
                            $unaSolicitud->solicitudTurno_respChequedaTexto="SI (solicitud manual)";
                        else
                            $unaSolicitud->solicitudTurno_respChequedaTexto="SI";
                    }
                    else
                    {
                        if($resp == 0)
                            $unaSolicitud->solicitudTurno_respChequedaTexto="NO";
                        else //2 (esta opcion quedo pendiente, hasta que se controle que el email se confirma dentro de los dias dados.)M. 09/11/15
                            $unaSolicitud->solicitudTurno_respChequedaTexto="SI (turno cancelado)";
                    }
*/
                    $unaSolicitud->solicitudTurno_idCodificado= base64_encode($unaSolicitud->solicitudTurno_id); //24/02
                    $solicitudesOnline[]= (array)$unaSolicitud;
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
    public static function accionAgregarUnaSolicitudOnline($legajo,$nombreCompleto,$documento,$email,$numTelefono,$fechasTurnos_id,$tipo=0)
    {
        $unaSolicitud = new Solicitudturno();

        $unaSolicitud->assign(array(
            'solicitudTurno_legajo'=>$legajo,
            'solicitudTurno_nomApe'=>$nombreCompleto,
            'solicitudTurno_documento'=>$documento,
            'solicitudTurno_email' => $email,
            'solicitudTurno_numTelefono' =>$numTelefono,
            'solicitudTurno_fechaPedido'=>date('Y-m-d'),
            'solicitudTurno_estado'=>'PENDIENTE',
            'solicitudTurno_nickUsuario'=>'-',
            'solicitudTurno_respuestaEnviada'=>'NO',
            'solicitudTurno_respuestaChequeada'=>0,
            'solicitudTurno_montoMax'=>0,
            'solicitudTurno_montoPosible'=>0,
            'solicitudTurno_cantCuotas'=>0,
            'solicitudTurno_valorCuota'=>0,
            'solicitudTurno_fechaComprobacion'=>NULL,
            'solicitudTurno_observaciones'=>'-',
            'solicitudTurno_tipo'=>$tipo,
            'solicitudTurnos_fechasTurnos' => $fechasTurnos_id,
            'solicitudTurno_habilitado'=>1
        ));

        if($unaSolicitud->save())
            return true;
        else
        {
            foreach ($unaSolicitud->getMessages() as $message)
            {
                echo $message, "<br>";
            }
            return false;
        }
    }

    /**
     * @param $legajo
     * @param $nombreCompleto
     * @param $documento
     * @param $numTelefono
     * @param $estado
     * @param $nickActual
     * @param null $nroTurno
     * @param $fechasTurnos_id
     * @return null|Solicitudturno
     */
    public static function accionAgregarUnaSolicitudManual($legajo,$nombreCompleto,$documento,$numTelefono,
                                                           $estado,$nickActual,$fechasTurnos_id)
    {
        $unaSolicitudManual = new Solicitudturno();

        $unaSolicitudManual->assign(array(
            'solicitudTurno_legajo'=>$legajo,
            'solicitudTurno_nomApe'=>$nombreCompleto,
            'solicitudTurno_documento'=>$documento,
            'solicitudTurno_numTelefono' =>$numTelefono,
            'solicitudTurno_estado'=>$estado,
            'solicitudTurno_nickUsuario'=>$nickActual,
            'solicitudTurno_montoMax'=>0,
            'solicitudTurno_montoPosible'=>0,
            'solicitudTurno_cantCuotas'=>0,
            'solicitudTurno_valorCuota'=>0,
            'solicitudTurno_observaciones'=>'-',
            'solicitudTurno_fechaProcesamiento' => date('Y-m-d'),
            'solicitudTurno_fechaPedido'=>date('Y-m-d'),
            'solicitudTurno_respuestaEnviada'=>'SI',
            'solicitudTurno_fechaConfirmacion'=>date('Y-m-d'),
            'solicitudTurno_respuestaChequeada'=>1,
            'solicitudTurno_fechaRespuestaEnviada' => date('Y-m-d'),
            'solicitudTurnos_fechasTurnos' => $fechasTurnos_id,
            'solicitudTurnos_tipo' => 1,
            'solicitudTurno_habilitado'=>1
        ));

        if ($unaSolicitudManual->save())
            return $unaSolicitudManual;
        else
        {
            foreach ($unaSolicitudManual->getMessages() as $message)
            {
                echo $message, "<br>";
            }
            return null;
        }
    }

    /**
     * Genera el numero de turno y el codigo de operacion.
     * @return array
     */
    public function comprobarRespuesta()
    {
        $vencido = 2;//El plazo ya vencio
        $nroTurno = 1;

        try
        {
            if ($this->solicitudTurno_respuestaChequeada != 1)
            {
                /*EL TURNO NUNCA FUE CHEQUEADO: */
                $unPeriodo = Fechasturnos::findFirstByFechasTurnos_activo(1);
                if(!empty($unPeriodo))
                {
                    $fechaVencimiento = strtotime('+' . $unPeriodo->fechasTurnos_cantidadDiasConfirmacion . ' day', strtotime($unPeriodo->fechasTurnos_inicioSolicitud));
                    $fechaVencimiento = date('Y-m-d', $fechaVencimiento);
                    $fechaHoy = Date('Y-m-d');

                    if($fechaHoy <= $fechaVencimiento)
                    {
                        $this->solicitudTurno_respuestaChequeada = 1;//Is OKEY
                        $this->solicitudTurno_fechaConfirmacion = $fechaHoy;

                        if($unPeriodo->fechasTurnos_sinTurnos == 1)
                        {
                            $this->solicitudTurno_numero = 1;
                            $unPeriodo->fechasTurnos_sinTurnos = 0;

                            if (!$unPeriodo->update())
                                echo "Hubo un problema para generar el Nº de Turno";
                        }
                        else
                        {
                            //Obtengo el mayor numero de turnos existente y le sumo 1.
                            $this->solicitudTurno_numero = $this->obtenerUltimoNumero() +1 ;
                        }

                        $nroTurno = $this->solicitudTurno_numero;
                        $vencido  = 1;//Confirmacion exitosa.
                    }
                    else
                    {
                        /*EL PLAZO NO ES VALIDO, YA VENCIO LA FECHA PARA CONFIRMAR*/
                        $this->solicitudTurno_respuestaChequeada = 2;
                        $vencido = 2;//Vencio el plazo.
                        $nroTurno = null;
                    }

                    if (!$this->update())
                        echo "Ocurrio un problema al actualizar la solicitud.";
                }
            }
            else
            {
                $vencido = -1;//Ya confirmo el email
                $nroTurno = $this->solicitudTurno_numero;
            }
        }
        catch(Exception $e){
            echo $e->getMessage();
        }
        $codigo= $this->getRandomCode();
        return array('vencido'=> $vencido,'nroTurno'=>$nroTurno,'codigo'=>$codigo);
    }

    /**
     * Generar numero aleatorio.
     * @return string
     */
    private function getRandomCode(){
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
    /*public  function obtenerUltimoNumero()
    {
        $query = "SELECT S.solicitudTurno_numero  FROM  Solicitudturno AS S, Fechasturnos AS F WHERE F.fechasTurnos_activo=1 AND S.solicitudTurnos_fechasTurnos = F.fechasTurnos_id ORDER BY  solicitudTurno_numero DESC LIMIT 0 , 1";

        $solicitudAnterior = $this->getModelsManager()->executeQuery($query);
        return $solicitudAnterior[0]->solicitudTurno_numero;
    }*/
   /* public static function getUltimoTurnoDelPeriodo(){

        $query = new Phalcon\Mvc\Model\Query("SELECT S.solicitudTurno_numero  FROM  Solicitudturno AS S, Fechasturnos AS F WHERE F.fechasTurnos_activo=1 AND S.solicitudTurnos_fechasTurnos = F.fechasTurnos_id ORDER BY  solicitudTurno_numero DESC LIMIT 0 , 1", \Phalcon\DI\FactoryDefault::getDefault());
        $solicitudAnterior= $query->execute();
        return $solicitudAnterior[0]->solicitudTurno_numero;
    }*/
    /*
    ESTA FUNCION RECUPERA LAS SOLICITUDES QUE RESPONDEN AL ESTADO y USUARIO PASADOS POR PARAMETRO,
    ADEMAS QUE NO SEAN SOLITUDES MANUALES, QUE EL CAMPO RESPUESTA ENVIADA ESTE EN 'NO' */

    public static function recuperaSolicitudesSegunEstado($estado,$usuario)
    {
        $lista = array();
        $fechaTurnos = Fechasturnos::findFirstByFechasTurnos_activo(1);//Obtengo el periodo activo .

        if(!empty($fechaTurnos))
        {
            $fechaIniSol = $fechaTurnos->fechasTurnos_inicioSolicitud;
            $fechaFinSol = $fechaTurnos->fechasTurnos_finSolicitud;

            $condiciones = "solicitudTurno_estado=?1 AND solicitudTurno_respuestaEnviada=?2 AND solicitudTurno_manual=?3 AND solicitudTurno_nickUsuario=?4
            AND solicitudTurnos_fechasTurnos=?5 AND solicitudTurno_email IS NOT NULL";
            $parametros = array(1=>$estado,2=>'NO',3=>0,4=>$usuario,5=>$fechaTurnos->fechasTurnos_id);
            $solicitudes = Solicitudturno::find(array($condiciones,"bind"=>$parametros));

            foreach($solicitudes as $unaSolicitud)
            {
                $date = date_create($unaSolicitud->solicitudTurno_fechaPedido);
                $fechaPedido = date_format($date, 'Y-m-d');

                if ($fechaIniSol <= $fechaPedido and $fechaPedido <= $fechaFinSol)
                {
                    $lista[] = (array)$unaSolicitud;
                    Solicitudturno::actualizarRespYFechaEnviada($unaSolicitud->solicitudTurno_id);
                }
            }
        }
        return $lista;
    }
}
