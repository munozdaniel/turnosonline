<?php
/**
 * Created by PhpStorm.
 * User: Daniel
 * Date: 12/10/2015
 * Time: 06:36 PM
 */
use Phalcon\Validation\Validator,
    Phalcon\Validation\ValidatorInterface,
    Phalcon\Validation\Message;
class NumberValidator extends Validator implements ValidatorInterface
{

    /**
     * Executes the validation, verifica que sea un numero y que sea mayor a cero.
     *
     * @param Phalcon\Validation $validator
     * @param string $attribute
     * @return boolean
     */
    public function validate(\Phalcon\Validation $validator, $attribute)
    {
        $value = $validator->getValue($attribute);
        if (!is_numeric($value)||($value<=0)) {
            $validator->appendMessage(new Message('Es necesario que sea un número mayor a 0.'));
            return false;
        }
        return true;
    }

}