<?php
/**
 * Created by PhpStorm.
 * User: dmunioz
 * Date: 05/01/2016
 * Time: 11:11
 */
use Phalcon\Forms\Form;
use Phalcon\Forms\Element\Text;
use Phalcon\Forms\Element\TextArea;
use Phalcon\Validation\Validator\PresenceOf;
use \Phalcon\Forms\Element\Date;
use \Phalcon\Forms\Element\Email;
use Phalcon\Forms\Element\Check;
use \Phalcon\Forms\Element\Select;

class ExperienciaForm   extends Form {
    /**
     * Inicializar el formulario experiencia
     */
    public function initialize($entity = null, $options = array())
    {
        if (!isset($options['edit'])) {

            $elemento = new Text("experiencia_id");
            $this->add($elemento->setLabel("Id"));
        } else {
            $this->add(new \Phalcon\Forms\Element\Hidden("experiencia_id"));
        }
        /*========================== ==========================*/
        $elemento = new Text('experiencia_empresa',array('maxlength'=>50,'class'=>'form-control','required'=>''));
        $elemento->setLabel('<strong class="font-rojo "> * </strong>Empresa');
        $elemento->setFilters(array('striptags', 'string'));
        $elemento->addValidators(array(
            new PresenceOf(array(
                'message' => 'El nombre de la empresa es requerido'
            ))
        ));
        $this->add($elemento);
        /*========================== ==========================*/
        $elemento = new Text('experiencia_rubro',array('maxlength'=>50,'class'=>'form-control','required'=>''));
        $elemento->setLabel('<strong class="font-rojo "> * </strong>Rubro');
        $elemento->setFilters(array('striptags', 'string'));
        $elemento->addValidators(array(
            new PresenceOf(array(
                'message' => 'El rubro de la empresa es requerido'
            ))
        ));
        $this->add($elemento);
        /*========================== ==========================*/
        $elemento = new Text('experiencia_cargo',array('maxlength'=>50,'class'=>'form-control','required'=>''));
        $elemento->setLabel('<strong class="font-rojo "> * </strong>Cargo Ocupado');
        $elemento->setFilters(array('striptags', 'string'));
        $elemento->addValidators(array(
            new PresenceOf(array(
                'message' => 'El cargo es requerido'
            ))
        ));
        $this->add($elemento);
        /*========================== ==========================*/
        $elemento = new TextArea('experiencia_tareas',array('maxlength'=>150,'class'=>'form-control','required'=>''));
        $elemento->setLabel('<strong class="font-rojo "> * </strong>Tareas Realizadas');
        $elemento->setFilters(array('striptags', 'string'));
        $elemento->addValidators(array(
            new PresenceOf(array(
                'message' => 'Ingrese las tareas realizadas en la empresa'
            ))
        ));
        $this->add($elemento);
        /*========================== ==========================*/
        $elemento = new Date('experiencia_fechaInicio',array('class'=>'form-control','required'=>''));
        $elemento->setLabel('<strong class="font-rojo "> * </strong>Fecha de Inicio');
        $elemento->addValidators(array(
            new PresenceOf(array(
                'message' => 'La fecha de inicio es requerida.'
            ))
        ));
        $this->add($elemento);
        /*========================== ==========================*/
        $elemento = new Date('experiencia_fechaFinal',array('class'=>'form-control', 'disabled'=>'','required'=>''));
        $elemento->setLabel('Fecha Final');
        $elemento->addValidators(array(
            new PresenceOf(array(
                'message' => 'La fecha final es requerida.'
            ))
        ));
        $this->add($elemento);
        $elemento = new Check('experiencia_fechaActual', array(
            'value' => '1', 'checked'=>''
        ));
        $elemento->setLabel('Al Presente');
        $this->add($elemento);

        /*========================== ==========================*/
        $provincia = new Select('experiencia_provinciaId',  \Curriculum\Provincia::find(), array(
            'using'      => array('provincia_id', 'provincia_nombre'),
            'useEmpty'   => true,
            'emptyText'  => 'Seleccionar ',
            'emptyValue' => '',
            'class'=>'form-control','required'=>''
        ));
        $provincia->addValidators(array(
            new PresenceOf(array(
                'message' => 'Seleccione la Provincia'
            ))
        ));
        $provincia->setLabel('<strong class="font-rojo "> * </strong>Provincia');
        $this->add($provincia);
    }
}