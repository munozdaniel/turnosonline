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
    /**
     * Initialize the products form
     */
    public function initialize($entity = null, $options = array())
    {
        /*=================== PERIODO DE SOLICITUD DE TURNOS ==========================*/

        $periodoSolicitudDesde= new Date('periodoSolicitudDesde');
        $periodoSolicitudDesde->setLabel('Desde');
        $periodoSolicitudDesde->addValidators(array(
            new PresenceOf(array(
                'message' => 'Ingrese la <strong>Fecha de Inicio</strong> para la solicitud de turnos.'
            ))
        ));
        $this->add($periodoSolicitudDesde);

        $periodoSolicitudHasta= new Date('periodoSolicitudHasta');
        $periodoSolicitudHasta->setLabel('Hasta');
        $periodoSolicitudHasta->addValidators(array(
            new PresenceOf(array(
                'message' => 'Ingrese la <strong>Fecha Final</strong> para la solicitud de turnos.'
            )),
            new DateValidator(array(
                'mensajeError' => 'Verifique que la fecha  <strong>"HASTA"</strong> sea posterior que la fecha  <strong>"DESDE"</strong>.',
                'desde' =>$periodoSolicitudDesde->getValue()// valida qeu periodoSOlicitudHasta>periodoSolicitudDesde
            ))
        ));
        $this->add($periodoSolicitudHasta);
        /*=================== PERIODO DE ATENCION DE TURNOS ==========================*/

        $periodoAtencionDesde= new Date('periodoAtencionDesde');
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
        /* Eliminado
        $periodoAtencionHasta= new Date('periodoAtencionHasta');
        $periodoAtencionHasta->setLabel('Hasta');
        $periodoAtencionHasta->addValidators(array(
            new PresenceOf(array(
                'message' => 'Ingrese la <strong>Fecha Final</strong> para la atención de turnos.'
            )),
            new DateValidator(array(
                'mensajeError' => 'Verifique que la fecha  <strong>"HASTA"</strong> sea mayor que la fecha  <strong>"DESDE"</strong>.',
                'desde' =>$periodoAtencionDesde->getValue()
            ))
        ));
        $this->add($periodoAtencionHasta);*/
        /*=================== CANTIDAD DE DIAS ==========================*/
        $cantidadDias = new Text("cantidadDias",array('style'=>'text-align:right !important;height: 40px !important;font-size: 18px;','placeholder'=>'CANTIDAD DÍAS'));
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

        /*=================== CANTIDAD DE TURNOS ==========================*/
        $cantidadTurnos = new Text("cantidadTurnos",array('style'=>'text-align:right !important;height: 40px !important;font-size: 18px;','placeholder'=>' INGRESE CANT. TURNOS'));
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