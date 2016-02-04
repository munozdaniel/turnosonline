    <div class="container">
        {{ content() }}
    <div class="">
        <!-- START CERTIFICACION HEADING -->
        <div class="heading">
            <h2 class="">Curriculum</h2>
            <div class="pull-right">
                {{ link_to('curriculum/login','class':'btn btn-lg btn-default btn-block btn-volver',
                '<i class="fa fa-undo"></i> VOLVER') }}
            </div>

        </div>
    </div>

        <!-- START CERTIFICACION CONTENT -->
        <div class="about_content ">
            <div class="row">
                <div class="col-lg-12 col-md-12">
                    <h3>DATOS PERSONALES</h3>
                    <dl class="dl-horizontal boxed">

                        <dt>Nombre Completo</dt>
                        <dd>{{ persona.getPersonaApellido() ~ persona.getPersonaNombre()}} </dd>
                        <dt>Fecha de Nacimiento</dt>
                        <dd>{{ persona.getPersonaFechaNacimiento() }}</dd>
                        <dt>Documento</dt>
                        <dd>{{ persona.obtenerTipoDocumento(persona.getPersonaTipodocumentoid())}} {{ persona.getPersonaNumerodocumento() }}</dd>
                        <dt>Sexo</dt>
                        <dd>{% if  persona.getPersonaSexo() == 0%} FEMENINO {% else %} MASCULINO {% endif %}</dd>
                        <dt>Teléfono Celular</dt>
                        <dd>{{ persona.getPersonaCelular() }}</dd>
                        <dt>Teléfono Fijo</dt>
                        <dd>{{ persona.getPersonaTelefono() }}</dd>
                        <dt>Codigo Postal</dt>
                        <dd>{{ arregloLocalidad['localidad_codigoPostal'] }}</dd>
                        <dt>Nacionalidad</dt>
                        <dd>{{ persona.obtenerNacionalidad(persona.getPersonaNacionalidadid()) }}</dd>
                        <dt>Provincia</dt>
                        <dd>{{ arregloLocalidad['provincia_nombre'] }}</dd>
                        <dt>Ciudad</dt>
                        <dd>{{ arregloLocalidad['ciudad_nombre'] }}</dd>
                        <dt>Dirección</dt>
                        <dd>{{ arregloLocalidad['localidad_domicilio'] }}</dd>
                        <dt>Estado Civil</dt>
                        <dd>{{ persona.obtenerEstadoCivil(persona.getPersonaEstadoCivilid() ) }}</dd>
                        <dt>E-Mail</dt>
                        <dd>{{ persona.getPersonaEmail() }}</dd>
                        <dt>Mi CV Adjunto</dt>
                        <dd></dd>
                        <dt>Última Modificación</dt>
                        <dd>18/dic/2015</dd>
                        <dt></dt>
                        {{ link_to('persona/edit' ~ persona.getPersonaId(), '<i class="glyphicon glyphicon-edit"></i> Editar', "class": "btn btn-info") }}
                    </dl>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-12 col-md-12">
                    <h3>EXPERIENCIA LABORAL <small>idCurriculum (borrar) ; {{ persona.getPersonaCurriculumid() }}</small></h3>
                    {{ link_to('experiencia/edit' ~ persona.getPersonaCurriculumid(),
                    '<i class="glyphicon glyphicon-edit"></i> Editar', "class": "btn btn-info") }}
                    {{ link_to('experiencia/new' ~ persona.getPersonaCurriculumid(),
                    '<i class="glyphicon glyphicon-edit"></i> Agregar', "class": "btn btn-info") }}
                    {% if experiencias is defined %}
                        {% for unaExperiencia in experiencias %}
                                {{ unaExperiencia.getExperienciaEmpresa() }}
                        {% endfor %}
                    {% endif %}
                </div>
            </div>
            <div class="row">
                <div class="col-lg-12 col-md-12">
                    <h3>ESTUDIOS</h3>
                    {{ link_to('formacion/edit' ~ persona.getPersonaId(),
                    '<i class="glyphicon glyphicon-edit"></i> Editar', "class": "btn btn-info") }}
                    {{ link_to('formacion/new' ~ persona.getPersonaId(),
                    '<i class="glyphicon glyphicon-edit"></i> Agregar', "class": "btn btn-info") }}
                </div>
            </div>
            <div class="row">
                <div class="col-lg-12 col-md-12">
                    <h3>IDIOMAS</h3>
                    {{ link_to('idiomas/edit' ~ persona.getPersonaId(),
                    '<i class="glyphicon glyphicon-edit"></i> Editar', "class": "btn btn-info") }}
                    {{ link_to('idiomas/new' ~ persona.getPersonaId(),
                    '<i class="glyphicon glyphicon-edit"></i> Agregar', "class": "btn btn-info") }}
                </div>
            </div>
            <div class="row">
                <div class="col-lg-12 col-md-12">
                    <h3>CONOCIMIENTOS INFORMÁTICOS</h3>
                    {{ link_to('informatica/edit' ~ persona.getPersonaId(),
                    '<i class="glyphicon glyphicon-edit"></i> Editar', "class": "btn btn-info") }}
                    {{ link_to('informatica/new' ~ persona.getPersonaId(),
                    '<i class="glyphicon glyphicon-edit"></i> Agregar', "class": "btn btn-info") }}
                </div>
            </div>
            <div class="row">
                <div class="col-lg-12 col-md-12">
                    <h3>SECTOR DE INTERES</h3>
                    {{ link_to('informatica/edit' ~ persona.getPersonaId(),
                    '<i class="glyphicon glyphicon-edit"></i> Editar', "class": "btn btn-info") }}
                    {{ link_to('informatica/new' ~ persona.getPersonaId(),
                    '<i class="glyphicon glyphicon-edit"></i> Agregar', "class": "btn btn-info") }}
                </div>
            </div>
        </div>

    </div>
