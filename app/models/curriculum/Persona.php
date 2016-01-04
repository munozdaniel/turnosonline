<?php
namespace Curriculum;
use Phalcon\Mvc\Model\Validator\Uniqueness;

class Persona extends \Phalcon\Mvc\Model
{

    /**
     *
     * @var integer
     */
    protected $persona_id;

    /**
     *
     * @var integer
     */
    protected $persona_curriculumId;

    /**
     *
     * @var string
     */
    protected $persona_apellido;

    /**
     *
     * @var string
     */
    protected $persona_nombre;

    /**
     *
     * @var string
     */
    protected $persona_fechaNacimiento;

    /**
     *
     * @var integer
     */
    protected $persona_tipoDocumentoId;

    /**
     *
     * @var string
     */
    protected $persona_numeroDocumento;

    /**
     *
     * @var integer
     */
    protected $persona_sexo;

    /**
     *
     * @var integer
     */
    protected $persona_nacionalidadId;

    /**
     *
     * @var integer
     */
    protected $persona_localidadId;

    /**
     *
     * @var string
     */
    protected $persona_telefono;

    /**
     *
     * @var string
     */
    protected $persona_celular;

    /**
     *
     * @var string
     */
    protected $persona_email;

    /**
     *
     * @var integer
     */
    protected $persona_estadoCivilId;

    /**
     *
     * @var integer
     */
    protected $persona_habilitado;

    /**
     *
     * @var string
     */
    protected $persona_fechaCreacion;

    /**
     * Method to set the value of field persona_id
     *
     * @param integer $persona_id
     * @return $this
     */
    public function setPersonaId($persona_id)
    {
        $this->persona_id = $persona_id;

        return $this;
    }

    /**
     * Method to set the value of field persona_curriculumId
     *
     * @param integer $persona_curriculumId
     * @return $this
     */
    public function setPersonaCurriculumid($persona_curriculumId)
    {
        $this->persona_curriculumId = $persona_curriculumId;

        return $this;
    }

    /**
     * Method to set the value of field persona_apellido
     *
     * @param string $persona_apellido
     * @return $this
     */
    public function setPersonaApellido($persona_apellido)
    {
        $this->persona_apellido = $persona_apellido;

        return $this;
    }

    /**
     * Method to set the value of field persona_nombre
     *
     * @param string $persona_nombre
     * @return $this
     */
    public function setPersonaNombre($persona_nombre)
    {
        $this->persona_nombre = $persona_nombre;

        return $this;
    }

    /**
     * Method to set the value of field persona_fechaNacimiento
     *
     * @param string $persona_fechaNacimiento
     * @return $this
     */
    public function setPersonaFechanacimiento($persona_fechaNacimiento)
    {
        $this->persona_fechaNacimiento = $persona_fechaNacimiento;

        return $this;
    }

    /**
     * Method to set the value of field persona_tipoDocumentoId
     *
     * @param integer $persona_tipoDocumentoId
     * @return $this
     */
    public function setPersonaTipodocumentoid($persona_tipoDocumentoId)
    {
        $this->persona_tipoDocumentoId = $persona_tipoDocumentoId;

        return $this;
    }

    /**
     * Method to set the value of field persona_numeroDocumento
     *
     * @param string $persona_numeroDocumento
     * @return $this
     */
    public function setPersonaNumerodocumento($persona_numeroDocumento)
    {
        $this->persona_numeroDocumento = $persona_numeroDocumento;

        return $this;
    }

    /**
     * Method to set the value of field persona_sexo
     *
     * @param integer $persona_sexo
     * @return $this
     */
    public function setPersonaSexo($persona_sexo)
    {
        $this->persona_sexo = $persona_sexo;

        return $this;
    }

    /**
     * Method to set the value of field persona_nacionalidadId
     *
     * @param integer $persona_nacionalidadId
     * @return $this
     */
    public function setPersonaNacionalidadid($persona_nacionalidadId)
    {
        $this->persona_nacionalidadId = $persona_nacionalidadId;

        return $this;
    }

    /**
     * Method to set the value of field persona_localidadId
     *
     * @param integer $persona_localidadId
     * @return $this
     */
    public function setPersonaLocalidadid($persona_localidadId)
    {
        $this->persona_localidadId = $persona_localidadId;

        return $this;
    }

    /**
     * Method to set the value of field persona_telefono
     *
     * @param string $persona_telefono
     * @return $this
     */
    public function setPersonaTelefono($persona_telefono)
    {
        $this->persona_telefono = $persona_telefono;

        return $this;
    }

    /**
     * Method to set the value of field persona_celular
     *
     * @param string $persona_celular
     * @return $this
     */
    public function setPersonaCelular($persona_celular)
    {
        $this->persona_celular = $persona_celular;

        return $this;
    }

    /**
     * Method to set the value of field persona_email
     *
     * @param string $persona_email
     * @return $this
     */
    public function setPersonaEmail($persona_email)
    {
        $this->persona_email = $persona_email;

        return $this;
    }

    /**
     * Method to set the value of field persona_estadoCivilId
     *
     * @param integer $persona_estadoCivilId
     * @return $this
     */
    public function setPersonaEstadocivilid($persona_estadoCivilId)
    {
        $this->persona_estadoCivilId = $persona_estadoCivilId;

        return $this;
    }

