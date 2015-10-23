<?php
use Phalcon\Forms\Form;
use Phalcon\Forms\Element\Text;
use Phalcon\Forms\Element\Date;
use Phalcon\Forms\Element\Select;

use Phalcon\Validation\Validator\PresenceOf;
use Phalcon\Validation\Validator\Numericality;
use Phalcon\Validation\Validator\StringLength as StringLength;

class TurnoManualForm extends Form
{
    public function initialize($entity = null, $options = array())
    {
        /*=================== Apellido ==========================*/
        $apellido = new Text("solicitudTurno_ape",array('style'=>'text-align:right !important;height: 40px !important; width: 300px !important; font-size: 18px;'));
        $apellido->setLabel("<strong>(*)</strong> Apellido: ");
        $apellido->setFilters(array('string'));
        $apellido->addValidators(
            array(
                new PresenceOf(
                    array(
                        'message' => 'Ingrese su <strong>Apellido </strong>.'
                    )
                ),
                new StringLength(array(
                    'min' => 4,
                    'messageMinimum' => 'Apellido demasiado corto.',
                    'max' => 30,
                    'messageMaximun' => 'Apellido demasiado largo.',
                )),
            )
        );
        $this->add($apellido);

        /*=================== Nombre ==========================*/
        $nombre = new Text("solicitudTurno_nom",array('style'=>'text-align:right !important;height: 40px !important;width: 300px !important;font-size: 18px;'));
        $nombre->setLabel("<strong>(*)</strong> Nombre: ");
        $nombre->setFilters(array('string'));
        $nombre->addValidators(
            array(
                new PresenceOf(
                    array(
                        'message' => 'Ingrese su <strong>Nombre</strong>.'
                    )
                ),
                new StringLength(array(
                    'min' => 4,
                    'messageMinimum' => 'Nombre demasiado corto',
                    'max' => 30,
                    'messageMaximun' => 'Nombre demasiado largo',
                )),
            )
        );
        $this->add($nombre);
        /*=================== Nro Legajo ==========================*/
        $legajo = new Text("solicitudTurno_legajo",array('style'=>'text-align:right !important;height: 40px !important;width: 300px !important;font-size: 18px;'));
        $legajo->setLabel("<strong>(*)</strong> Legajo: ");
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
                    'messageMinimum' => 'Minimo 4 digitos.',
                    'max' => 12,
                    'messageMaximun' => 'Maximo 12 digitos.',
                )),
            )
        );
        $this->add($legajo);

        /*=================== Nro Documento ==========================*/
        $dni = new Text("solicitudTurno_documento",array('style'=>'text-align:right !important;height: 40px !important;width: 300px !important;font-size: 18px;'));
        $dni->setLabel("<strong>(*)</strong> Nro Documento: ");
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
                    'messageMinimum' => 'Minimo 4 digitos.',
                    'max' => 12,
                    'messageMaximun' => 'Maximo 12 digitos.',
                ))
            )
        );
        $this->add($dni);

        /*=================== Fecha Nacimiento ==========================*/
        $fechaNacimiento= new Date('solicitudTurno_fechaNacimiento',array('style'=>'text-align:right !important;width: 300px !important;'));
        $fechaNacimiento->setLabel('<strong>(*)</strong> Fecha Nacimiento:');
        $fechaNacimiento->addValidators(array(
            new PresenceOf(array(
                'message' => 'Ingrese la <strong>Fecha de Nacimiento</strong>.'
            ))
        ));
        $this->add($fechaNacimiento);

        /*=================== Nro Telefono ==========================*/
        $telefono = new Text("solicitudTurno_numTelefono",array('style'=>'text-align:right !important;height: 40px !important;width: 300px !important;font-size: 18px;'));
        $telefono->setLabel("<strong>(*)</strong> N&uacute;mero de telefono/celular (c&oacute;digo de &aacute;rea y n&uacute;mero):");
        $telefono->setFilters(array('int'));
        $telefono->addValidators(
            array(
                new PresenceOf(array(
                    'message' => 'El telefono  es requerido.'
                )),
                new Numericality( array(
                        'message' => 'El <strong>Telefono</strong> debe ser un número sin puntos ni coma.'
                    )
                ),
                new NumberValidator(),
                new StringLength(array(
                    'min' => 6,
                    'messageMinimum' => 'Minimo 6 digitos.',
                    'max' => 14,
                    'messageMaximun' => 'Maximo 14 digitos.',
                )),
            )
        );
        $this->add($telefono);

        /*=================== Repita su telefono  ==========================*/

        $telefonoBis = new Text("telefonoRepetido",array('style'=>'text-align:right !important;height: 40px !important;width: 300px !important;font-size: 18px;'));
        $telefonoBis->setLabel("<strong>(*)</strong> Repita su n&uacute;mero de telefono/celular:");
        $telefonoBis->setFilters(array('int'));
        $telefonoBis->addValidators(
            array(
                new PresenceOf(array(
                    'message' => 'El telefono  es requerido.'
                )),
                new Numericality( array(
                        'message' => 'El <strong>Telefono</strong> debe ser un número sin puntos ni coma.'
                    )
                ),
                new NumberValidator(),
                new StringLength(array(
                    'min' => 6,
                    'messageMinimum' => 'Minimo 6 digitos.',
                    'max' => 14,
                    'messageMaximun' => 'Maximo 14 digitos.',
                )),
                new ComprobarTelefonoValidator(array('telefono'=>$telefono))
            )
        );
        $this->add($telefonoBis);

        /*=================== Estado ==========================*/
         $estado = new Select("solicitudTurno_estado",array(''=>'','autorizado'=>'autorizado','denegado'=>'denegado'));
         $estado->setLabel('Estado de la solicitud:');
         $estado->addValidators(array(
             new PresenceOf(array(
                 'message' => 'El estado es requerido.'
             ))
         ));

         $this->add($estado);
    }

    //muestra un mensaje por cada elemento
    public function messages($name)
    {
        $cadena= "";
        if ($this->hasMessagesFor($name))
        {
            foreach ($this->getMessagesFor($name) as $message)
            {
                $cadena.= "<div class='problema'>".$message ."</div>";//para mostrar con tooltip
            }
        }
        return $cadena;
    }
}
