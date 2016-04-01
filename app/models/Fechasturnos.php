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

}
