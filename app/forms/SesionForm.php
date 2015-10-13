<?php
/**
 * Created by PhpStorm.
 * User: dmunioz
 * Date: 09/10/2015
 * Time: 9:10
 */
use Phalcon\Forms\Form;
use Phalcon\Forms\Element\Text;
use Phalcon\Validation\Validator\PresenceOf;
use Phalcon\Forms\Element\Password;
class SesionForm extends Form {
    /**
     * Initialize the products form
     */
    public function initialize($entity = null, $options = array())
    {
        $usuario = new Text('sesion_usuario',array(
            'class'         =>'form-control',
            'placeholder'   =>'Usuario',
            'required'      =>'',
            'autofocus'     =>''
        ));
        //añadimos la validación como campo requerido al password
        $usuario->addValidator(
            new PresenceOf(array(
                'message' => 'El usuario es requerido'
            ))
        );
        $this->add($usuario);

        /*==================================================*/
        //añadimos el campo password
        $password = new Password('sesion_password', array(
            'placeholder' => 'Contraseña',
            'required'=>'',
            'class'=>'form-control'
        ));

        //añadimos la validación como campo requerido al password
        $password->addValidator(
            new PresenceOf(array(
                'message' => 'El password es requerido'
            ))
        );

        //hacemos que se pueda llamar a nuestro campo password
        $this->add($password);
        /*==================================================*/

        //añadimos el campo email
        $email = new Text('email', array(
            'placeholder' => 'Email'
        ));

        //añadimos la validación para un campo de tipo email y como campo requerido
        $email->addValidators(array(
            new PresenceOf(array(
                'message' => 'El email es requerido'
            )),
            new \Phalcon\Validation\Validator\Email(array(
                'message' => 'El email no es válido'
            ))
        ));
        //label para el email
        $email->setLabel('Email');

        //hacemos que se pueda llamar a nuestro campo email
        $this->add($email);

        /*==================================================*/
        //añadimos un botón de tipo submit
        $ingresar = new \Phalcon\Forms\Element\Submit('Ingresar', array(
            'class' => 'btn btn-lg btn-primary btn-block'
        ));
        $this->add($ingresar);

        /*==================================================*/
        //añadimos un botón de tipo submit
        $ingresar = new \Phalcon\Forms\Element\Submit('Solicitar', array(
            'class' => 'subscr_btn btn-theme'
        ));
        $this->add($ingresar);
    }

    /**
     * @param $name
     * @return string
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