<?php

use Phalcon\Forms\Form;
use Phalcon\Forms\Element\Text;
use Phalcon\Validation\Validator\PresenceOf;
use \Phalcon\Forms\Element\Date;
use Phalcon\Validation\Validator\Numericality;
use \Phalcon\Forms\Element\Hidden;

class EditarPeriodoForm extends Form
{
    public function initialize(Fechasturnos $fecha, $options = array())
    {
        $id = $fecha->fechasTurnos_id;
        $iniPeriodo =$fecha->fechasTurnos_inicioSolicitud;
        $fPeriodo = $fecha->fechasTurnos_finSolicitud;
        $diaAten = $fecha->fechasTurnos_diaAtencion;
        $cantTurnos = $fecha->fechasTurnos_cantidadDeTurnos;
        $cantDiasConf = $fecha->fechasTurnos_cantidadDiasConfirmacion;

      /*  $idFechaTurno = new Hidden();
        $idFechaTurno->setDefault($id);
        $this->add($idFechaTurno);*/

        $periodoSolicitudDesde= new Date('periodoSolicitudDesde');
        $periodoSolicitudDesde->setLabel('Desde');
        $periodoSolicitudDesde->setDefault($iniPeriodo);
        $periodoSolicitudDesde->addValidators(array(
            new PresenceOf(array(
                'message' => 'Ingrese la <strong>Fecha de Inicio</strong> para la solicitud de turnos.'
            ))
        ));
        $this->add($periodoSolicitudDesde);

        $periodoSolicitudHasta= new Date('periodoSolicitudHasta');
        $periodoSolicitudHasta->setLabel('Hasta');
        $periodoSolicitudHasta->setDefault($fPeriodo);
        $periodoSolicitudHasta->addValidators(array(
            new PresenceOf(array(
                'message' => 'Ingrese la <strong>Fecha Final</strong> para la solicitud de turnos.'
            )),
            new DateValidator(array(
                'mensajeError' => 'Verifique que la fecha  <strong>"HASTA"</strong> sea mayor que la fecha  <strong>"DESDE"</strong>.',
                'desde' =>$periodoSolicitudDesde->getValue()// valida qeu periodoSOlicitudHasta>periodoSolicitudDesde
            ))
        ));
        $this->add($periodoSolicitudHasta);
        /*=================== PERIODO DE ATENCION DE TURNOS ==========================*/

        $periodoAtencionDesde= new Date('periodoAtencionDesde');
        $periodoAtencionDesde->setDefault($diaAten);
        $periodoAtencionDesde->addValidators(array(
            new PresenceOf(array(
                'message' => 'Ingrese la <strong>Fecha de Inicio</strong> para la atención de turnos.'
            )),
            new DateValidator(array(
                'mensajeError' => 'Verifique que el <strong>Período de Atención </strong> sea mayor que el <strong>Período de Solicitud</strong>.',
                'desde' =>$periodoSolicitudHasta->getValue()
            ))
        ));
        $this->add($periodoAtencionDesde);

        /*=================== CANTIDAD DE DIAS ==========================*/
        $cantidadDias = new Text("cantidadDias",array('style'=>'text-align:right !important;height: 40px !important;font-size: 18px;'));
        $cantidadDias->setLabel("Cantidad de d&iacute;as para confirmar el mensaje ");
        $cantidadDias->setDefault($cantDiasConf);
        $cantidadDias->setFilters(array('int'));
        $cantidadDias->addValidators(
            array(
                new PresenceOf(
                    array(
                        'message' => 'Ingrese la <strong>cantidad de días</strong> para confirmar el mensaje.'
                    )
                ),
                new Numericality(
                    array(
                        'message' => 'La <strong>cantidad de días</strong> debe ser un número.'
                    )
                ),
                new NumberValidator()
            )
        );
        $this->add($cantidadDias);

        /*=================== CANTIDAD DE TURNOS ==========================*/
        $cantidadTurnos = new Text("cantidadTurnos",array('style'=>'text-align:right !important;height: 40px !important;font-size: 18px;'));
        $cantidadTurnos->setDefault($cantTurnos);
        $cantidadTurnos->setLabel("Cantidad de Turnos");
        $cantidadTurnos->setFilters(array('int'));
        $cantidadTurnos->addValidators(
            array(
                new PresenceOf(
                    array(
                        'message' => 'Debe ingresar la <strong>cantidad de turnos</strong>.'
                    )
                ),
                new Numericality(
                    array(
                        'message' => 'La <strong>cantidad de turnos</strong> debe ser un número.'
                    )
                ),
                new NumberValidator()
            )
        );
        $this->add($cantidadTurnos);
    }
    /**
     * Prints messages for a specific element
     */
    public function messages($name)
    {
        $cadena= "";
        if ($this->hasMessagesFor($name)) {
            foreach ($this->getMessagesFor($name) as $message) {
                $cadena.= "<div class='problema'>".$message ."</div>";//para mostrar con tooltip
            }
        }
        return $cadena;
    }

}