<?php

class Datosbeneficio extends \Phalcon\Mvc\Model
{

    /**
     *
     * @var integer
     */
    public $datosbeneficio_id;

    /**
     *
     * @var integer
     */
    public $datosbeneficio_tipoBeneficio;

    /**
     *
     * @var string
     */
    public $datosbeneficio_fechaOtorgado;

    /**
     *
     * @var string
     */
    public $datosbeneficio_fechaBaja;

    /**
     *
     * @var integer
     */
    public $datosbeneficio_tipoNormaBaja;

    /**
     *
     * @var integer
     */
    public $datosbeneficio_anioNormaBaja;

    /**
     *
     * @var string
     */
    public $datosbeneficio_numeroNormaBaja;

    /**
     *
     * @var integer
     */
    public $datosbeneficio_normaLegalTipo;

    /**
     *
     * @var string
     */
    public $datosbeneficio_normaLegalNumero;

    /**
     *
     * @var integer
     */
    public $datosbeneficio_normaLegalAnio;

    /**
     *
     * @var integer
     */
    public $datosbeneficio_ordenanzaVigente;

    /**
     *
     * @var integer
     */
    public $datosbeneficio_categoriaReconocida;

    /**
     *
     * @var double
     */
    public $datosbeneficio_porcentaje1;

    /**
     *
     * @var double
     */
    public $datosbeneficio_porcentaje2;

    /**
     *
     * @var string
     */
    public $datosbeneficio_certificadoSupervivencia;

    /**
     *
     * @var integer
     */
    public $datosbeneficio_activo;

    /**
     *
     * @var string
     */
    public $datosbeneficio_fechaNoActivo;

    /**
     *
     * @var string
     */
    public $datosbeneficio_motivoNoActivo;

    /**
     *
     * @var integer
     */
    public $datosbeneficio_pasajes;

    /**
     *
     * @var integer
     */
    public $datosbeneficio_lugarDePago;

    /**
     *
     * @var integer
     */
    public $datosbeneficio_esRetenido;

    /**
     *
     * @var string
     */
    public $datosbeneficio_haber;

    /**
     *
     * @var string
     */
    public $datosbeneficio_haberActualizado;

    /**
     *
     * @var integer
     */
    public $datosbeneficio_siPension;

    /**
     *
     * @var integer
     */
    public $datosbeneficio_apoderado;

    /**
     *
     * @var integer
     */
    public $datosbeneficio_salarioFamiliar;

    /**
     *
     * @var integer
     */
    public $datosbeneficio_datosPersonal;

    /**
     *
     * @var string
     */
    public $datosbeneficio_legajo;

    /**
     *
     * @var integer
     */
    public $datosbeneficio_datoHistorico;

    /**
     *
     * @var string
     */
    public $datosbeneficio_CBU;

    /**
     *
     * @var integer
     */
    public $datosbeneficio_tieneDescuentoJudicial;

    /**
     *
     * @var double
     */
    public $datosbeneficio_porcentajeInvalidez;

    /**
     *
     * @var string
     */
    public $datosbeneficio_observacion;

    /**
     *
     * @var string
     */
    public $datosbeneficio_reporteBajaHaberes;

    /**
     *
     * @var string
     */
    public $datosbeneficio_reporteAltaHaberes;

    /**
     *
     * @var string
     */
    public $datosbeneficio_reporteSupervivencia;

    /**
     *
     * @var string
     */
    public $datosbeneficio_reporteSolicitud;

    /**
     *
     * @var string
     */
    public $datosbeneficio_reporteCalculoHaber;

    /**
     *
     * @var string
     */
    public $datosbeneficio_reporteLegajoBeneficiario;

    /**
     *
     * @var string
     */
    public $datosbeneficio_reporteCertificado;

    /**
     *
     * @var string
     */
    public $datosbeneficiario_reporteSeguroDeVida;

    /**
     *
     * @var string
     */
    public $datosbeneficiario_reporteSalarioFamiliar;

    /**
     * Initialize method for model.
     */
    public function initialize()
    {
        $this->setConnectionService('dbSujypweb');
        //Deberia ser de solo lectura
        $this->setReadConnectionService('dbSujypweb');
        $this->hasMany('datosbeneficio_id', 'Aniosaporte', 'aniosaporte_datosBeneficio', array('alias' => 'Aniosaporte'));
        $this->hasMany('datosbeneficio_id', 'Descuentojudicial', 'descuentojudicial_datosBeneficio', array('alias' => 'Descuentojudicial'));
        $this->hasMany('datosbeneficio_id', 'Poder', 'poder_idPoderdante', array('alias' => 'Poder'));
        $this->hasMany('datosbeneficio_id', 'Salariofamiliar', 'salariofamiliar_beneficiario', array('alias' => 'Salariofamiliar'));
        $this->hasMany('datosbeneficio_id', 'Segurovida', 'segurovida_beneficio', array('alias' => 'Segurovida'));
        $this->belongsTo('datosbeneficio_tipoBeneficio', 'Tipobeneficio', 'tipobeneficio_id', array('alias' => 'Tipobeneficio'));
        $this->belongsTo('datosbeneficio_normaLegalTipo', 'Normalegaltipo', 'normalegaltipo_id', array('alias' => 'Normalegaltipo'));
        $this->belongsTo('datosbeneficio_categoriaReconocida', 'Categoria', 'categoria_id', array('alias' => 'Categoria'));
        $this->belongsTo('datosbeneficio_lugarDePago', 'Lugarpago', 'lugarpago_id', array('alias' => 'Lugarpago'));
        $this->belongsTo('datosbeneficio_siPension', 'Sipension', 'sipension_id', array('alias' => 'Sipension'));
        $this->belongsTo('datosbeneficio_datoHistorico', 'Datohistorico', 'datohistorico_id', array('alias' => 'Datohistorico'));
        $this->belongsTo('datosbeneficio_datosPersonal', 'Datospersona', 'datospersona_id', array('alias' => 'Datospersona'));
        $this->belongsTo('datosbeneficio_ordenanzaVigente', 'Ordenanzabeneficio', 'ordenanzabeneficio_id', array('alias' => 'Ordenanzabeneficio'));
    }

    /**
     * Returns table name mapped in the model.
     *
     * @return string
     */
    public function getSource()
    {
        return 'datosbeneficio';
    }

    /**
     * Allows to query a set of records that match the specified conditions
     *
     * @param mixed $parameters
     * @return Datosbeneficio[]
     */
    public static function find($parameters = null)
    {
        return parent::find($parameters);
    }

    /**
     * Allows to query the first record that match the specified conditions
     *
     * @param mixed $parameters
     * @return Datosbeneficio
     */
    public static function findFirst($parameters = null)
    {
        return parent::findFirst($parameters);
    }

}
