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

        //pass options to original constructor
        parent::__construct($options);

        $this->setOption("cancelOnFail",true);

    }

    public function validate(\Phalcon\Validation  $validator, $attribute) {
        //Var dump para ver los datos
        //var_dump($validator);//delete this line, it's for you to see what it is
        //var_dump($attribute);//delete this line, it's for you to see what it is

        //Obtengo el valor del primer campo.
        $desde = $validator->getValue($attribute);
        //Obtengo el valor del segundo campo.
        $hasta = $this->getOption('hasta');
        if($desde<$hasta)
        {
            return true;
        }
        //if we are here it means that date is wrong

        //first, check if message was provided with options
        $message = $this->getOption('message');
        if (!$message) {
            //message was not provided, so set some default
            $message = "Verificar ".$this->getOption('verificarCampo').". La fecha <ins>$desde</ins> debe ser menor a la fecha <ins>$hasta</ins>";
        }

        //add message object
        $validator->appendMessage(new Message($message, $attribute, 'IsAwesomeDate'));

        return false;

    }


}