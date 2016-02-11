<?php
namespace Curriculum;

class Sectorinteres extends \Phalcon\Mvc\Model
{

    /**
     *
     * @var integer
     */
    protected $sectorInteres_id;

    /**
     *
     * @var string
     */
    protected $sectorInteres_nombre;

    /**
     *
     * @var integer
     */
    protected $sectorInteres_habilitado;

    /**
     * Method to set the value of field sectorInteres_id
     *
     * @param integer $sectorInteres_id
     * @return $this
     */
    public function setSectorinteresId($sectorInteres_id)
    {
        $this->sectorInteres_id = $sectorInteres_id;

        return $this;
    }

    /**
     * Method to set the value of field sectorInteres_nombre
     *
     * @param string $sectorInteres_nombre
     * @return $this
     */
    public function setSectorinteresNombre($sectorInteres_nombre)
    {
        $this->sectorInteres_nombre = $sectorInteres_nombre;

        return $this;
    }

    /**
     * Method to set the value of field sectorInteres_habilitado
     *
     * @param integer $sectorInteres_habilitado
     * @return $this
     */
    public function setSectorinteresHabilitado($sectorInteres_habilitado)
    {
        $this->sectorInteres_habilitado = $sectorInteres_habilitado;

        return $this;
    }

    /**
     * Returns the value of field sectorInteres_id
     *
     * @return integer
     */
    public function getSectorinteresId()
    {
        return $this->sectorInteres_id;
    }

    /**
     * Returns the value of field sectorInteres_nombre
     *
     * @return string
     */
    public function getSectorinteresNombre()
    {
        return $this->sectorInteres_nombre;
    }

    /**
     * Returns the value of field sectorInteres_habilitado
     *
     * @return integer
     */
    public function getSectorinteresHabilitado()
    {
        return $this->sectorInteres_habilitado;
    }

    /**
     * Initialize method for model.
     */
    public function initialize()
    {
        $this->hasMany('sectorInteres_id', 'Empleo', 'empleo_sectorInteresId', array('alias' => 'Empleo'));
    }

    /**
     * Returns table name mapped in the model.
     *
     * @return string
     */
    public function getSource()
    {
        return 'sectorinteres';
    }

    /**
     * Allows to query a set of records that match the specified conditions
     *
     * @param mixed $parameters
     * @return Sectorinteres[]
     */
    public static function find($parameters = null)
    {
        return parent::find($parameters);
    }

    /**
     * Allows to query the first record that match the specified conditions
     *
     * @param mixed $parameters
     * @return Sectorinteres
     */
    public static function findFirst($parameters = null)
    {
        return parent::findFirst($parameters);
    }

}
