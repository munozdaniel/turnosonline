<?php

class Novedades extends \Phalcon\Mvc\Model
{

    /**
     *
     * @var integer
     */
    public $novedades_id;

    /**
     *
     * @var string
     */
    public $novedades_titulo;

    /**
     *
     * @var string
     */
    public $novedades_fecha;

    /**
     *
     * @var integer
     */
    public $novedades_habilitado;

    /**
     *
     * @var string
     */
    public $novedades_contenido;

    /**
     *
     * @var string
     */
    public $novedades_rutaArchivo1;

    /**
     *
     * @var string
     */
    public $novedades_rutaArchivo2;

    /**
     *
     * @var string
     */
    public $novedades_rutaArchivo3;

    /**
     * Returns table name mapped in the model.
     *
     * @return string
     */
    public function getSource()
    {
        return 'novedades';
    }

    /**
     * Allows to query a set of records that match the specified conditions
     *
     * @param mixed $parameters
     * @return Novedades[]
     */
    public static function find($parameters = null)
    {
        return parent::find($parameters);
    }

    /**
     * Allows to query the first record that match the specified conditions
     *
     * @param mixed $parameters
     * @return Novedades
     */
    public static function findFirst($parameters = null)
    {
        return parent::findFirst($parameters);
    }

}
