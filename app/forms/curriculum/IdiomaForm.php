<?php
/**
 * Created by PhpStorm.
 * User: dmunioz
 * Date: 20/01/2016
 * Time: 14:21
 */
use Phalcon\Forms\Form;
use Phalcon\Forms\Element\Text;
use Phalcon\Forms\Element\TextArea;
use Phalcon\Validation\Validator\PresenceOf;
use \Phalcon\Forms\Element\Date;
use \Phalcon\Forms\Element\Email;
use \Phalcon\Forms\Element\Select;
class IdiomaForm extends Form {
    /**
     * Initialize the products form
     */
    public function initialize($entity = null, $options = array())
    {

        /*========================== IDIOMA ==========================*/

        $elemento2 = new Select('idiomas_nombre',
            array('INGLES'=>'INGLES','FRANCES'=>'FRANCÉS','ALEMAN'=>'ALEMÁN','RUSO'=>'RUSO','PORTUGUES'=>'PORTUGUÉS',
                'ARABE'=>'ÁRABE','BENGALI'=>'BENGALÍ','INDOSTANICO'=>'INDOSTÁNICO','MANDARIN'=>'MANDARÍN'), array(
            'useEmpty'   => true,
            'emptyText'  => 'Seleccionar ',
            'emptyValue' => '',
            'class'      => 'form-control','required'=>'true'
        ));
        $elemento2->addValidators(array(
            new PresenceOf(array(
                'message' => 'Seleccione el Idioma'
            ))
        ));
        $elemento2->setLabel('Idioma');
        $this->add($elemento2);
        /*========================== ==========================*/
        $elemento2 = new Select('idiomas_nivelId', \Curriculum\Nivel::find(), array(
            'using'      => array('nivel_id', 'nivel_nombre'),
            'useEmpty'   => true,
            'emptyText'  => 'Seleccionar ',
            'emptyValue' => '',
            'class'      => 'form-control','required'=>'true'
        ));
        $elemento2->addValidators(array(
            new PresenceOf(array(
                'message' => 'Seleccione el Nivel'
            ))
        ));
        $elemento2->setLabel('Nivel');
        $this->add($elemento2);

    }

}