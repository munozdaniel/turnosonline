<?php

use Phalcon\Validation\Validator,
    Phalcon\Validation\ValidatorInterface,
    Phalcon\Validation\Message;

class LegajoValidator extends Validator implements ValidatorInterface
{
    /**
     * Executes the validation, verifica que el legajo sea de un afiliado ACTIVO.
     *
     * @param Phalcon\Validation $validator
     * @param string $attribute
     * @return boolean
     */
    public function validate(\Phalcon\Validation $validator, $attribute)
    {
        $value = $validator->getValue($attribute);

        if ($value>=10000 && $value <=12999)
        {
            $validator->appendMessage(new Message('<h1>El legajo ingresado debe ser de un afiliado ACTIVO</h1>'));
            return false;
        }

        return true;
    }

}