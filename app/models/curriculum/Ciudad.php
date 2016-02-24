<?php
namespace Curriculum;

class Ciudad extends \Phalcon\Mvc\Model
{

    /**
     *
     * @var integer
     */
    public $ciudad_id;

    /**
     *
     * @var string
     */
    public $ciudad_nombre;

    /**
     *
     * @var integer
     */
    public $ciudad_provinciaId;
    /**
     * Getters and Setters
     */
    public function getCiudadId()
    {
        return $this->ciudad_id;
    }

    public function setCiudadId($ciudad_id)
    {
        $this->ciudad_id=$ciudad_id;
    }
    public function getCiudadNombre()
    {
        return $this->ciudad_nombre;
    }

    public function setCiudadNombre($ciudad_nombre)
    {
        $this->ciudad_nombre=$ciudad_nombre;
    }
    public function getCiudadProvinciaid()
    {
        return $this->ciudad_provinciaId;
    }

    public function setCiudadProvinciaid($ciudad_provinciaId)
    {
        $this->ciudad_provinciaId=$ciudad_provinciaId;
    }

    /**
     * Initialize method for model.
     */
    public function initialize()
    {
        $this->hasMany('ciudad_id', 'Curriculum\Localidad', 'localidad_ciudadId', array('alias' => 'Localidad'));
        $this->belongsTo('ciudad_provinciaId', 'Curriculum\Provincia', 'provincia_id', array('alias' => 'Provincia'));
    }

    /**
     * Returns table name mapped in the model.
     *
     * @return string
     */
    public function getSource()
    {
        return 'ciudad';
    }

    /**
     * Allows to query a set of records that match the specified conditions
     *
     * @param mixed $parameters
     * @return Ciudad[]
     */
    public static function find($parameters = null)
    {
        return parent::find($parameters);
    }

    /**
     * Allows to query the first record that match the specified conditions
     *
     * @param mixed $parameters
     * @return Ciudad
     */
    public static function findFirst($parameters = null)
    {
        return parent::findFirst($parameters);
    }

}
