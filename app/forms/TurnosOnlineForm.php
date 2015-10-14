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

class TurnosOnlineForm  extends Form {
    /**
     * Initialize the products form
     */
    public function initialize($entity = null, $options = array())
    {
        /*=================== Nombre y Apellido ==========================*/
        $nombre = new Text("solicitudTurno_nomApe",array('style'=>'text-align:right !important;height: 40px !important;font-size: 18px;','placeholder'=>'APELLIDO Y NOMBRE'));

        $nombre->setLabel("<strong>(*)</strong> Apellido y Nombre ");
        $nombre->setFilters(array('string'));
        $nombre->addValidators(
            array(
                new PresenceOf(
                    array(
                        'message' => 'Ingrese su <strong>Apellido y Nombre</strong>.'
                    )
                ),
                new StringLength(array(
                    'min' => 6,
                    'messageMinimum' => 'Nombre demasiado corto',
                    'max' => 30,
                    'messageMaximun' => 'Nombre demasiado largo',
                )),
            )
        );
        $this->add($nombre);
        /*=================== Nro Legajo ==========================*/
        $legajo = new Text("solicitudTurno_legajo",array('style'=>'text-align:right !important;height: 40px !important;font-size: 18px;','placeholder'=>'LEGAJO'));

        $legajo->setLabel("<strong>(*)</strong> Legajo ");
        $legajo->setFilters(array('int'));
        $legajo->addValidators(
            array(
                new PresenceOf(
                    array(
                        'message' => 'Ingrese el <strong>Legajo</strong>.'
                    )
                ),
                new Numericality(
                    array(
                        'message' => 'El <strong>Legajo</strong> debe ser un número sin puntos ni coma.'
                    )
                ),
                new NumberValidator(),
                new StringLength(array(
                    'min' => 4,
                    'messageMinimum' => 'Minimo 4 digitos',
                    'max' => 12,
                    'messageMaximun' => 'Maximo 12 digitos',
                )),
            )
        );
        $this->add($legajo);
        /*=================== Nro Documento ==========================*/
        $dni = new Text("solicitudTurno_documento",array('style'=>'text-align:right !important;height: 40px !important;font-size: 18px;','placeholder'=>'NRO DOCUMENTO'));
        $dni->setLabel("<strong>(*)</strong> Nro Documento ");
        $dni->setFilters(array('int'));
        $dni->addValidators(
            array(
                new PresenceOf(
                    array(
                        'message' => 'Ingrese el <strong>DNI</strong>.'
                    )
                ),
                new Numericality(
                    array(
                        'message' => 'El <strong>DNI</strong> debe ser un número sin puntos ni coma.'
                    )
                ),
                new NumberValidator(),
                new StringLength(array(
                    'min' => 4,
                    'messageMinimum' => 'Minimo 4 digitos',
                    'max' => 12,
                    'messageMaximun' => 'Maximo 12 digitos',
                ))
            )
        );
        $this->add($dni);
        /*=================== Fecha Nacimiento ==========================*/
        $fechaNacimiento= new Date('solicitudTurno_fechaNacimiento',array('style'=>'text-align:right !important'));
        $fechaNacimiento->setLabel('<strong>(*)</strong> Fecha Nacimiento');
        $fechaNacimiento->addValidators(array(
            new PresenceOf(array(
                'message' => 'Ingrese la <strong>Fecha de Nacimiento</strong>.'
            ))
        ));
        $this->add($fechaNacimiento);
        /*=================== Nro Legajo ==========================*/
        $telefono = new Text("solicitudTurno_numTelefono",array('style'=>'text-align:right !important;height: 40px !important;font-size: 18px;','placeholder'=>'TELEFONO'));

        $telefono->setLabel("Telefono ");
        $telefono->setFilters(array('int'));
        $telefono->addValidators(
            array(
                new Numericality(
                    array(
                        'message' => 'El <strong>Telefono</strong> debe ser un número sin puntos ni coma.'
                    )
                ),
                new NumberValidator(),
                new StringLength(array(
                    'min' => 4,
                    'messageMinimum' => 'Minimo 4 digitos',
                    'max' => 12,
                    'messageMaximun' => 'Maximo 12 digitos',
                )),
            )
        );
        $this->add($telefono);
        /*=================== Correo Electronico ==========================*/
        $email = new \Phalcon\Forms\Element\Email('solicitudTurno_email', array('style'=>'text-align:right !important;height: 40px !important;font-size: 18px;',
            'placeholder' => 'EMAIL'
        ));
        $email->setLabel('<strong>(*)</strong> Email');
        $email->addValidators(array(
            new PresenceOf(array(
                'message' => 'El Email es requerido'
            )),
            new Email(array(
                'message' => 'El Email no es Valido.'
            ))
        ));

        $this->add($email);
        /*=================== Repita su Correo Electronico ==========================*/
        $confirmarEmail = new \Phalcon\Forms\Element\Email('emailRepetido', array('style'=>'text-align:right !important;height: 40px !important;font-size: 18px;',
            'placeholder' => 'REPITA EL EMAIL'
        ));

        $confirmarEmail->setLabel('<strong>(*)</strong> Repetir Email');
        $confirmarEmail->addValidators(array(
            new PresenceOf(array(
                'message' => 'El Email es requerido'
            )),
            new Email(array(
                'message' => 'El Email no es valido.'
            )),
            new ComprobarEmailValidator(array('email'=>$email))
        ));

        $this->add($confirmarEmail);

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