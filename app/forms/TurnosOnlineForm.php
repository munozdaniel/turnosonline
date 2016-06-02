<?php
/**
 * Created by PhpStorm.
 * User: Daniel
 * Date: 12/10/2015
 * Time: 08:34 PM
 */
use Phalcon\Forms\Form;
use Phalcon\Forms\Element\Text;
use Phalcon\Validation\Validator\PresenceOf;
use \Phalcon\Forms\Element\Date;
use Phalcon\Validation\Validator\Numericality;
use Phalcon\Validation\Validator\StringLength as StringLength;
use Phalcon\Validation\Validator\Email;
use Phalcon\Validation\Validator\Regex;

class TurnosOnlineForm extends Form
{
    /**
     * Initialize the products form
     */
    public function initialize($entity = null, $options = array())
    {
        /*=================== Apellido ==========================*/

        $apellido = new Text("solicitudTurno_ape",
            array('style' => 'text-align:right !important; font-size: 18px;',
                'placeholder' => 'APELLIDO',
                'class' => 'form-control',
                'autocomplete' => 'off', 'required' => true));
        $apellido->setLabel("<strong style='color: red'>*</strong> Apellido:");
        $apellido->setFilters(array('string'));
        $apellido->addValidators(
            array(
                new PresenceOf( array('message' => 'Ingrese su <strong>apellido</strong>.')),
                new StringLength(array(
                    'min' => 3,
                    'max' => 30,
                    'messageMinimum' => 'El apellido es demasiado corto.',
                    'messageMaximun' => 'El apellido es demasiado largo.',
                )),
            ));

        $this->add($apellido);

        /*=================== Nombre ==========================*/

        $nombre = new Text("solicitudTurno_nom",
            array('style' => 'text-align:right !important;font-size: 18px;',
                'placeholder' => 'NOMBRE',
                'class' => 'form-control',
                'autocomplete' => 'off', 'required' => true));

        $nombre->setLabel("<strong style='color: red'>*</strong> Nombre: ");
        $nombre->setFilters(array('string'));
        $nombre->addValidators(
            array(
                new PresenceOf(array('message' => 'Ingrese su <strong>nombre</strong>.')),
                new StringLength(array(
                    'min' => 3,
                    'max' => 30,
                    'messageMinimum' => 'El nombre es demasiado corto.',
                    'messageMaximun' => 'El nombre es demasiado largo.',
                )),
            ));
        $this->add($nombre);

        /*=================== Nro Legajo ==========================*/

        $legajo = new Text("solicitudTurno_legajo",
            array('style' => 'text-align:right !important;font-size: 18px;',
                'placeholder' => 'LEGAJO',
                'class' => 'form-control',
                'autocomplete' => 'off', 'required' => true));

        $legajo->setLabel("<strong style='color: red'>*</strong> Legajo: ");
        $legajo->setFilters(array('int'));
        $legajo->addValidators(
            array
            (
                new PresenceOf(array('message' => 'Ingrese el <strong>legajo</strong>.')),
                new Regex(array(
                    'message'=>'El valor ingresado debe ser un <strong>legajo</strong> v&aacute;lido.',
                    'pattern' =>'/^[1-9][0-9]([0-9]{0,4})$/')),
                /*  La expresion regular se lee asi: el string debe comenzar(^) con un numero entre 1-9, seguidamente debe aparecer 1 vez
                    un numero entre 0-9 y culminar($) con un numero entre 0-9 que puede
                    aparecer entre 0 y 4 veces (no necesariamente el mismo numero)*/
                new LegajoValidator(),
            ));

        $this->add($legajo);

        /*=================== Nro Documento ==========================*/

        $dni = new Text("solicitudTurno_documento",
            array('style' => 'text-align:right !important;font-size: 18px;',
                'placeholder' => 'NRO DOCUMENTO',
                'class' => 'form-control',
                'autocomplete' => 'off', 'required' => true));
        $dni->setLabel("<strong style='color: red'>*</strong> Nro Documento (SIN puntos ni comas): ");
        $dni->setFilters(array('int'));
        $dni->addValidators(
            array(
                new PresenceOf(array('message' => 'Ingrese el <strong>nro de documento.</strong>.')),
                new Regex(array(
                    'message'=>'El valor ingresado debe ser un <strong>nro de documento</strong> v&aacute;lido.',
                    'pattern' =>'/^[1-9][0-9][0-9][0-9]([0-9]{1,6})$/')),
            ));
        $this->add($dni);

        /*=================== Fecha Nacimiento ==========================*/

        $fechaNacimiento = new Date('solicitudTurno_fechaNacimiento',
            array('style' => 'text-align:right !important;font-size: 18px;',
                'class' => 'form-control', 'required' => true));
        $fechaNacimiento->setLabel("<strong style='color: red'>*</strong> Fecha Nacimiento:");
        $fechaNacimiento->addValidators(array(
            new PresenceOf(array('message' => 'Ingrese la <strong>fecha de nacimiento</strong>.')),
        ));
        $this->add($fechaNacimiento);

        /*=================== Nro Telefono ==========================*/

        $telefono = new Text("solicitudTurno_numTelefono",
            array('style' => 'text-align:right !important;font-size: 18px;',
                'placeholder' => 'TELEFONO',
                'class' => 'form-control',
                'autocomplete' => 'off', 'required' => true));
        $telefono->setLabel("<strong style='color: red'>*</strong> N&uacute;mero de telefono/celular (SIN puntos):");
        $telefono->setFilters(array('int'));
        $telefono->addValidators(
            array(
                new PresenceOf(array('message' => 'Ingrese el <strong>n&uacute;mero</strong>.')),
                new Regex(array(
                    'message'=>'El valor ingresado debe ser un <strong>n&uacute;mero</strong> v&aacute;lido.',
                    'pattern' =>'/^[0-9][0-9][0-9][0-9][0-9]([0-9]{1,10})$/')),
            ));
        $this->add($telefono);

        /*=================== Correo Electronico ==========================*/

        //Si es manual, el email es opcional. (SE ELIMINARON LAS SOLICITUDES MANUALES)
        if (!isset($options['manual'])) {
            $requerido = "required";
            $asterisco = "<strong style='color: red'>*</strong>";
        } else {
            $asterisco = "";
            $requerido = "unrequired";//En las solicitudes manuales el correo no es requerido.
        }

        $email = new \Phalcon\Forms\Element\Email('solicitudTurno_email',
            array('style' => 'text-align:right !important;font-size: 18px;',
                'placeholder' => 'EMAIL',
                'class' => 'form-control',
                'autocomplete' => 'off', $requerido => true));
        $email->setLabel("$asterisco Email:");

        if (!isset($options['manual']))
        {
            $email->addValidators(array(
                new PresenceOf(array('message' => 'El email es requerido.')),
                new Email(array('message' => 'El email no es válido.')),
            ));
        }
        $this->add($email);

        /*=================== Repita su Correo Electronico ==========================*/

        //Si es Manual no es necesario repetir el email.
        if (!isset($options['manual']))
        {
            $confirmarEmail = new \Phalcon\Forms\Element\Email('emailRepetido',
                array('style' => 'text-align:right !important;font-size: 18px;',
                    'placeholder' => 'REPITA EL EMAIL',
                    'class' => 'form-control',
                    'autocomplete' => 'off', 'required' => true));
            $confirmarEmail->setLabel("<strong style='color: red'>*</strong> Repita el Email:");
            $confirmarEmail->addValidators(array(
                new PresenceOf(array('message' => 'El email es requerido')),
                new Email(array('message' => 'El email no es válido.')),
                new ComprobarEmailValidator(array('email' => $email)),
            ));

            $this->add($confirmarEmail);
        }
    }

    //muestra un mensaje por cada elemento
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