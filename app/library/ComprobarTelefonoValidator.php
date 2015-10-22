<?php
use Phalcon\Validation\Validator,
    Phalcon\Validation\ValidatorInterface,
    Phalcon\Validation\Message;

class ComprobarTelefonoValidator extends Validator implements ValidatorInterface
{
     //Verificamos que los telefonos sean iguales.

    public function validate(\Phalcon\Validation $validator, $attribute)
    {
        $telefonoRepetido = $validator->getValue($attribute);
        $telefono = $this->getOption('telefono');

        if( strcmp(trim($telefono->getValue()),trim($telefonoRepetido)) !=0 )
        {
            $validator->appendMessage(new Message('Los n&uacute;meros de telefono no coinciden.'));
            return false;
        }
        return true;
    }
}