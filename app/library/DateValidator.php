<?php
/**
 * Created by PhpStorm.
 * User: Daniel
 * Date: 12/10/2015
 * Time: 02:52 PM
 */
use Phalcon\Validation\Validator,
    Phalcon\Validation\ValidatorInterface,
    Phalcon\Validation\Message;

class DateValidator  extends Validator implements ValidatorInterface {

    // constructor is defined only because you wanted to have "cancelOnFail" true,
    // If you don't want this, then the implementation of constructor is not necessary
    public function __construct($options = null) {
        //NO ENTIENDO PARA QUE SIRVE!!!!
        //pass options to original constructor
        parent::__construct($options);

        $this->setOption("cancelOnFail",true);

    }

    public function validate(\Phalcon\Validation  $validator, $attribute) {
        //Var dump para ver los datos
        //var_dump($validator);//delete this line, it's for you to see what it is
        //var_dump($attribute);//delete this line, it's for you to see what it is

        //Obtengo el valor del primer campo.
        $hasta = $validator->getValue($attribute);
        //Obtengo el valor del segundo campo.
        $desde = $this->getOption('desde');

        if($desde<$hasta)
        {
            return true;
        }
        //if we are here it means that date is wrong

        //first, check if message was provided with options
        $message = $this->getOption('message');
        if (!$message) {
            //message was not provided, so set some default
            $message = $this->getOption('mensajeError');
        }

        //add message object
        $validator->appendMessage(new Message($message, $attribute, 'Fechas Incorrectas'));

        return false;
    }
}