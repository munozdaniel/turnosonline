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
    {% if persona is defined %}
    <!-- START CERTIFICACION CONTENT -->
    <div class="about_content ">
        <div class="row">
            <div class="col-lg-12 col-md-12">
                <h3>DATOS PERSONALES</h3>
                <dl class="dl-horizontal boxed">

                    <dt>Nombre Completo</dt>
                    <dd>{{ persona.getPersonaApellido() ~ persona.getPersonaNombre() }} </dd>
                    <dt>Fecha de Nacimiento</dt>
                    <dd>{{ persona.getPersonaFechaNacimiento() }}</dd>
                    <dt>Documento</dt>
                    <dd>{{ persona.obtenerTipoDocumento(persona.getPersonaTipodocumentoid()) }} {{ persona.getPersonaNumerodocumento() }}</dd>
                    <dt>Sexo</dt>
                    <dd>{% if  persona.getPersonaSexo() == 0 %} FEMENINO {% else %} MASCULINO {% endif %}</dd>
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
                <h3>
                    EXPERIENCIA LABORAL
                </h3>

                {% if experiencias is defined %}
                    {% for unaExperiencia in experiencias %}
                        <div class="col-md-6">
                        <ul id="listado-experiencia-laboral-persona" class="list-unstyled">
                            <li class="contact_feature" style="margin-bottom:0px">
                                <h2 class="h4">
                                    {{ unaExperiencia.getExperienciaEmpresa() }}
                                    <small class="pull-right">
                                        {{ link_to('experiencia/edit/' ~ persona.getPersonaCurriculumid(),
                                        '<i class="glyphicon glyphicon-edit"></i> Editar', "class": "") }}
                                    </small>
                                </h2>
                                <p class="">
                                     <span class=""><strong>Rubro: </strong>{{ unaExperiencia.getExperienciaRubro() }}</span><br>
                                    <span class=""><strong>Cargo: </strong>{{ unaExperiencia.getExperienciaCargo() }}</span>
                                </p>
                                <p class="">
                                    <span class=""><strong>Localidad: </strong> {{ unaExperiencia.getExperienciaProvinciaid() }}</span>
                                </p>

                                <p class="">
                                    <i class="fa fa-clock-o"></i><span class=""> Periodo {{date('d/m/Y',( unaExperiencia.getExperienciaFechainicio()) | strtotime) }}</span>
                                    - <span class="">{% if unaExperiencia.getExperienciaFechaActual() == 1 %} Trabajando actualmente {% else %}  {{date('d/m/Y',(unaExperiencia.getExperienciaFechafinal()) | strtotime) }}  {% endif %}</span></p>
                                <p>
                                    <em class="">{{ unaExperiencia.getExperienciaTareas() }}</em>
                                </p>
                            </li>

                        </ul>
                        </div>
                    {% endfor %}
                {% endif %}
                <div class="col-md-12 ">
                    {{ link_to('experiencia/new/' ~ persona.getPersonaCurriculumid(),
                    '<i class="glyphicon glyphicon-edit"></i> Agregar', "class": "btn btn-info") }}
                </div>

            </div>
        </div>
        <div class="row">
            <div class="col-lg-12 col-md-12">
                <h3>ESTUDIOS</h3>
                {% if formacion is defined %}
                    {% for unaFormacion in formacion %}
                        <div class="col-md-6">
                            <ul id="listado-experiencia-laboral-persona" class="list-unstyled">
                                <li class="contact_feature" style="margin-bottom:0px">
                                    <h2 class="h4">
                                        {{ unaFormacion.getFormacionTitulo() }}
                                        <small class="pull-right">
                                            {{ link_to('formacion/edit/' ~ persona.getPersonaId(),
                                            '<i class="glyphicon glyphicon-edit"></i> Editar', "class": "") }}
                                        </small>
                                    </h2>
                                    <p class="">
                                        <span class=""><strong>Institución: </strong>{{ unaFormacion.getFormacionInstitucion() }}</span><br>
                                        <span class=""><strong>Nivel: </strong>{{ unaFormacion.getGrado().getGradoNombre() }}</span>
                                    </p>
                                    <p class="">
                                        <span class=""><strong>Estado: </strong> {{ unaFormacion.getEstado().getEstadoNombre() }}</span>
                                    </p>

                                    <p class="">
                                        <i class="fa fa-clock-o"></i><span class=""> Periodo {{date('d/m/Y',( unaFormacion.getFormacionFechainicio()) | strtotime) }}</span>
                                        - <span class="">{% if unaFormacion.getFormacionFechaActual() == 1 %} Trabajando actualmente {% else %}  {{date('d/m/Y',(unaFormacion.getFormacionFechafinal()) | strtotime) }}  {% endif %}</span></p>

                                </li>

                            </ul>
                        </div>
                    {% endfor %}
                {% endif %}

                {{ link_to('formacion/new/' ~  persona.getPersonaCurriculumid() ,
                '<i class="glyphicon glyphicon-edit"></i> Agregar', "class": "btn btn-info") }}
            </div>
        </div>
        <div class="row">
            <div class="col-lg-12 col-md-12">
                <h3>IDIOMAS</h3>
                {{ link_to('idiomas/edit/' ~ persona.getPersonaId(),
                '<i class="glyphicon glyphicon-edit"></i> Editar', "class": "btn btn-info") }}
                {{ link_to('idiomas/new/' ~ persona.getPersonaCurriculumid(),
                '<i class="glyphicon glyphicon-edit"></i> Agregar', "class": "btn btn-info") }}
            </div>
        </div>
        <div class="row">
            <div class="col-lg-12 col-md-12">
                <h3>CONOCIMIENTOS INFORMÁTICOS</h3>
                {{ link_to('informatica/edit' ~ persona.getPersonaId(),
                '<i class="glyphicon glyphicon-edit"></i> Editar', "class": "btn btn-info") }}
                {{ link_to('informatica/new/' ~ persona.getPersonaCurriculumid(),
                '<i class="glyphicon glyphicon-edit"></i> Agregar', "class": "btn btn-info") }}
            </div>
        </div>
        <div class="row">
            <div class="col-lg-12 col-md-12">
                <h3>SECTOR DE INTERES</h3>
                {{ link_to('informatica/edit' ~ persona.getPersonaId(),
                '<i class="glyphicon glyphicon-edit"></i> Editar', "class": "btn btn-info") }}
                {{ link_to('informatica/new/' ~ persona.getPersonaCurriculumid(),
                '<i class="glyphicon glyphicon-edit"></i> Agregar', "class": "btn btn-info") }}
            </div>
        </div>
    </div>
    {% endif %}
</div>
