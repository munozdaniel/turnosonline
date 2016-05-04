<?php

class Fechasturnos extends \Phalcon\Mvc\Model
{

    /**
     *
     * @var integer
     */
    protected $fechasTurnos_id;

    /**
     *
     * @var string
     */
    protected $fechasTurnos_inicioSolicitud;

    /**
     *
     * @var string
     */
    protected $fechasTurnos_finSolicitud;

    /**
     *
     * @var string
     */
    protected $fechasTurnos_diaAtencion;
    /**
     *
     * @var string
     */
    protected $fechasTurnos_diaAtencionFinal;
    /**
     *
     * @var integer
     */
    protected $fechasTurnos_cantidadDeTurnos;

    /**
     *
     * @var integer
     */
    protected $fechasTurnos_cantidadAutorizados;

    /**
     *
     * @var integer
     */
    protected $fechasTurnos_cantidadDiasConfirmacion;

    /**
     *
     * @var integer
     */
    protected $fechasTurnos_activo;

    /**
     *
     * @var integer
     */
    protected $fechasTurnos_sinTurnos;



    /**
     * Method to set the value of field fechasTurnos_id
     *
     * @param integer $fechasTurnos_id
     * @return $this
     */
    public function setFechasturnosId($fechasTurnos_id)
    {
        $this->fechasTurnos_id = $fechasTurnos_id;

        return $this;
    }

    /**
     * Method to set the value of field fechasTurnos_inicioSolicitud
     *
     * @param string $fechasTurnos_inicioSolicitud
     * @return $this
     */
    public function setFechasturnosIniciosolicitud($fechasTurnos_inicioSolicitud)
    {
        $this->fechasTurnos_inicioSolicitud = $fechasTurnos_inicioSolicitud;

        return $this;
    }

    /**
     * Method to set the value of field fechasTurnos_finSolicitud
     *
     * @param string $fechasTurnos_finSolicitud
     * @return $this
     */
    public function setFechasturnosFinsolicitud($fechasTurnos_finSolicitud)
    {
        $this->fechasTurnos_finSolicitud = $fechasTurnos_finSolicitud;

        return $this;
    }

    /**
     * Method to set the value of field fechasTurnos_diaAtencion
     *
     * @param string $fechasTurnos_diaAtencion
     * @return $this
     */
    public function setFechasturnosDiaatencion($fechasTurnos_diaAtencion)
    {
        $this->fechasTurnos_diaAtencion = $fechasTurnos_diaAtencion;

        return $this;
    }

    /**
     * Method to set the value of field fechasTurnos_diaAtencionFinal
     *
     * @param string $fechasTurnos_diaAtencionFinal
     * @return $this
     */
    public function setFechasturnosDiaatencionfinal($fechasTurnos_diaAtencionFinal)
    {
        $this->fechasTurnos_diaAtencionFinal = $fechasTurnos_diaAtencionFinal;

        return $this;
    }

    /**
     * Method to set the value of field fechasTurnos_cantidadDeTurnos
     *
     * @param integer $fechasTurnos_cantidadDeTurnos
     * @return $this
     */
    public function setFechasturnosCantidaddeturnos($fechasTurnos_cantidadDeTurnos)
    {
        $this->fechasTurnos_cantidadDeTurnos = $fechasTurnos_cantidadDeTurnos;

        return $this;
    }

    /**
     * Method to set the value of field fechasTurnos_cantidadAutorizados
     *
     * @param integer $fechasTurnos_cantidadAutorizados
     * @return $this
     */
    public function setFechasturnosCantidadautorizados($fechasTurnos_cantidadAutorizados)
    {
        $this->fechasTurnos_cantidadAutorizados = $fechasTurnos_cantidadAutorizados;

        return $this;
    }

    /**
     * Method to set the value of field fechasTurnos_cantidadDiasConfirmacion
     *
     * @param integer $fechasTurnos_cantidadDiasConfirmacion
     * @return $this
     */
    public function setFechasturnosCantidaddiasconfirmacion($fechasTurnos_cantidadDiasConfirmacion)
    {
        $this->fechasTurnos_cantidadDiasConfirmacion = $fechasTurnos_cantidadDiasConfirmacion;

        return $this;
    }

