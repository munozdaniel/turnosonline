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
        /*=================== Nro Legajo ==========================*/
        $legajo = new Text("legajo",array('style'=>'text-align:right !important;height: 40px !important;font-size: 18px;','placeholder'=>' INGRESE SU LEGAJO'));

        $legajo->setLabel("Legajo ");
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
        $dni = new Text("dni",array('style'=>'text-align:right !important;height: 40px !important;font-size: 18px;','placeholder'=>' INGRESE SU NRO DOCUMENTO'));
        $dni->setLabel("Nro Documento ");
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
        $fechaNacimiento= new Date('fechaNacimiento');
        $fechaNacimiento->setLabel('Fecha Nacimiento');
        $fechaNacimiento->addValidators(array(
            new PresenceOf(array(
                'message' => 'Ingrese la <strong>Fecha de Nacimiento</strong>.'
            ))
        ));
        $this->add($fechaNacimiento);
        /*=================== Correo Electronico ==========================*/
        $email = new Text('email', array('style'=>'text-align:right !important;height: 40px !important;font-size: 18px;',
            'placeholder' => 'Ingrese el Email'
        ));

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
        $email = new Text('emailRepetido', array('style'=>'text-align:right !important;height: 40px !important;font-size: 18px;',
            'placeholder' => 'Ingrese nuevamente el Email'
        ));

        $email->addValidators(array(
            new PresenceOf(array(
                'message' => 'El Email es requerido'
            )),
            new Email(array(
                'message' => 'El Email no es valido.'
            ))
        ));

        $this->add($email);

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