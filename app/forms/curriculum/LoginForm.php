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
    Phalcon\Forms\Element\Password,
    Phalcon\Forms\Element\Submit,
    Phalcon\Forms\Element\Hidden,
    Phalcon\Validation\Validator\PresenceOf,
    Phalcon\Validation\Validator\Email,
    Phalcon\Validation\Validator\Identical;

class LoginForm  extends Form
{

    public function initialize()
    {
        //añadimos el campo email
        $email = new Text('email', array(
            'placeholder' => 'Email'
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
        $password = new Password('password', array(
            'placeholder' => 'Password'
        ));

        //añadimos la validación como campo requerido al password
        $password->addValidator(
            new PresenceOf(array(
                'message' => 'El password es requerido'
            ))
        );

        //label para el Password
        $password->setLabel('Password');

        //hacemos que se pueda llamar a nuestro campo password
        $this->add($password);

        //prevención de ataques csrf, genera un campo de este tipo
        //<input value="dcf7192995748a80780b9cc99a530b58" name="csrf" id="csrf" type="hidden" />
        $csrf = new Hidden('csrf');

        //añadimos la validación para prevenir csrf
        $csrf->addValidator(
            new Identical(array(
                'value' => $this->security->getSessionToken(),
                'message' => '¡La validación CSRF ha fallado!'
            ))
        );

        //hacemos que se pueda llamar a nuestro campo csrf
        $this->add($csrf);

        //añadimos un botón de tipo submit
        $submit = $this->add(new Submit('Login', array(
            'class' => 'btn btn-success'
        )));
    }

}