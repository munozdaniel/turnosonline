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
class PeriodoSolicitudForm extends Form {
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
            )),
            new DateValidator()
        ));
        $this->add($periodoSolicitudDesde);

        $periodoSolicitudHasta= new Date('periodoSolicitudHasta');
        $periodoSolicitudHasta->setLabel('Hasta');
        $periodoSolicitudHasta->addValidators(array(
            new PresenceOf(array(
                'message' => 'Ingrese la <strong>Fecha Final</strong> para la solicitud de turnos.'
            ))
        ));
        $this->add($periodoSolicitudHasta);
        /*=================== PERIODO DE ATENCION DE TURNOS ==========================*/

        $periodoAtencionDesde= new Date('periodoAtencionDesde');
        $periodoAtencionDesde->setLabel('Desde');
        $periodoAtencionDesde->addValidators(array(
            new PresenceOf(array(
                'message' => 'Ingrese la <strong>Fecha de Inicio</strong> para la atención de turnos.'
            ))
        ));
        $this->add($periodoAtencionDesde);

        $periodoAtencionHasta= new Date('periodoAtencionHasta');
        $periodoAtencionHasta->setLabel('Hasta');
        $periodoAtencionHasta->addValidators(array(
            new PresenceOf(array(
                'message' => 'Ingrese la <strong>Fecha Final</strong> para la atención de turnos.'
            ))
        ));
        $this->add($periodoAtencionHasta);
        /*=================== CANTIDAD DE TURNOS ==========================*/
        $cantidadDias = new Text("cantidadDias",array('style'=>'text-align:right !important;height: 40px !important;font-size: 18px;','placeholder'=>' INGRESE CANT. DÍAS'));
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
                )
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
                )
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
                //$this->flash->error($message);
                $cadena.= $message ."<br>";//para mostrar con tooltip
            }
        }
        return $cadena;
    }

}