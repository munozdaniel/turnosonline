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
        /*=================== PERIODO DE SOLICITUD DE TURNOS ==========================*/

        $periodoSolicitudDesde= new Date('periodoSolicitudDesde',
            array('style'=>'text-align:right !important;font-size: 18px;',
                'required'=>'true'));
        $periodoSolicitudDesde->setLabel('Desde');
        $periodoSolicitudDesde->addValidators(array(
            new PresenceOf(array(
                'message' => 'Ingrese la <strong>Fecha de Inicio</strong> para la solicitud de turnos.'
            ))
        ));
        $this->add($periodoSolicitudDesde);

        $periodoSolicitudHasta= new Date('periodoSolicitudHasta',
            array('style'=>'text-align:right !important;font-size: 18px;',
                'required'=>'true'));
        $periodoSolicitudHasta->setLabel('Hasta');
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

        $periodoAtencionDesde= new Date('periodoAtencionDesde',
            array('style'=>'text-align:right !important;font-size: 18px;',
                'required'=>'true'));
        $periodoAtencionDesde->setLabel('Día de atención de turnos');
        $periodoAtencionDesde->addValidators(array(
            new PresenceOf(array(
                'message' => 'Ingrese la <strong>Fecha de Inicio</strong> para la atención de turnos.'
            )),
            new DateValidator(array(
                'mensajeError' => 'Verifique que el <strong>dia de atención </strong> sea posterior al <strong>período de solicitud</strong>.',
                'desde' =>$periodoSolicitudHasta->getValue()
            ))
        ));
        $this->add($periodoAtencionDesde);

        /*=================== CANTIDAD DE TURNOS ==========================*/

        $cantidadTurnos = new Text("cantidadTurnos",
            array('style'=>'text-align:right !important;font-size: 18px;',
                'placeholder'=>' INGRESE CANT. TURNOS',
                'required'=>'true'));
        $cantidadTurnos->setDefault(70);
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
            ));

        $this->add($cantidadTurnos);

        /*=================== CANTIDAD DE DIAS ==========================*/
        $cantidadDias = new Text("cantidadDias",
            array('style'=>'text-align:right !important;font-size: 18px;',
                'required'=>'true',
                'placeholder'=>'INGRESE LA CANTIDAD DE DIAS'));
        $cantidadDias->setLabel("Cantidad de días para confirmar el mensaje ");
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