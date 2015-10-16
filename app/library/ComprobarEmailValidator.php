<?php
/**
 * Created by PhpStorm.
 * User: dmunioz
 * Date: 13/10/2015
 * Time: 12:11
 */
use Phalcon\Validation\Validator,
    Phalcon\Validation\ValidatorInterface,
    Phalcon\Validation\Message;
class ComprobarEmailValidator extends Validator implements ValidatorInterface
{

    /**
     * Verificamos que los correos sean iguales.
     *
     * @param Phalcon\Validation $validator
     * @param string $attribute
     * @return boolean
     */
    public function validate(\Phalcon\Validation $validator, $attribute)
    {
        //Obtengo el valor del email original.
        $emailRepetido = $validator->getValue($attribute);

        //Obtengo el valor del email repetido a comparar.
        $email = $this->getOption('email');
        //echo $email->getValue()." $emailRepetido";

        if (strcmp(trim($email->getValue()),trim($emailRepetido))!=0) {
            $validator->appendMessage(new Message('Los correos no coinciden.'));
            return false;
        }
        return true;
    }

}