<?php
use Phalcon\Mvc\Model\Query;
class Solicitudturno extends \Phalcon\Mvc\Model
{

    /**
     *
     * @var integer
     */
    public $solicitudTurno_id;
    public $solicitudTurno_fechaRespuestaEnviadaDate;
    public $solicitudTurno_respChequedaTexto;

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
     *
     * @var integer
     */
    public $solicitudTurno_numero;
    /**
     *
     * @var date
     */
    public $solicitudTurno_fechaComprobacion;

    public  function comprobarRespuesta($laSolicitud)
    {
        $vencido = -1;
        $nroTurno = 1;
        try{
        if ($laSolicitud->solicitudTurno_respuestaChequeada != 1) {
            /*EL TURNO NUNCA FUE CHEQUEADO: */
            $unPeriodo = Fechasturnos::findFirstByFechasTurnos_activo(1);
            $fechaVencimiento = strtotime('+' . $unPeriodo->fechasTurnos_cantidadDiasConfirmacion . ' day', strtotime($unPeriodo->fechasTurnos_inicioSolicitud));
            $fechaVencimiento = date('Y-m-d', $fechaVencimiento);
            $fechaHoy = Date('Y-m-d');

            /*VERIFICA SI EL PLAZO ES VALIDO PARA CONFIRMAR*/
            if ($fechaHoy <= $fechaVencimiento
                && $fechaVencimiento < $unPeriodo->fechasTurnos_diaAtencion
            ) {
                $laSolicitud->solicitudTurno_respuestaChequeada = 1;//Is OKEY
                $laSolicitud->solicitudTurno_fechaConfirmacion = $fechaHoy;
                /* Se encarga de verificar si en el periodo ya se solicitaron turnos.
                    En caso Negativo: el numero de turno comenzara en 1. En caso Positivo: el numero de turno aumentara en 1.*/
                if ($unPeriodo->fechasTurnos_sinTurnos == 1) {//Va a ser el primer turno del periodo.
                    $laSolicitud->solicitudTurno_numero = 1;
                    $unPeriodo->fechasTurnos_sinTurnos = 0;
                    if (!$unPeriodo->update())
                        echo "Hubo un problema para generar el Nº de Turno";
                } else {
                    //Obtengo el mayor numero de turnos existente y le sumo 1.

                    $query = "SELECT * FROM  Solicitudturno ORDER BY  solicitudTurno_numero DESC LIMIT 0 , 1";

                    $solicitudAnterior = $this->getModelsManager()->executeQuery($query);
                    $laSolicitud->solicitudTurno_numero = $solicitudAnterior[0]->solicitudTurno_numero + 1;
                }
            } else {
                /*EL PLAZO NO ES VALIDO, YA VENCIO LA FECHA PARA CONFIRMAR*/
                $laSolicitud->solicitudTurno_respuestaChequeada = 2;//Vencio el plazo.
            }
            if (!$laSolicitud->update())
                echo "Ocurrio un problema al actualizar la solicitud.";
            $vencido = $laSolicitud->solicitudTurno_respuestaChequeada;
            $nroTurno = $laSolicitud->solicitudTurno_numero;
        }
        }
        catch(Exception $e){
            echo $e->getMessage();
        }
        return array('vencido'=> $vencido,'nroTurno'=>$nroTurno);
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

        if(!empty($fechaTurnos)){
            $ffI = $fechaTurnos->fechasTurnos_inicioSolicitud;
            $ffF =$fechaTurnos->fechasTurnos_finSolicitud;

            $solicitudes = Solicitudturno::find();

            foreach($solicitudes as $unaSolicitud)
            {
                $ffPedido = date('Y-m-d',strtotime($unaSolicitud->solicitudTurno_fechaPedido));

                if($unaSolicitud->solicitudTurno_respuestaEnviada=='SI' and $ffPedido <= $ffF and $ffPedido >= $ffI)
                {
                    $unaSolicitud->solicitudTurno_fechaRespuestaEnviadaDate = date('d/m/Y',strtotime($unaSolicitud->solicitudTurno_fechaRespuestaEnviada));

                    $resp = $unaSolicitud->solicitudTurno_respuestaChequeada;

                    if($resp == 1)
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
                            $unaSolicitud->solicitudTurno_respChequedaTexto="NO (cancelado)";
                    }

                    $solicitudesOnline[]= (array)$unaSolicitud;
                }
            }
        }
        return $solicitudesOnline;
    }

    public static function accionAgregarUnaSolicitudOnline($legajo,$nombreCompleto,$documento,$email,$numTelefono)
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
            'solicitudTurno_manual'=>0));

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

    public static function accionAgregarUnaSolicitudManual($legajo,$nombreCompleto,$documento,$numTelefono,$estado,$nickActual)
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
            'solicitudTurno_fechaComprobacion'=>NULL,
            'solicitudTurno_respuestaChequeada'=>1,
            'solicitudTurno_fechaRespuestaEnviada' => date('Y-m-d'),
            'solicitudTurno_manual'=>1));

        if ($unaSolicitudManual->save())
            return true;
        else
        {
            foreach ($unaSolicitudManual->getMessages() as $message)
            {
                echo $message, "<br>";
            }
            return false;
        }
    }

    public static function recuperaSolicitudesSegunEstado($estado)
    {
        $lista = array();
        $fechaTurnos = Fechasturnos::findFirstByFechasTurnos_activo(1);//Obtengo el periodo activo .
        if(!empty($fechaTurnos)){
            $fechaIniSol = $fechaTurnos->fechasTurnos_inicioSolicitud;
            $fechaFinSol = $fechaTurnos->fechasTurnos_finSolicitud;

            $condiciones = "solicitudTurno_estado=?1 AND solicitudTurno_respuestaEnviada=?2 AND solicitudTurno_manual=?3";
            $parametros = array(1=>$estado,2=>'NO',3=>0);
            $solicitudes = Solicitudturno::find(array($condiciones,"bind"=>$parametros));

            foreach($solicitudes as $unaSolicitud)
            {
                $fechaPedido = $unaSolicitud->solicitudTurno_fechaPedido;

                if ($fechaIniSol <= $fechaPedido and $fechaPedido <= $fechaFinSol)
                {
                    $lista[] = (array)$unaSolicitud;
                    Solicitudturno::actualizarRespYFechaEnviada($unaSolicitud->solicitudTurno_id);
                }
            }
        }
        return $lista;
    }

    private static function actualizarRespYFechaEnviada($id)
    {
        $laSolicitud = Solicitudturno::findFirstBySolicitudTurno_id($id);
        $laSolicitud->solicitudTurno_respuestaEnviada = 'SI';
        $laSolicitud->solicitudTurno_fechaRespuestaEnviada= date('Y-m-d');
        $laSolicitud->save();
    }

}
