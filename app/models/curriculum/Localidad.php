<?php
namespace Curriculum;

class Localidad extends \Phalcon\Mvc\Model
{

    /**
     *
     * @var integer
     */
    public $localidad_id;

    /**
     *
     * @var integer
     */
    public $localidad_codigoPostal;

    /**
     *
     * @var string
     */
    public $localidad_domicilio;

    /**
     *
     * @var integer
     */
    public $localidad_ciudadId;

    /**
     * GETTERS AND SETTERS
     */
    public function getLocalidadId()
    {
        return $this->localidad_id;
    }
    public function getLocalidadCodigopostal()
    {
        return $this->localidad_codigoPostal;
    }
    public function getLocalidadDomicilio()
    {
        return $this->localidad_domicilio;
    }
    public function getLocalidadCiudadid()
    {
        return $this->localidad_ciudadId;
    }
    public function setLocalidadId($localidad_id)
    {
         $this->localidad_id=$localidad_id;
    }
    public function setLocalidadCodigopostal($localidad_codigoPostal)
    {
         $this->localidad_codigoPostal=$localidad_codigoPostal;
    }
    public function setLocalidadDomicilio($localidad_domicilio)
    {
         $this->localidad_domicilio=$localidad_domicilio;
    }
    public function setLocalidadCiudadid($localidad_ciudadId)
    {
         $this->localidad_ciudadId=$localidad_ciudadId;
    }
    /**
     * Initialize method for model.
     */
    public function initialize()
    {
        $this->hasMany('localidad_id', 'Curriculum\Persona', 'persona_localidadId', array('alias' => 'Persona'));
        $this->belongsTo('localidad_ciudadId', 'Curriculum\Ciudad', 'ciudad_id', array('alias' => 'Ciudad'));
    }

    /**
     * Returns table name mapped in the model.
     *
     * @return string
     */
    public function getSource()
    {
        return 'localidad';
    }

    /**
     * Allows to query a set of records that match the specified conditions
     *
     * @param mixed $parameters
     * @return Localidad[]
     */
    public static function find($parameters = null)
    {
        return parent::find($parameters);
    }

    /**
     * Allows to query the first record that match the specified conditions
     *
     * @param mixed $parameters
     * @return Localidad
     */
    public static function findFirst($parameters = null)
    {
        return parent::findFirst($parameters);
    }

}
