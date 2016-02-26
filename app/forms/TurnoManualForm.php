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

        $disable = array();
        if (isset($options['disabled'])) {
            $disable['key']='disabled';
            $disable['value']='true';
        } else {
            $disable['key']='';
            $disable['value']='';
        }

        /*=================== Apellido ==========================*/
        $apellido = new Text("solicitudTurno_ape",
            array('style'=>'text-align:right !important; font-size: 18px;',
                'class'=>'form-control',
                'autocomplete'=>'off',
                'required'=>'',$disable['key']=>$disable['value'],
                'placeholder'=>'INGRESE EL APELLIDO'));
        $apellido->setLabel("<strong style='color:red'>*</strong> Apellido: ");
        $apellido->setFilters(array('string'));
        $apellido->addValidators(
            array(
                new PresenceOf(
                    array(
                        'message' => 'Ingrese su <strong>apellido </strong>.'
                    )
                ),
                new StringLength(array(
                    'min' => 4,
                    'messageMinimum' => 'El apellido es emasiado corto.',
                    'max' => 30,
                    'messageMaximun' => 'El apellido es demasiado largo.',
                )),
            )
        );
        $this->add($apellido);

        /*=================== Nombre ==========================*/
        $nombre = new Text("solicitudTurno_nom",
            array('style'=>'text-align:right !important;font-size: 18px;',
                'class'=>'form-control',
                'autocomplete'=>'off',
                'required'=>'',$disable['key']=>$disable['value'],
                'placeholder'=>'INGRESE EL NOMBRE COMPLETO'));
        $nombre->setLabel("<strong style='color:red'>*</strong> Nombre: ");
        $nombre->setFilters(array('string'));
        $nombre->addValidators(
            array(
                new PresenceOf(
                    array(
                        'message' => 'Ingrese su <strong>nombre</strong>.'
                    )
                ),
                new StringLength(array(
                    'min' => 4,
                    'messageMinimum' => 'El nombre es demasiado corto.',
                    'max' => 30,
                    'messageMaximun' => 'El nombre es demasiado largo.',
                )),
            )
        );
        $this->add($nombre);
        /*=================== Nro Legajo ==========================*/
        $legajo = new Text("solicitudTurno_legajo",
            array('style'=>'text-align:right !important;font-size: 18px;',
                'class'=>'form-control',
                'autocomplete'=>'off',
                'required'=>'',$disable['key']=>$disable['value'],
                'placeholder'=>'INGRESE EL LEGAJO'));
        $legajo->setLabel("<strong style='color:red'>*</strong> Legajo: ");
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
                        'message' => 'El <strong>legajo</strong> debe ser un n&uacute;mero sin puntos ni comas.'
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
            array('style'=>'text-align:right !important;font-size: 18px;',
                'class'=>'form-control',
                'autocomplete'=>'off',
                'required'=>'',$disable['key']=>$disable['value'],
                'placeholder'=>'INGRESE EL NRO DOCUMENTO'));
        $dni->setLabel("<strong style='color:red'>*</strong> Nro Documento: ");
        $dni->setFilters(array('int'));
        $dni->addValidators(
            array(
                new PresenceOf(
                    array(
                        'message' => 'Ingrese el <strong>nro de documento</strong>.'
                    )
                ),
                new Numericality(
                    array(
                        'message' => 'El <strong>nro de documento</strong> no debe tener puntos ni comas.'
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

        /*=================== Nro Telefono ==========================*/
        $telefono = new Text("solicitudTurno_numTelefono",
            array('style'=>'text-align:right !important;font-size: 18px;',
                'class'=>'form-control',
                'autocomplete'=>'off',
                'required'=>'',$disable['key']=>$disable['value'],
                'placeholder'=>'INGRESE NRO TELEFONO'));
        $telefono->setLabel("<strong style='color:red'>*</strong> N&uacute;mero de telefono/celular:");
        $telefono->setFilters(array('int'));
        $telefono->addValidators(
            array(
                new PresenceOf(array(
                    'message' => 'El nro de telefono es requerido.'
                )),
                new Numericality( array(
                        'message' => 'El <strong>nro de telefono</strong> no debe tener puntos ni comas.'
                    )
                ),
                new NumberValidator(),
                new StringLength(array(
                    'min' => 6,
                    'messageMinimum' => 'El nro de telefono debe tener como minimo 6 digitos.',
                    'max' => 14,
                    'messageMaximun' => 'El nro de telefono debe tener como maximo 14 digitos.',
                )),
            )
        );
        $this->add($telefono);

        /*=================== Repita su telefono  ==========================*/

        $telefonoBis = new Text("telefonoRepetido",
            array('style'=>'text-align:right !important;font-size: 18px;',
                'class'=>'form-control',
                'autocomplete'=>'off',
                'required'=>'',$disable['key']=>$disable['value'],
                'placeholder'=>'REPITA NRO TELEFONO'));
        $telefonoBis->setLabel("<strong style='color:red'>*</strong> Repita su n&uacute;mero:");
        $telefonoBis->setFilters(array('int'));
        $telefonoBis->addValidators(
            array(
                new PresenceOf(array(
                    'message' => 'El nro de telefono  es requerido.'
                )),
                new Numericality( array(
                        'message' => 'El <strong>nro de telefono</strong> no debe tener puntos ni comas.'
                    )
                ),
                new NumberValidator(),
                new StringLength(array(
                    'min' => 6,
                    'messageMinimum' => 'El nro de telefono debe tener como minimo 6 digitos.',
                    'max' => 14,
                    'messageMaximun' => 'El nro de telefono debe tener como maximo 14 digitos.',
                )),
                new ComprobarTelefonoValidator(array('telefono'=>$telefono))
            )
        );
        $this->add($telefonoBis);

        /*=================== Fecha Nacimiento ==========================*/
        $fechaNacimiento= new Date('solicitudTurno_fechaNacimiento',
            array('style'=>'text-align:right !important;',
                'class'=>'form-control',
                'autocomplete'=>'off',$disable['key']=>$disable['value']));
        $fechaNacimiento->setLabel("<strong style='color:red'>*</strong> Fecha Nacimiento:");
        $fechaNacimiento->addValidators(array(
            new PresenceOf(array(
                'message' => 'Ingrese la <strong>Fecha de Nacimiento</strong>.'
            ))
        ));
        $this->add($fechaNacimiento);


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
