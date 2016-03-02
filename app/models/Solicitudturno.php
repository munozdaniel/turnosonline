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
     * @var integer
     */
    public $solicitudTurno_tipo;
    /**
     *
     * @var date
     */
    public $solicitudTurno_fechaComprobacion;

    public $solicitudTurno_idCodificado;


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

        if(!empty($fechaTurnos))
        {
            $ffI = $fechaTurnos->fechasTurnos_inicioSolicitud;
            $ffF = $fechaTurnos->fechasTurnos_finSolicitud;

            $solicitudes = Solicitudturno::find(array(
                "solicitudTurnos_fechasTurnos = {$fechaTurnos->fechasTurnos_id}",
                "order" => "solicitudTurno_numero DESC")); // 11/02/2016 M.

            //$solicitudes = Solicitudturno::findBySolicitudTurnos_fechasTurnos($fechaTurnos->fechasTurnos_id);

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
                            $unaSolicitud->solicitudTurno_respChequedaTexto="SI (turno cancelado)";
                    }

                    $unaSolicitud->solicitudTurno_idCodificado= base64_encode($unaSolicitud->solicitudTurno_id); //24/02
                    $solicitudesOnline[]= (array)$unaSolicitud;
                }
            }
        }
        return $solicitudesOnline;
    }

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

    public static function accionAgregarUnaSolicitudManual($legajo,$nombreCompleto,$documento,$numTelefono,
                                                           $estado,$nickActual,$nroTurno=NULL,$fechasTurnos_id)
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
            'solicitudTurno_numero' => $nroTurno,
            'solicitudTurnos_fechasTurnos' => $fechasTurnos_id,
            'solicitudTurnos_tipo' => 1,
            'solicitudTurno_manual'=>1));

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
        return array('vencido'=> $vencido,'nroTurno'=>$nroTurno);
    }
    public  function obtenerUltimoNumero()
    {
        $query = "SELECT S.solicitudTurno_numero  FROM  Solicitudturno AS S, Fechasturnos AS F WHERE F.fechasTurnos_activo=1 AND S.solicitudTurnos_fechasTurnos = F.fechasTurnos_id ORDER BY  solicitudTurno_numero DESC LIMIT 0 , 1";

        $solicitudAnterior = $this->getModelsManager()->executeQuery($query);
        return $solicitudAnterior[0]->solicitudTurno_numero;
    }
    public static function getUltimoTurnoDelPeriodo(){

        $query = new Phalcon\Mvc\Model\Query("SELECT S.solicitudTurno_numero  FROM  Solicitudturno AS S, Fechasturnos AS F WHERE F.fechasTurnos_activo=1 AND S.solicitudTurnos_fechasTurnos = F.fechasTurnos_id ORDER BY  solicitudTurno_numero DESC LIMIT 0 , 1", \Phalcon\DI\FactoryDefault::getDefault());
        $solicitudAnterior= $query->execute();
        return $solicitudAnterior[0]->solicitudTurno_numero;
    }
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

            $condiciones = "solicitudTurno_estado=?1 AND solicitudTurno_respuestaEnviada=?2 AND solicitudTurno_manual=?3 AND solicitudTurno_nickUsuario=?4";
            $parametros = array(1=>$estado,2=>'NO',3=>0,4=>$usuario);
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

    public static function cambiarRespuesta($id)
    {
        $laSolicitud = Solicitudturno::findFirstBySolicitudTurno_id($id);
        $laSolicitud->solicitudTurno_respuestaChequeada=1;
        $laSolicitud->save();
    }
}