    /**
     * Method to set the value of field fechasTurnos_activo
     *
     * @param integer $fechasTurnos_activo
     * @return $this
     */
    public function setFechasturnosActivo($fechasTurnos_activo)
    {
        $this->fechasTurnos_activo = $fechasTurnos_activo;

        return $this;
    }

    /**
     * Method to set the value of field fechasTurnos_sinTurnos
     *
     * @param integer $fechasTurnos_sinTurnos
     * @return $this
     */
    public function setFechasturnosSinturnos($fechasTurnos_sinTurnos)
    {
        $this->fechasTurnos_sinTurnos = $fechasTurnos_sinTurnos;

        return $this;
    }

    /**
     * Returns the value of field fechasTurnos_id
     *
     * @return integer
     */
    public function getFechasturnosId()
    {
        return $this->fechasTurnos_id;
    }

    /**
     * Returns the value of field fechasTurnos_inicioSolicitud
     *
     * @return string
     */
    public function getFechasturnosIniciosolicitud()
    {
        return $this->fechasTurnos_inicioSolicitud;
    }

    /**
     * Returns the value of field fechasTurnos_finSolicitud
     *
     * @return string
     */
    public function getFechasturnosFinsolicitud()
    {
        return $this->fechasTurnos_finSolicitud;
    }

    /**
     * Returns the value of field fechasTurnos_diaAtencion
     *
     * @return string
     */
    public function getFechasturnosDiaatencion()
    {
        return $this->fechasTurnos_diaAtencion;
    }

    /**
     * Returns the value of field fechasTurnos_diaAtencionFinal
     *
     * @return string
     */
    public function getFechasturnosDiaatencionfinal()
    {
        return $this->fechasTurnos_diaAtencionFinal;
    }

    /**
     * Returns the value of field fechasTurnos_cantidadDeTurnos
     *
     * @return integer
     */
    public function getFechasturnosCantidaddeturnos()
    {
        return $this->fechasTurnos_cantidadDeTurnos;
    }

    /**
     * Returns the value of field fechasTurnos_cantidadAutorizados
     *
     * @return integer
     */
    public function getFechasturnosCantidadautorizados()
    {
        return $this->fechasTurnos_cantidadAutorizados;
    }

    /**
     * Returns the value of field fechasTurnos_cantidadDiasConfirmacion
     *
     * @return integer
     */
    public function getFechasturnosCantidaddiasconfirmacion()
    {
        return $this->fechasTurnos_cantidadDiasConfirmacion;
    }

    /**
     * Returns the value of field fechasTurnos_activo
     *
     * @return integer
     */
    public function getFechasturnosActivo()
    {
        return $this->fechasTurnos_activo;
    }

    /**
     * Returns the value of field fechasTurnos_sinTurnos
     *
     * @return integer
     */
    public function getFechasturnosSinturnos()
    {
        return $this->fechasTurnos_sinTurnos;
    }

    /**
     * Initialize method for model.
     */
    public function initialize()
    {
        $this->hasMany('fechasTurnos_id', 'Solicitudturno', 'solicitudTurnos_fechasTurnos', array('alias' => 'Solicitudturno'));
    }

    /**
     * Returns table name mapped in the model.
     *
     * @return string
     */
    public function getSource()
    {
        return 'fechasturnos';
    }

    /**
     * Allows to query a set of records that match the specified conditions
     *
     * @param mixed $parameters
     * @return Fechasturnos[]
     */
    public static function find($parameters = null)
    {
        return parent::find($parameters);
    }

    /**
     * Allows to query the first record that match the specified conditions
     *
     * @param mixed $parameters
     * @return Fechasturnos
     */
    public static function findFirst($parameters = null)
    {
        return parent::findFirst($parameters);
    }

