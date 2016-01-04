<?php
/**
 *
 * Permite crear un formulario para ingresar a los curriculum.
 * User: dmunioz
 * Date: 29/12/2015
 * Time: 11:41
 */
use Phalcon\Forms\Form,
    Phalcon\Forms\Element\Text,
    Phalcon\Forms\Element\Submit,
    Phalcon\Validation\Validator\PresenceOf,
    Phalcon\Validation\Validator\Email;

class LoginForm  extends Form
{

    public function initialize()
    {
        //añadimos el campo email
        $email = new Text('email', array(
            'placeholder' => 'ejemplo@imps.org.ar', 'class'=>'sr-only'
        ));

        //añadimos la validación para un campo de tipo email y como campo requerido
        $email->addValidators(array(
            new PresenceOf(array(
                'message' => 'El email es requerido'
            )),
            new Email(array(
                'message' => 'El email no es válido'
            ))
        ));

        //label para el email
        $email->setLabel('Email');

        //hacemos que se pueda llamar a nuestro campo email
        $this->add($email);

        //añadimos el campo password
        $nroDocumento = new Text('nroDocumento', array(
            'placeholder' => 'Ingrese su Documento', 'type'=>'number', 'class'=>'sr-only'
        ));

        //añadimos la validación como campo requerido al password
        $nroDocumento->addValidator(
            new PresenceOf(array(
                'message' => 'El Nº de Documento es requerido'
            ))
        );

        //label para el Password
        $nroDocumento->setLabel('Nro Documento');

        //hacemos que se pueda llamar a nuestro campo password
        $this->add($nroDocumento);



        //añadimos un botón de tipo submit
        $submit = $this->add(new Submit('BUSCAR CURRICULUM', array(
            'class' => 'btn btn-success btn-large'
        )));
    }

}