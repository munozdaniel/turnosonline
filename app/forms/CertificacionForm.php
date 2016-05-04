<?php
/**
 * Created by PhpStorm.
 * User: dmunioz
 * Date: 07/10/2015
 * Time: 13:30
 */
use Phalcon\Forms\Form;
use Phalcon\Forms\Element\Text;
use Phalcon\Validation\Validator\PresenceOf;
use Phalcon\Validation\Validator\Numericality;
class CertificacionForm extends Form {
    /**
     * Initialize the products form
     */
    public function initialize($entity = null, $options = array())
    {
        $nroDoc = new \Phalcon\Forms\Element\Numeric("nroDoc",array('style'=>'width:50%;height: 50px !important;font-size: 26px;','placeholder'=>' INGRESE SU Nº DE DOCUMENTO'));
        $nroDoc->setLabel("Nº Documento");
        $nroDoc->setFilters(array('int'));
        $nroDoc->addValidators(
            array(
                new PresenceOf(
                    array(
                        'message' => 'Ingrese su número de documento.'
                    )
                ),
                new Numericality(
                    array(
                        'message' => 'El DNI debe contener números unicamente.'
                    )
                )
            )
        );
        $this->add($nroDoc);
    }
    /**
     * Prints messages for a specific element
     */
    public function mensajeError($name)
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