    public static function incrementarCantAutorizados()
    {
        $ultimoPeriodo = Fechasturnos::findFirstByFechasTurnos_activo(1);
        $autorizados = $ultimoPeriodo->fechasTurnos_cantidadAutorizados;
        $ultimoPeriodo->fechasTurnos_cantidadAutorizados = $autorizados + 1;

        if ($ultimoPeriodo->save())
            return true;
        else {
            foreach ($ultimoPeriodo->getMessages() as $message) {
                echo $message, "<br>";
            }
            return false;
        }
    }

    public static function decrementarCantAutorizados()
    {
        $ultimoPeriodo = Fechasturnos::findFirstByFechasTurnos_activo(1);
        $autorizados = $ultimoPeriodo->fechasTurnos_cantidadAutorizados;
        $ultimoPeriodo->fechasTurnos_cantidadAutorizados = $autorizados - 1;

        if ($ultimoPeriodo->save())
            return true;
        else {
            foreach ($ultimoPeriodo->getMessages() as $message) {
                echo $message, "<br>";
            }
            return false;
        }
    }

    public static function cantAutorizadosDelPeriodoActual()
    {
        $ultimoPeriodo = Fechasturnos::findFirstByFechasTurnos_activo(1);
        $cantAutorizados = $ultimoPeriodo->fechasTurnos_cantidadAutorizados;
        return $cantAutorizados;
    }

    /**
     * Se encarga de verificar si en el ultimo periodo existen turnos disponible.
     * @return boolean
     */
    public static function verificaSiHayTurnosEnPeriodo()
    {
        $ultimoPeriodo = Fechasturnos::findFirstByFechasTurnos_activo(1);
        $retorno = array();
        $retorno['success'] = true;
        if (!$ultimoPeriodo) {
            $retorno['success'] = false;
            $retorno['mensaje'] = "EL PERIODO PARA SOLICITAR TURNOS NO SE ENCUENTRA DISPONIBLE.";
            return $retorno;
        }
        if ($ultimoPeriodo->fechasTurnos_cantidadDeTurnos <= $ultimoPeriodo->fechasTurnos_cantidadAutorizados) {
            $retorno['success'] = false;
            $retorno['mensaje'] = "LAMENTABLEMENTE NO HAY TURNOS DISPONIBLE.";
            return $retorno;
        }
        return $retorno;
    }

    /**
     * Verifica si en la fecha de hoy ya vencio el plazo para confirmar el turno.
     * @param $cantidadDias
     * @param $fechaInicioSolicitud
     * @return bool
     */
    public static function vencePlazoConfirmacion($cantidadDias, $fechaInicioSolicitud)
    {
        $fechaVencimiento = strtotime('+' . $cantidadDias . ' day', strtotime($fechaInicioSolicitud));
        $fechaVencimiento = date('Y-m-d', $fechaVencimiento);
        $fechaHoy = Date('Y-m-d');
        if ($fechaHoy <= $fechaVencimiento)
            return false;
        return true;
    }

    public function esPlazoParaSolicitarTurno()
    {
        if ($this->getFechasturnosIniciosolicitud()<= date('Y-m-d') &&
            date('Y-m-d') <= $this->getFechasturnosFinsolicitud())
            return true;
        return false;
    }

    public function hayTurnosDisponibles()
    {
        if ($this->getFechasturnosCantidaddeturnos() <= $this->getFechasturnosCantidadautorizados())
            return false;
        return true;
    }

    /**
     * Verifica si la cancelacion se realiza 48hs antes de la asistencia.
     * @return bool
     */
    public static function verificaCancelacionDentro48Hs()
    {
        //FIXME: PREGUNTAR SI ES DENTRO DE LAS 48HS
        $ultimoPeriodo = Fechasturnos::findFirst(array("fechasTurnos_activo = 1"));
        if(!$ultimoPeriodo)
            return false;
        $nuevafecha = strtotime ( '-2 day' , strtotime ( $ultimoPeriodo->getFechasturnosDiaatencion() ) ) ;
        $nuevafecha = date ( 'Y-m-d' , $nuevafecha );
        if(date('Y-m-d')< $nuevafecha)
            return true;
        return false;
    }
}
