<?php

class Fechasturnos extends \Phalcon\Mvc\Model
{

    protected $fechasTurnos_id;

    protected $fechasTurnos_inicioSolicitud;

    protected $fechasTurnos_finSolicitud;

    protected $fechasTurnos_diaAtencion;

    protected $fechasTurnos_diaAtencionFinal;

    protected $fechasTurnos_cantidadDeTurnos;

    protected $fechasTurnos_cantidadAutorizados;

    protected $fechasTurnos_activo;

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
    public static function verificaSiHayTurnos($ultimoPeriodo){
        if($ultimoPeriodo->getFechasturnosCantidadautorizados() >= $ultimoPeriodo->getFechasturnosCantidaddeturnos())
            return true;
        return false;
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
     * Verifica que la fecha en la que solicitó el turno no haya pasado las 96hs
     * @return boolean true si esta dentro del periodo, false si no lo está.
     */
    public static function verificarConfirmacionDentroPlazoOnline($fechaSolicitud)
    {
        $fechaLimiteConfirmacion = strtotime ( '+4 day' , strtotime ( $fechaSolicitud ) ) ;
        $fechaLimiteConfirmacion = date('Y-m-d', $fechaLimiteConfirmacion);
        $fechaSolicitud = (new DateTime($fechaSolicitud))->format('Y-m-d');
        if($fechaSolicitud<=$fechaLimiteConfirmacion)
            return true;
        return false;
    }
    /**
     * Verifica que la fecha en la que solicitó el turno no haya pasado las 72hs
     * @return boolean true si esta dentro del periodo, false si no lo está.
     */
    public static function verificarConfirmacionDentroPlazoTerminal($fechaSolicitud)
    {
        $fechaLimiteConfirmacion = strtotime ( '+3 day' , strtotime ( $fechaSolicitud ) ) ;
        $fechaLimiteConfirmacion = date('Y-m-d', $fechaLimiteConfirmacion);
        $fechaSolicitud = (new DateTime($fechaSolicitud))->format('Y-m-d');
        if($fechaSolicitud<=$fechaLimiteConfirmacion)
            return true;
        return false;
    }
}
