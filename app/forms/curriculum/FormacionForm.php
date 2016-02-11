<?php
/**
 * Created by PhpStorm.
 * User: dmunioz
 * Date: 18/01/2016
 * Time: 9:03
 */
use Phalcon\Forms\Form;
use Phalcon\Forms\Element\Text;
use Phalcon\Forms\Element\TextArea;
use Phalcon\Validation\Validator\PresenceOf;
use \Phalcon\Forms\Element\Date;
use \Phalcon\Forms\Element\Email;
use Phalcon\Forms\Element\Check;
use \Phalcon\Forms\Element\Select;

class FormacionForm extends Form {
    /**
     * Inicializar el formulario formacion
     */
    public function initialize($entity = null, $options = array())
    {
        if (!isset($options['edit'])) {

            $elemento = new Text("formacion_id");
            $this->add($elemento->setLabel("Id"));
        } else {
            $this->add(new \Phalcon\Forms\Element\Hidden("formacion_id"));
        }
        /*========================== ==========================*/
        $elemento = new Text('formacion_institucion',array('maxlength'=>50,'class'=>'form-control','required'=>'true','placeholder'=>'Ingrese el nombre de la institución'));
        $elemento->setLabel('<strong class="font-rojo "> * </strong>Institución');
        $elemento->setFilters(array('striptags', 'string'));
        $elemento->addValidators(array(
            new PresenceOf(array(
                'message' => 'El nombre de la institución es requerido'
            ))
        ));
        $this->add($elemento);
        /*========================== ==========================*/
        $elemento = new Select('formacion_gradoId',  \Curriculum\Grado::find(), array(
            'using'      => array('grado_id', 'grado_nombre'),
            'useEmpty'   => true,
            'emptyText'  => 'Seleccionar ',
            'emptyValue' => '',
            'class'=>'form-control','required'=>'true'
        ));
        $elemento->addValidators(array(
            new PresenceOf(array(
                'message' => 'Seleccione el nivel'
            ))
        ));
        $elemento->setLabel('<strong class="font-rojo "> * </strong>Nivel');
        $this->add($elemento);
        /*========================== ==========================*/
        $elemento = new Text('formacion_titulo',array('maxlength'=>50,'class'=>'form-control','placeholder'=>'Ingrese el nombre del Titulo','required'=>'true'));
        $elemento->setLabel('<strong class="font-rojo "> * </strong>Titulo');
        $elemento->setFilters(array('striptags', 'string'));
        $this->add($elemento);
        /*========================== ==========================*/
        $elemento = new Select('formacion_estadoId',  \Curriculum\Estado::find(), array(
            'using'      => array('estado_id', 'estado_nombre'),
            'useEmpty'   => true,
            'emptyText'  => 'Seleccionar ',
            'emptyValue' => '',
            'class'=>'form-control','required'=>'true'
        ));
        $elemento->addValidators(array(
            new PresenceOf(array(
                'message' => 'Seleccione el estado'
            ))
        ));
        $elemento->setLabel('<strong class="font-rojo "> * </strong>Estado');
        $this->add($elemento);
        /*========================== ==========================*/
        $elemento = new Date('formacion_fechaInicio',array('class'=>'form-control','required'=>'true'));
        $elemento->setLabel('<strong class="font-rojo "> * </strong>Fecha de Inicio');
        $elemento->addValidators(array(
            new PresenceOf(array(
                'message' => 'La fecha de inicio es requerida.'
            ))
        ));
        $this->add($elemento);
        /*========================== ==========================*/
        $elemento = new Date('formacion_fechaFinal',array('class'=>'form-control', 'disabled'=>''));
        $elemento->setLabel('Fecha Final');
        $elemento->addValidators(array(
            new PresenceOf(array(
                'message' => 'La fecha final es requerida.'
            ))
        ));
        $this->add($elemento);

    }

}