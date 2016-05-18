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
                new PresenceOf(
                    array(
                        'message' => 'Ingrese su <strong>Apellido </strong>.'
                    )
                ),
                new StringLength(array(
                    'min' => 3,
                    'messageMinimum' => 'El apellido es demasiado corto.',
                    'max' => 30,
                    'messageMaximun' => 'El apellido es demasiado largo.',
                )),
            )
        );
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
                new PresenceOf(
                    array(
                        'message' => 'Ingrese su <strong>Nombre</strong>.'
                    )
                ),
                new StringLength(array(
                    'min' => 3,
                    'messageMinimum' => 'El nombre es demasiado corto.',
                    'max' => 30,
                    'messageMaximun' => 'El nombre es demasiado largo.',
                )),
            )
        );
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
            array(
                new PresenceOf(
                    array(
                        'message' => 'Ingrese el <strong>legajo</strong>.'
                    )
                ),
                new Numericality(
                    array(
                        'message' => 'El <strong>legajo</strong> debe ser un número sin puntos ni coma.'
                    )
                ),
                new NumberValidator(),
                new StringLength(array(
                    'min' => 4,
                    'messageMinimum' => 'El legajo debe tener como minimo 4 digitos.',
                    'max' => 12,
                    'messageMaximun' => 'El legajo debe tener como maximo 12 digitos.',
                )),
            )
        );
        $this->add($legajo);
        /*=================== Nro Documento ==========================*/
        $dni = new Text("solicitudTurno_documento",
            array('style' => 'text-align:right !important;font-size: 18px;',
                'placeholder' => 'NRO DOCUMENTO',
                'class' => 'form-control',
                'autocomplete' => 'off', 'required' => true));
        $dni->setLabel("<strong style='color: red'>*</strong> Nro Documento: ");
        $dni->setFilters(array('int'));
        $dni->addValidators(
            array(
                new PresenceOf(
                    array(
                        'message' => 'Ingrese el <strong>nro de documento.</strong>.'
                    )
                ),
                new Numericality(
                    array(
                        'message' => 'El <strong>nro de documento</strong> no debe tener puntos.'
                    )
                ),
                new NumberValidator(),
                new StringLength(array(
                    'min' => 4,
                    'messageMinimum' => 'El nro de documento debe tener como minimo 4 digitos.',
                    'max' => 12,
                    'messageMaximun' => 'El nro de documento debe tener como maximo 12 digitos.',
                ))
            )
        );
        $this->add($dni);
        /*=================== Fecha Nacimiento ==========================*/
        $fechaNacimiento = new Date('solicitudTurno_fechaNacimiento',
            array('style' => 'text-align:right !important;font-size: 18px;',
                'class' => 'form-control', 'required' => true));
        $fechaNacimiento->setLabel("<strong style='color: red'>*</strong> Fecha Nacimiento:");
        $fechaNacimiento->addValidators(array(
            new PresenceOf(array(
                'message' => 'Ingrese la <strong>fecha de nacimiento</strong>.'
            ))
        ));
        $this->add($fechaNacimiento);
        /*=================== Nro Telefono ==========================*/
        $telefono = new Text("solicitudTurno_numTelefono",
            array('style' => 'text-align:right !important;font-size: 18px;',
                'placeholder' => 'TELEFONO',
                'class' => 'form-control',
                'autocomplete' => 'off', 'required' => true));
        $telefono->setLabel("<strong style='color: red'>*</strong> N&uacute;mero de telefono/celular:");
        $telefono->setFilters(array('int'));
        $telefono->addValidators(
            array(
                new PresenceOf(
                    array(
                        'message' => 'Ingrese el <strong>n&uacute;mero de telefono/celular.</strong>.'
                    )
                ),
                new Numericality(
                    array(
                        'message' => 'El <strong>n&uacute;mero</strong> no debe tener puntos ni comas.'
                    )
                ),
                new NumberValidator(),
                new StringLength(array(
                    'min' => 6,
                    'messageMinimum' => 'El numero de telefono debe tener como minimo 6 digitos.',
                    'max' => 14,
                    'messageMaximun' => 'El numero de telefono debe tener como maximo 14 digitos.',
                )),
            )
        );
        $this->add($telefono);

        /*=================== Correo Electronico ==========================*/
        //Si es manual, el email es opcional.
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
        if (!isset($options['manual'])) {

            $email->addValidators(array(
                new PresenceOf(array(
                    'message' => 'El email es requerido.'
                )),
                new Email(array(
                    'message' => 'El email no es válido.'
                ))
            ));
        }
        $this->add($email);
        /*=================== Repita su Correo Electronico ==========================*/
        //Si es Manual no es necesario repetir el email.
        if (!isset($options['manual'])) {


            $confirmarEmail = new \Phalcon\Forms\Element\Email('emailRepetido',
                array('style' => 'text-align:right !important;font-size: 18px;',
                    'placeholder' => 'REPITA EL EMAIL',
                    'class' => 'form-control',
                    'autocomplete' => 'off', 'required' => true));
            $confirmarEmail->setLabel("<strong style='color: red'>*</strong> Repita el Email:");
            $confirmarEmail->addValidators(array(
                new PresenceOf(array(
                    'message' => 'El email es requerido'
                )),
                new Email(array(
                    'message' => 'El email no es válido.'
                )),
                new ComprobarEmailValidator(array('email' => $email))
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