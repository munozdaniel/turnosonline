<?php
/**
 * Created by PhpStorm.
 * User: dmunioz
 * Date: 18/01/2016
 * Time: 11:33
 */

use Phalcon\Forms\Form;
use Phalcon\Forms\Element\Text;
use Phalcon\Forms\Element\TextArea;
use Phalcon\Validation\Validator\PresenceOf;
use \Phalcon\Forms\Element\Date;
use \Phalcon\Forms\Element\Email;
use \Phalcon\Forms\Element\Select;
class InformacionForm extends Form {
    /**
     * Initialize the products form
     */
    public function initialize($entity = null, $options = array())
    {

        /*========================== CONOCIMIENTOS ==========================*/
        $elemento = new Text('conocimientos_nombre',array('class'=>'form-control','required'=>'true','placeholder'=>'Cursos/Aptitudes'));
        $elemento->setLabel('Aptitudes');
        $elemento->setFilters(array('striptags', 'string'));
        $elemento->addValidators(array(
            new PresenceOf(array(
                'message' => 'Ingrese una Aptitud/Curso'
            ))
        ));
        $this->add($elemento);
        /*========================== ==========================*/
        $elemento = new Select('conocimientos_nivelId', \Curriculum\Nivel::find(), array(
            'using'      => array('nivel_id', 'nivel_nombre'),
            'useEmpty'   => true,
            'emptyText'  => 'Seleccionar ',
            'emptyValue' => '',
            'class'      => 'form-control','required'=>'true'
        ));
        $elemento->addValidators(array(
            new PresenceOf(array(
                'message' => 'Ingrese el Nivel de la Aptitud/Curso'
            ))
        ));
        $elemento->setLabel('Nivel');
        $this->add($elemento);
        /*========================== ADICIONAL ==========================*/
        $elemento = new Text('empleo_disponibilidad',array('class'=>'form-control','required'=>'true','placeholder'=>'Ingrese un Intervalo '));
        $elemento->setLabel('Disponibilidad Horaria');
        $elemento->setFilters(array('striptags', 'string'));

        $this->add($elemento);
        /*========================== ==========================*/
        $elemento = new Select('empleo_carnet',  array('SI','NO'), array(
            'useEmpty'   => true,
            'emptyText'  => 'Seleccionar ',
            'emptyValue' => '',
            'class'      => 'form-control ','required'=>'true'
        ));
        $elemento->setLabel('Posee carnet de conducir?');
        $this->add($elemento);


        /*========================== Dependent Select Dropdown ==========================*/

        $elemento = new Select('dependencia_id',  \Curriculum\Dependencia::find(), array(
            'using'      => array('dependencia_id', 'dependencia_nombre'),
            'useEmpty'   => true,
            'emptyText'  => 'Seleccionar ',
            'emptyValue' => '',
            'class'      => 'form-control ','required'=>'true'
        ));
        $elemento->addValidators(array(
            new PresenceOf(array(
                'message' => 'Seleccione la Provincia'
            ))
        ));
        $elemento->setLabel('<strong class="font-rojo "> * </strong>Dependencia');
        $this->add($elemento);

        $elemento =  new Select('puesto_id',array(), array(
            'using'      => array('puesto_id', 'puesto_nombre'),
            'useEmpty'   => true,
            'emptyText'  => 'Primero Seleccione la Dependencia',
            'emptyValue' => '',
            'class'      => 'form-control','required'=>'true'
        ));
        $elemento->addValidators(array(
            new PresenceOf(array(
                'message' => 'Seleccione el Puesto'
            ))
        ));
        $elemento->setLabel('<strong class="font-rojo "> * </strong>Puesto');
        $this->add($elemento);
        /*==========================  ==========================*/
        $elemento = new Text('puesto_otro',array('class'=>'form-control','placeholder'=>'Especifique el Puesto'));
        $elemento->setLabel('Otro Puesto');
        $elemento->setFilters(array('striptags', 'string'));

        $this->add($elemento);
        /*========================== ==========================*/
        $elemento = new Select('sectorInteres_id', \Curriculum\Sectorinteres::find(), array(
            'using'      => array('sectorInteres_id', 'sectorInteres_nombre'),
            'useEmpty'   => true,
            'emptyText'  => 'Seleccionar ',
            'emptyValue' => '',
            'class'      => 'form-control'
        ));

        $elemento->setLabel('<strong class="font-rojo "> * </strong>Sector de Interés');
        $this->add($elemento);
        /*========================== Script para los selects dependientes =============== */
        $script = new DataListScript('script_puestoDependencia',array(
            'url' => '/impsweb/puesto/buscarPuestos',
            'idPrincipal'=>'dependencia_id',
            'idSecundario'=>'puesto_id',
            'columnas'=>array('puesto_id','puesto_nombre')
        ));
        $script->setLabel(" ");
        $this->add($script);

    }

}