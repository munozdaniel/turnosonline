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
        /*=================== ESTADO ==========================*/
       // $select = new SelectElement('miSelect', array('pendiente' => 'PENDIENTE', 'revision' => 'REVISION', 'autorizado' => 'AUTORIZADO', 'denegado' => 'DENEGADO', 'faltaTurno' => 'DENEGADO POR FALTA DE TURNOS'));
        //$select->setLabel('MI SELECT');
        //$this->add($select);

            /*=================== MONTO MAXIMO ==========================*/
            $montoMaximo = new Text("montoMaximo",
                array('style' => 'text-align:right !important;height: 40px !important;font-size: 18px;',
                    'placeholder' => 'INGRESE EL MONTO MAXIMO'));
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
                    'placeholder' => 'INGRESE EL MONTO POSIBLE'));
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
                    'placeholder' => 'INGRESE LA CANTIDAD DE CUOTAS'));
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

            /*=================== VALOR DE CUOTAS ==========================*/
            $valorCuotas = new Text("valorCuotas",
                array('style' => 'text-align:right !important;height: 40px !important;font-size: 18px;',
                    'placeholder' => 'INGRESE EL VALOR DE LAS CUOTAS'));
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
                    'placeholder' => 'ESCRIBIR AQUI...',
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