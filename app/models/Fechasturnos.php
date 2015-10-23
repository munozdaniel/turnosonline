<?php

class Fechasturnos extends \Phalcon\Mvc\Model
{

    /**
     *
     * @var integer
     */
    public $fechasTurnos_id;

    /**
     *
     * @var string
     */
    public $fechasTurnos_inicioSolicitud;

    /**
     *
     * @var string
     */
    public $fechasTurnos_finSolicitud;

    /**
     *
     * @var string
     */
    public $fechasTurnos_diaAtencion;

    /**
     *
     * @var integer
     */
    public $fechasTurnos_cantidadDeTurnos;

    /**
     *
     * @var integer
     */
    public $fechasTurnos_cantidadAutorizados;

    /**
     *
     * @var integer
     */
    public $fechasTurnos_cantidadDiasConfirmacion;

    /**
     *
     * @var integer
     */
    public $fechasTurnos_activo;

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
        $ultimoPeriodo->fechasTurnos_cantidadAutorizados = $autorizados+1;

        if ($ultimoPeriodo->save())
            return true;
        else
        {
            foreach ($ultimoPeriodo->getMessages() as $message)
            {
                echo $message, "<br>";
            }
            return false;
        }
    }
}
