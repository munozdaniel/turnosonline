<?php
/**
 * Created by PhpStorm.
 * User: Daniel
 * Date: 12/10/2015
 * Time: 08:40 AM
 */
use Phalcon\Forms\Form;
use Phalcon\Forms\Element\Text;
use Phalcon\Validation\Validator\PresenceOf;
use \Phalcon\Forms\Element\Date;
use Phalcon\Validation\Validator\Numericality;
use Phalcon\Validation\Validator\StringLength as StringLength;

class PeriodoSolicitudForm extends Form
{
    public function initialize($entity = null, $options = array())
    {
        if(isset($options['editar']))
        {
            $id = new \Phalcon\Forms\Element\Hidden('fechasTurnos_id',array(
                'class'         =>'form-control',
                'placeholder'   =>'ID',
                'required'      =>'',
                'readOnly'     =>'true'
            ));
            //añadimos la validación como campo requerido al password
            $id->addValidator(
                new PresenceOf(array(
                    'message' => 'El ID es requerido'
                ))
            );
            $this->add($id);
        }
        /*=================== PERIODO DE SOLICITUD DE TURNOS ==========================*/

        $periodoSolicitudDesde= new Date('fechasTurnos_inicioSolicitud',
            array('style'=>'text-align:right !important;font-size: 18px;',
                'required'=>'true'));
        $periodoSolicitudDesde->setLabel('<small class="font-rojo">* </small>Desde');
        $periodoSolicitudDesde->addValidators(array(
            new PresenceOf(array(
                'message' => 'Ingrese la <strong>Fecha de Inicio</strong> para la solicitud de turnos.'
            ))
        ));
        $this->add($periodoSolicitudDesde);

        $periodoSolicitudHasta= new Date('fechasTurnos_finSolicitud',
            array('style'=>'text-align:right !important;font-size: 18px;',
                'required'=>'true'));
        $periodoSolicitudHasta->setLabel('<small class="font-rojo">* </small>Hasta');
        $periodoSolicitudHasta->addValidators(array(
            new PresenceOf(array(
                'message' => 'Ingrese la <strong>Fecha Final</strong> para la solicitud de turnos.'
            )),
            new DateValidator(array(
                'mensajeError' => 'Verifique que la fecha  <strong>"HASTA"</strong> sea posterior a la fecha  <strong>"DESDE"</strong>.',
                'desde' =>$periodoSolicitudDesde->getValue()// valida qeu periodoSOlicitudHasta>periodoSolicitudDesde
            ))
        ));
        $this->add($periodoSolicitudHasta);

        /*=================== PERIODO DE ATENCION DE TURNOS ==========================*/

        $periodoAtencionDesde= new Date('fechasTurnos_diaAtencion',
            array('style'=>'text-align:right !important;font-size: 18px;',
                'required'=>'true'));
        $periodoAtencionDesde->setLabel('<small class="font-rojo">* </small>Día de atención de turnos inicial');
        $periodoAtencionDesde->addValidators(array(
            new PresenceOf(array(
                'message' => 'Ingrese la <strong>Fecha Inicial</strong> para la atención de turnos.'
            )),
            new DateValidator(array(
                'mensajeError' => 'Verifique que el <strong>dia de atención </strong> sea posterior al <strong>período de solicitud</strong>.',
                'desde' =>$periodoSolicitudHasta->getValue()
            ))
        ));
        $this->add($periodoAtencionDesde);

        $periodoAtencionHasta= new Date('fechasTurnos_diaAtencionFinal',
            array('style'=>'text-align:right !important;font-size: 18px;',
                'required'=>'true'));
        $periodoAtencionHasta->setLabel('<small class="font-rojo">* </small>Día de atención de turnos final');
        $periodoAtencionHasta->addValidators(array(
            new PresenceOf(array(
                'message' => 'Ingrese la <strong>Fecha Final</strong> para la atención de turnos.'
            )),
            new DateValidator(array(
                'mensajeError' => 'Verifique que <strong>dia de atención </strong> sea posterior al <strong>período de solicitud</strong>.',
                'desde' =>$periodoAtencionDesde->getValue()
            ))
        ));
        $this->add($periodoAtencionHasta);
        /*=================== CANTIDAD DE TURNOS ==========================*/

        $cantidadTurnos = new Text("fechasTurnos_cantidadDeTurnos",
            array('style'=>'text-align:right !important;font-size: 18px;',
                'placeholder'=>' INGRESE CANT. TURNOS',
                'required'=>'true'));
        $cantidadTurnos->setDefault(70);
        $cantidadTurnos->setLabel('<small class="font-rojo">* </small>Cantidad de Turnos');
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
            ));

        $this->add($cantidadTurnos);

        /*=================== CANTIDAD DE DIAS ==========================*/
        $cantidadDias = new Text("fechasTurnos_cantidadDiasConfirmacion",
            array('style'=>'text-align:right !important;font-size: 18px;',
                'required'=>'true',
                'placeholder'=>'INGRESE LA CANTIDAD DE DIAS'));
        $cantidadDias->setLabel('<small class="font-rojo">* </small>Cantidad de días para confirmar el mensaje');
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
    }

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