    /**
     * Method to set the value of field persona_habilitado
     *
     * @param integer $persona_habilitado
     * @return $this
     */
    public function setPersonaHabilitado($persona_habilitado)
    {
        $this->persona_habilitado = $persona_habilitado;

        return $this;
    }

    /**
     * Method to set the value of field persona_fechaCreacion
     *
     * @param string $persona_fechaCreacion
     * @return $this
     */
    public function setPersonaFechacreacion($persona_fechaCreacion)
    {
        $this->persona_fechaCreacion = $persona_fechaCreacion;

        return $this;
    }

    /**
     * Returns the value of field persona_id
     *
     * @return integer
     */
    public function getPersonaId()
    {
        return $this->persona_id;
    }

    /**
     * Returns the value of field persona_curriculumId
     *
     * @return integer
     */
    public function getPersonaCurriculumid()
    {
        return $this->persona_curriculumId;
    }

    /**
     * Returns the value of field persona_apellido
     *
     * @return string
     */
    public function getPersonaApellido()
    {
        return $this->persona_apellido;
    }

    /**
     * Returns the value of field persona_nombre
     *
     * @return string
     */
    public function getPersonaNombre()
    {
        return $this->persona_nombre;
    }

    /**
     * Returns the value of field persona_fechaNacimiento
     *
     * @return string
     */
    public function getPersonaFechanacimiento()
    {
        return $this->persona_fechaNacimiento;
    }

    /**
     * Returns the value of field persona_tipoDocumentoId
     *
     * @return integer
     */
    public function getPersonaTipodocumentoid()
    {
        return $this->persona_tipoDocumentoId;
    }

    /**
     * Returns the value of field persona_numeroDocumento
     *
     * @return string
     */
    public function getPersonaNumerodocumento()
    {
        return $this->persona_numeroDocumento;
    }

    /**
     * Returns the value of field persona_sexo
     *
     * @return integer
     */
    public function getPersonaSexo()
    {
        return $this->persona_sexo;
    }

    /**
     * Returns the value of field persona_nacionalidadId
     *
     * @return integer
     */
    public function getPersonaNacionalidadid()
    {
        return $this->persona_nacionalidadId;
    }

    /**
     * Returns the value of field persona_localidadId
     *
     * @return integer
     */
    public function getPersonaLocalidadid()
    {
        return $this->persona_localidadId;
    }

    /**
     * Returns the value of field persona_telefono
     *
     * @return string
     */
    public function getPersonaTelefono()
    {
        return $this->persona_telefono;
    }

    /**
     * Returns the value of field persona_celular
     *
     * @return string
     */
    public function getPersonaCelular()
    {
        return $this->persona_celular;
    }

    /**
     * Returns the value of field persona_email
     *
     * @return string
     */
    public function getPersonaEmail()
    {
        return $this->persona_email;
    }

    /**
     * Returns the value of field persona_estadoCivilId
     *
     * @return integer
     */
    public function getPersonaEstadocivilid()
    {
        return $this->persona_estadoCivilId;
    }

    /**
     * Returns the value of field persona_habilitado
     *
     * @return integer
     */
    public function getPersonaHabilitado()
    {
        return $this->persona_habilitado;
    }

    /**
     * Returns the value of field persona_fechaCreacion
     *
     * @return string
     */
    public function getPersonaFechacreacion()
    {
        return $this->persona_fechaCreacion;
    }

    /**
     * Initialize method for model.
     */
    public function initialize()
    {
        $this->belongsTo('persona_curriculumId', 'Curriculum', 'curriculum_id', array('alias' => 'Curriculum'));
        $this->belongsTo('persona_tipoDocumentoId', 'Tipodocumento', 'tipodocumento_id', array('alias' => 'Tipodocumento'));
        $this->belongsTo('persona_nacionalidadId', 'Nacionalidad', 'nacionalidad_id', array('alias' => 'Nacionalidad'));
        $this->belongsTo('persona_localidadId', 'Localidad', 'localidad_id', array('alias' => 'Localidad'));
        $this->belongsTo('persona_estadoCivilId', 'Estadocivil', 'estadoCivil_id', array('alias' => 'Estadocivil'));
    }

    /**
     * Returns table name mapped in the model.
     *
     * @return string
     */
    public function getSource()
    {
        return 'persona';
    }

    /**
     * Allows to query a set of records that match the specified conditions
     *
     * @param mixed $parameters
     * @return Persona[]
     */
    public static function find($parameters = null)
    {
        return parent::find($parameters);
    }

    /**
     * Allows to query the first record that match the specified conditions
     *
     * @param mixed $parameters
     * @return Persona
     */
    public static function findFirst($parameters = null)
    {
        return parent::findFirst($parameters);
    }


    public function validation()
    {
        $this->validate(new Uniqueness(array(
            "field"   => "persona_email",
            "message" => "El Email ya se encuentra registrado."
        )));
        $this->validate(new Uniqueness(array(
            "field"   => "persona_numeroDocumento",
            "message" => "El Nro de Documento ya se encuentra registrado."
        )));
        if ($this->validationHasFailed() == true) {
            return false;
        }
    }
}
