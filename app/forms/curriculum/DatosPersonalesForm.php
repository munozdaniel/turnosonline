<?php
/**
 * Created by PhpStorm.
 * User: dmunioz
 * Date: 21/12/2015
 * Time: 13:12
 */

use Phalcon\Forms\Form;
use Phalcon\Forms\Element\Text;
use Phalcon\Forms\Element\TextArea;
use Phalcon\Validation\Validator\PresenceOf;
use \Phalcon\Forms\Element\Date;
use \Phalcon\Forms\Element\Email;
use \Phalcon\Forms\Element\Select;
class DatosPersonalesForm  extends Form {
    /**
     * Initialize the products form
     */
    public function initialize($entity = null, $options = array())
    {
     /*   if (!isset($options['edit'])) {

            $element = new Text("persona_id");
            $this->add($element->setLabel("Id"));
        } else {
            $this->add(new \Phalcon\Forms\Element\Hidden("persona_id"));
        }*/
        /*========================== ==========================*/
        $persona_apellido = new Text('persona_apellido');
        $persona_apellido->setLabel('Apellido');
        $persona_apellido->setFilters(array('striptags', 'string'));
        $persona_apellido->addValidators(array(
            new PresenceOf(array(
                'message' => 'El Apellido es requerido'
            ))
        ));
        $this->add($persona_apellido);
        /*========================== ==========================*/
        $persona_nombre = new Text('persona_nombre');
        $persona_nombre->setLabel('Nombre');
        $persona_nombre->setFilters(array('striptags', 'string'));
        $persona_nombre->addValidators(array(
            new PresenceOf(array(
                'message' => 'El Nombre es requerido'
            ))
        ));
        $this->add($persona_nombre);
        /*========================== ==========================*/
        $persona_fechaNacimiento = new Date('persona_fechaNacimiento');
        $persona_fechaNacimiento->setLabel('Fecha Nacimiento');
        $persona_fechaNacimiento->setFilters(array('striptags', 'string'));
        $persona_fechaNacimiento->addValidators(array(
            new PresenceOf(array(
                'message' => 'La Fecha Nacimiento es requerida'
            ))
        ));
        $this->add($persona_fechaNacimiento);
        /*========================== ==========================*/
        $persona_tipoDocumentoId = new Select('persona_tipoDocumentoId', Tipodoc::find(), array(
            'using'      => array('tipodocumento_id', 'tipodocumento_descripcion'),
            'useEmpty'   => true,
            'emptyText'  => '...',
            'emptyValue' => ''
        ));
        $persona_tipoDocumentoId->setLabel('Tipo Documento');
        $this->add($persona_tipoDocumentoId);
        /*========================== ==========================*/
        $persona_numeroDocumento = new Text('persona_numeroDocumento');
        $persona_numeroDocumento->setLabel('Nro Documento');
        $persona_numeroDocumento->setFilters(array('int'));
        $persona_numeroDocumento->addValidators(array(
            new PresenceOf(array(
                'message' => 'El Documento es requerido'
            ))
        ));
        $this->add($persona_numeroDocumento);
        /*========================== ==========================*/
        $persona_sexo = new Select('persona_sexo', array('Masculino','Femenino'));
        $persona_tipoDocumentoId->setLabel('Sexo');
        $this->add($persona_sexo);
        /*========================== ==========================*/
        $persona_sexo = new Select('persona_sexo', array('Masculino','Femenino'));
        $persona_tipoDocumentoId->setLabel('Sexo');
        $this->add($persona_sexo);
        /*========================== ==========================*/
        $persona_nacionalidadId = new Select('persona_nacionalidadId', Nacionalidad::find(), array(
            'using'      => array('nacionalidad_id', 'nacionalidad_nombre'),
            'useEmpty'   => true,
            'emptyText'  => '...',
            'emptyValue' => ''
        ));
        $persona_nacionalidadId->setLabel('Nacionalidad');
        $this->add($persona_nacionalidadId);

        /*========================== ==========================*/
        $localidad_codigoPostal = new Text('localidad_codigoPostal');
        $localidad_codigoPostal->setLabel('Codigo Postal');
        $localidad_codigoPostal->setFilters(array('int'));
        $localidad_codigoPostal->addValidators(array(
            new PresenceOf(array(
                'message' => 'El Codigo Postal es requerido'
            ))
        ));
        $this->add($localidad_codigoPostal);
        /*========================== Dependent Select Dropdown ==========================*/
        $provincia = new Select('provincia_id', Provincia::find(), array(
            'using'      => array('provincia_id', 'provincia_nombre'),
            'useEmpty'   => true,
            'emptyText'  => '...',
            'emptyValue' => ''
        ));
        $provincia->setLabel('Provincia');
        $this->add($provincia);

        $ciudad =  new Select('ciudad_id',array());
        $ciudad->setLabel('Ciudad');
        $this->add($ciudad);

        /*========================== Domicilio ==========================*/
        $localidad_domicilio = new Text('localidad_domicilio');
        $localidad_domicilio->setLabel('Domicilio');
        $localidad_domicilio->setFilters(array('string'));
        $localidad_domicilio->addValidators(array(
            new PresenceOf(array(
                'message' => 'El Domicilio es requerido'
            ))
        ));
        $this->add($localidad_domicilio);
        /*========================== Telefono ==========================*/
        $persona_telefono = new Text('persona_telefono');
        $persona_telefono->setLabel('Teléfono <small>(Únicamente números)</small>');
        $persona_telefono->setFilters(array('int'));
        $persona_telefono->addValidators(array(
            new PresenceOf(array(
                'message' => 'El Teléfono es requerido'
            ))
        ));
        $this->add($persona_telefono);
        /*========================== Celular ==========================*/
        $persona_celular = new Text('persona_celular');
        $persona_celular->setLabel('Celular <small>(Únicamente números)</small>');
        $persona_celular->setFilters(array('int'));
        $persona_celular->addValidators(array(
            new PresenceOf(array(
                'message' => 'El Celular es requerido'
            ))
        ));
        $this->add($persona_celular);
        /*========================== Email ==========================*/
        $persona_email = new Email('persona_email');
        $persona_email->setLabel('Email');
        $persona_email->setFilters(array('email'));
        $persona_email->addValidators(array(
            new PresenceOf(array(
                'message' => 'El Email es requerido'
            ))
        ));
        $this->add($persona_email);
        /*========================== Estado Civil ==========================*/
        $persona_estadoCivilId = new Select('persona_estadoCivilId', Estadocivil::find(), array(
            'using'      => array('estadoCivil_id', 'estadoCivil_nombre'),
            'useEmpty'   => true,
            'emptyText'  => '...',
            'emptyValue' => ''
        ));
        $persona_estadoCivilId->setLabel('Estado Civil');
        $this->add($persona_estadoCivilId);
        /*========================== Script para los selects dependientes =============== */
        $script = new DataListScript('ciudad_provincia',array(
            'url' => '/impsweb/persona/buscarCiudades',
            'idPrincipal'=>'provincia_id',
            'idSecundario'=>'ciudad_id',
            'columnas'=>array('ciudad_id','ciudad_nombre')
        ));
        $script->setLabel(" ");
        $this->add($script);
    }
}