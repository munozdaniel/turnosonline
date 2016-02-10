<div class="container">
    <div class="curriculum-bg-header modal-header " align="left">
        <h1>
            <ins>Curriculum</ins>
            <br>

            <h3>
                <small style=" color:#FFF !important;">Perfil profesional</small>
            </h3>
        </h1>
        <table width="100%">
            <tr>
                <td align="right">{{ link_to("curriculum/login", "<i class='fa fa-clone'></i> SALIR ",'class':'btn btn-large btn-blue') }}</td>
            </tr>
        </table>
    </div>
    <hr>
    {{ content() }}

    {% if persona is defined %}
        <!-- START CERTIFICACION CONTENT -->
        <div class="curriculum-bg-form borde-top" align="center">
            <div class="row">
                <h3 class="subtitle-curriculum">DATOS PERSONALES</h3>
                <dl class="dl-horizontal boxed">
                    <div class="col-md-6">
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
                    </div>
                    <div class="col-md-6">

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
                    </div>
                    <div class="col-md-12">
                        <hr>
                        {{ link_to('persona/edit' ~ persona.getPersonaId(), '<i class="glyphicon glyphicon-edit"></i> Editar Datos', "class": "btn btn-info") }}
                        {{ link_to('persona/edit' ~ persona.getPersonaId(), '<i class="fa fa-file"></i> Subir Curriculum PDF', "class": "btn btn-info") }}
                    </div>
                </dl>
            </div>
        </div>
        {# =======================================================#}
        <hr>
        <div class="curriculum-bg-form borde-top">
            <div class="row">
                <div class="col-lg-12 col-md-12">
                    <h3 class="subtitle-curriculum">
                        EXPERIENCIA LABORAL
                    </h3>

                    {% if experiencias is defined %}
                        {% for unaExperiencia in experiencias %}
                            <div class="col-md-6">
                                <ul id="listado-experiencia-laboral-persona" class="list-unstyled division-curriculum">
                                    <li class="contact_feature" style="margin-bottom:0px; text-align: left">
                                        <h2 class="h4">
                                            <strong>{{ unaExperiencia.getExperienciaEmpresa() }}</strong>
                                            <small class="pull-right">
                                                {{ link_to('experiencia/edit/' ~ unaExperiencia.getExperienciaId(),
                                                '<i class="glyphicon glyphicon-edit"></i> Editar', "class": "") }}
                                            </small>
                                        </h2>
                                        <p>
                                            <span><strong>Rubro: </strong>{{ unaExperiencia.getExperienciaRubro() }}</span><br>
                                            <span><strong>Cargo: </strong>{{ unaExperiencia.getExperienciaCargo() }}</span>
                                        </p>

                                        <p>
                                            <span><strong>Localidad: </strong> {{ unaExperiencia.getExperienciaProvinciaid() }}</span>
                                        </p>

                                        <p>
                                            <i class="fa fa-clock-o"></i><span> Periodo {{ date('d/m/Y',( unaExperiencia.getExperienciaFechainicio()) | strtotime) }}</span>
                                            -
                                            <span>{% if unaExperiencia.getExperienciaFechaActual() == 1 %} Trabajando actualmente {% else %}  {{ date('d/m/Y',(unaExperiencia.getExperienciaFechafinal()) | strtotime) }}  {% endif %}</span>
                                        </p>

                                        <p>
                                        <hr>
                                        <span><strong>Tareas: </strong></span>
                                        <em>{{ unaExperiencia.getExperienciaTareas() }}</em>
                                        </p>
                                    </li>
                                </ul>

                            </div>
                            {% if loop.index % 2 == 0 %}
                                <div class="col-md-12">
                                    <hr>
                                </div>
                            {% endif %}
                        {% endfor %}
                    {% endif %}
                    <div class="col-md-12 ">
                        <hr>
                        {{ link_to('experiencia/new/' ~ persona.getPersonaCurriculumid(),
                        '<i class="glyphicon glyphicon-edit"></i> Agregar', "class": "btn btn-info") }}
                    </div>

                </div>
            </div>
        </div>
        {# =======================================================#}
        <hr>
        <div class="curriculum-bg-form borde-top">

            <div class="row">
                <div class="col-lg-12 col-md-12">
                    <h3 class="subtitle-curriculum">ESTUDIOS</h3>
                    {% if formacion is defined %}
                        {% for unaFormacion in formacion %}
                            <div class="col-md-6">
                                <ul id="listado-formacion-laboral-persona" class="list-unstyled division-curriculum">
                                    <li class="contact_feature" style="margin-bottom:0px; text-align: left">
                                        <h2 class="h4">
                                            <strong>{{ unaFormacion.getFormacionTitulo() }}</strong>
                                            <small class="pull-right">
                                                {{ link_to('formacion/edit/' ~ unaFormacion.getFormacionId(),
                                                '<i class="glyphicon glyphicon-edit"></i> Editar', "class": "") }}
                                            </small>
                                        </h2>
                                        <p>
                                            <span><strong>Institución: </strong>{{ unaFormacion.getFormacionInstitucion() }}</span><br>
                                            <span><strong>Nivel: </strong>{{ unaFormacion.getGrado().getGradoNombre() }}</span>
                                        </p>

                                        <p>
                                            <span><strong>Estado: </strong> {{ unaFormacion.getEstado().getEstadoNombre() }}</span>
                                        </p>

                                        <p>
                                            <i class="fa fa-clock-o"></i><span> Periodo {{ date('d/m/Y',( unaFormacion.getFormacionFechainicio()) | strtotime) }}</span>
                                            -
                                            <span>{% if unaFormacion.getFormacionFechaActual() == 1 %} Trabajando actualmente {% else %}  {{ date('d/m/Y',(unaFormacion.getFormacionFechafinal()) | strtotime) }}  {% endif %}</span>
                                        </p>
                                    </li>
                                </ul>
                            </div>
                            {% if loop.index % 2 == 0 %}
                                <div class="col-md-12">
                                    <hr>
                                </div>
                            {% endif %}
                        {% endfor %}
                    {% endif %}
                    <div class="col-md-12 ">
                        <hr>
                        {{ link_to('formacion/new/' ~ persona.getPersonaCurriculumid(),
                        '<i class="glyphicon glyphicon-edit"></i> Agregar', "class": "btn btn-info") }}
                    </div>
                </div>
            </div>
        </div>
        {# =======================================================#}
        <hr>
        <div class="curriculum-bg-form borde-top">

            <div class="row">
                <div class="col-lg-12 col-md-12">
                    <h3 class="subtitle-curriculum">IDIOMAS</h3>
                    {% if idiomas is defined %}
                        {% for unIdioma in idiomas %}
                            <div class="col-md-6">
                                <ul id="listado-idiomas-laboral-persona" class="list-unstyled division-curriculum">
                                    <li class="contact_feature" style="margin-bottom:0px; text-align: left">
                                        <h2 class="h4">
                                            <strong>{{ unIdioma.getIdiomasNombre() }}</strong>
                                            <small class="pull-right">
                                                {{ link_to('formacion/edit/' ~ unIdioma.getIdiomasId(),
                                                '<i class="glyphicon glyphicon-edit"></i> Editar', "class": "") }}
                                            </small>
                                        </h2>
                                        <p>
                                            <span><strong>Nivel: </strong>{{ unIdioma.getNivel().getNivelNombre() }}</span>
                                        </p>
                                    </li>
                                </ul>
                            </div>
                            {% if loop.index % 2 == 0 %}
                                <div class="col-md-12">
                                    <hr>
                                </div>
                            {% endif %}
                        {% endfor %}
                    {% endif %}
                    <div class="col-md-12">
                        <hr>
                        {{ link_to('idiomas/new/' ~ persona.getPersonaCurriculumid(),
                        '<i class="glyphicon glyphicon-edit"></i> Agregar', "class": "btn btn-info") }}
                    </div>
                </div>
            </div>
        </div>
        {# =======================================================#}

        <hr>
        <div class="curriculum-bg-form borde-top">

            <div class="row">
                <div class="col-lg-12 col-md-12">
                    <h3 class="subtitle-curriculum">CONOCIMIENTOS INFORMÁTICOS</h3>
                    {% if informatica is defined %}
                        {% for info in informatica %}
                            <div class="col-md-6">
                                <ul id="listado-informatica-laboral-persona" class="list-unstyled division-curriculum">
                                    <li class="contact_feature" style="margin-bottom:0; text-align: left">
                                        <h2 class="h4">
                                            <strong>{{ info.getInformaticaNombre() }}</strong>
                                            <small class="pull-right">
                                                {{ link_to('formacion/edit/' ~ unIdioma.getIdiomasId(),
                                                '<i class="glyphicon glyphicon-edit"></i> Editar', "class": "") }}
                                            </small>
                                        </h2>
                                        <p>
                                            <span><strong>Nivel: </strong>{{ info.getNivel().getNivelNombre() }}</span>
                                        </p>
                                    </li>
                                </ul>
                            </div>
                            {% if loop.index % 2 == 0 %}
                                <div class="col-md-12">
                                    <hr>
                                </div>
                            {% endif %}
                        {% endfor %}
                    {% endif %}
                    <div class="col-md-12">
                        <hr>
                        {{ link_to('informatica/new/' ~ persona.getPersonaCurriculumid(),
                        '<i class="glyphicon glyphicon-edit"></i> Agregar', "class": "btn btn-info") }}
                    </div>
                </div>
            </div>
        </div>
        {# =======================================================#}
        <hr>
        <div class="curriculum-bg-form borde-top">

            <div class="row">
                <div class="col-lg-12 col-md-12">
                    <h3 class="subtitle-curriculum">SECTOR DE INTERES</h3>
                    {% if idiomas is defined %}
                        {% for unIdioma in idiomas %}
                            <div class="col-md-6">
                            </div>
                            {% if loop.index % 2 == 0 %}
                                <div class="col-md-12">
                                    <hr>
                                </div>
                            {% endif %}
                        {% endfor %}
                    {% endif %}
                    <div class="col-md-12">
                        <hr>
                        {{ link_to('informatica/new/' ~ persona.getPersonaCurriculumid(),
                        '<i class="glyphicon glyphicon-edit"></i> Agregar', "class": "btn btn-info") }}
                    </div>
                </div>
            </div>
        </div>
    {% endif %}
</div>
