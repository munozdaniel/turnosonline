<?php

class Datospersona extends \Phalcon\Mvc\Model
{

    /**
     *
     * @var integer
     */
    public $datospersona_id;

    /**
     *
     * @var string
     */
    public $datospersona_nombre;

    /**
     *
     * @var string
     */
    public $datospersona_apellido;

    /**
     *
     * @var string
     */
    public $datospersona_fechaNacimiento;

    /**
     *
     * @var integer
     */
    public $datospersona_idNacionalidad;

    /**
     *
     * @var integer
     */
    public $datospersona_tipoDoc;

    /**
     *
     * @var string
     */
    public $datospersona_nroDoc;

    /**
     *
     * @var string
     */
    public $datospersona_sexo;

    /**
     *
     * @var string
     */
    public $datospersona_cuil;

    /**
     *
     * @var integer
     */
    public $datospersona_domicilio;

    /**
     *
     * @var string
     */
    public $datospersona_telefonoFijo;

    /**
     *
     * @var string
     */
    public $datospersona_celular;

    /**
     *
     * @var string
     */
    public $datospersona_email;

    /**
     *
     * @var integer
     */
    public $datospersona_estadoFamiliar;

    /**
     * Initialize method for model.
     */
    public function initialize()
    {
        $this->setConnectionService('dbSujypweb');
        //Deberia ser de solo lectura
        $this->setReadConnectionService('dbSujypweb');
        $this->hasMany('datospersona_id', 'Datosbeneficio', 'datosbeneficio_datosPersonal', array('alias' => 'Datosbeneficio'));
        $this->hasMany('datospersona_id', 'Poder', 'poder_idDatosPersona', array('alias' => 'Poder'));
        $this->hasMany('datospersona_id', 'Salariofamiliar', 'salariofamiliar_idDatosPersona', array('alias' => 'Salariofamiliar'));
        $this->hasMany('datospersona_id', 'Segurovida', 'segurovida_idDatosPersona', array('alias' => 'Segurovida'));
        $this->belongsTo('datospersona_estadoFamiliar', 'Estadofamiliar', 'estadofamiliar_id', array('alias' => 'Estadofamiliar'));
        $this->belongsTo('datospersona_domicilio', 'Domicilio', 'domicilio_id', array('alias' => 'Domicilio'));
        $this->belongsTo('datospersona_tipoDoc', 'Tipodoc', 'tipodoc_id', array('alias' => 'Tipodoc'));
    }

    /**
     * Returns table name mapped in the model.
     *
     * @return string
     */
    public function getSource()
    {
        return 'datospersona';
    }

    /**
     * Allows to query a set of records that match the specified conditions
     *
     * @param mixed $parameters
     * @return Datospersona[]
     */
    public static function find($parameters = null)
    {
        return parent::find($parameters);
    }

    /**
     * Allows to query the first record that match the specified conditions
     *
     * @param mixed $parameters
     * @return Datospersona
     */
    public static function findFirst($parameters = null)
    {
        return parent::findFirst($parameters);
    }

}
