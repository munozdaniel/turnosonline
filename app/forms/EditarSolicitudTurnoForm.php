<?php
/**
 * Created by PhpStorm.
 * User: dmunioz
 * Date: 23/10/2015
 * Time: 10:17
 */
use Phalcon\Forms\Form;
use Phalcon\Forms\Element\Text;
use Phalcon\Validation\Validator\PresenceOf;
use Phalcon\Validation\Validator\Numericality;

class EditarSolicitudTurnoForm extends Form
{
    /**
     * Initialize the products form
     */
    public function initialize($entity = null, $options = array())
    {

        $select = new SelectElement('miSelect',array('pendiente'=>'PENDIENTE','revision'=>'REVISION','denegado'=>'DENEGADO'));
        $select->setLabel('MI SELECT');
        $this->add($select);

            /*=================== ESTADO ==========================
            $motivoDeEleccion = new \Phalcon\Forms\Element\Select('estado', array(
                'pendiente' => 'PENDIENTE',
                'revision' => 'REVISION'
            ));
            $motivoDeEleccion->setLabel('Porque eligió este destino?');
            $this->add($motivoDeEleccion);*/
        if (!isset($options['revision'])) {
            /*=================== MONTO MAXIMO ==========================*/
            $montoMaximo = new Text("montoMaximo",
                array('style' => 'text-align:right !important;height: 40px !important;font-size: 18px;',
                    'placeholder' => 'Ingrese un número'));
            $montoMaximo->setLabel("<span class='problema'>(*)</span> Monto Máximo");
            $montoMaximo->setFilters(array('int'));
            $montoMaximo->addValidators(
                array(
                    new PresenceOf(
                        array(
                            'message' => 'El <strong>Monto Máximo</strong> es obligatorio.'
                        )
                    ),
                    new Numericality(
                        array(
                            'message' => 'Debe ser un valor númerico.'
                        )
                    ),
                    new NumberValidator()
                )
            );
            $this->add($montoMaximo);
            /*=================== MONTO POSIBLE ==========================*/
            $montoPosible = new Text("montoPosible",
                array('style' => 'text-align:right !important;height: 40px !important;font-size: 18px;',
                    'placeholder' => 'Ingrese un número'));
            $montoPosible->setLabel("<span class='problema'>(*)</span> Monto Posible");
            $montoPosible->setFilters(array('int'));
            $montoPosible->addValidators(
                array(
                    new PresenceOf(
                        array(
                            'message' => 'El <strong>Monto Posible</strong> es obligatorio.'
                        )
                    ),
                    new Numericality(
                        array(
                            'message' => 'Debe ser un valor númerico.'
                        )
                    ),
                    new NumberValidator()
                )
            );
            $this->add($montoPosible);
            /*=================== CANTIDAD DE CUOTAS ==========================*/
            $cantCuotas = new Text("cantCuotas",
                array('style' => 'text-align:right !important;height: 40px !important;font-size: 18px;',
                    'placeholder' => 'Ingrese un número'));
            $cantCuotas->setLabel("<span class='problema'>(*)</span> Cantidad de Cuotas");
            $cantCuotas->setFilters(array('int'));
            $cantCuotas->addValidators(
                array(
                    new PresenceOf(
                        array(
                            'message' => 'La <strong>Cantidad de Cuotas</strong> es obligatorio.'
                        )
                    ),
                    new Numericality(
                        array(
                            'message' => 'Debe ser un valor númerico.'
                        )
                    ),
                    new NumberValidator()
                )
            );
            $this->add($cantCuotas);
        }
        /*=================== VALOR DE CUOTAS ==========================*/
        $valorCuotas = new Text("valorCuotas",
            array('style' => 'text-align:right !important;height: 40px !important;font-size: 18px;',
                'placeholder' => 'Ingrese un número'));
        $valorCuotas->setLabel("<span class='problema'>(*)</span> Valor de Cuotas");
        $valorCuotas->setFilters(array('int'));
        $valorCuotas->addValidators(
            array(
                new PresenceOf(
                    array(
                        'message' => 'El <strong>Valor de las Cuotas</strong> es obligatorio.'
                    )
                ),
                new Numericality(
                    array(
                        'message' => 'Debe ser un valor númerico.'
                    )
                ),
                new NumberValidator()
            )
        );
        $this->add($valorCuotas);
        /*=================== OBSERVACIONES ==========================*/
        $comentarios = new \Phalcon\Forms\Element\TextArea("observacion",
            array(
                'maxlength' => 245,
                'placeholder' => 'Ingrese su observacion...',
                'rows' => '4', 'cols' => '50'
            ));
        $comentarios->setLabel('Observaciones');
        $comentarios->setFilters(array('string'));
        $this->add($comentarios);
    }

    /**
     * Prints messages for a specific element
     */
    public function messages($name)
    {
        $cadena = "";
        if ($this->hasMessagesFor($name)) {
            foreach ($this->getMessagesFor($name) as $message) {
                $cadena .= "<div class='problema'>" . $message . "</div>";//para mostrar con tooltip
            }
        }
        return $cadena;
    }
}