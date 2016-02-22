<div class="container">
    <div class="curriculum-bg-header modal-header " align="left">
        <h1>
            <ins>CURRICULUM</ins>
        </h1>
        <h4>
            <em style=" color:#FFF !important;"> PERFIL PROFESIONAL</em>
        </h4>
        <table class="" width="100%">
            <tr>
                <td align="left ">{{ link_to('persona/edit' ~ persona.getPersonaId(), '<i class="glyphicon glyphicon-print"></i> GENERAR PDF', "class": "btn btn-primary btn-lg") }}
                </td>
                <td align="right">{{ link_to("curriculum/login", "<i class='fa fa-sign-out'></i> SALIR",'class':'btn btn-lg btn-primary') }}</td>
            </tr>
        </table>

    </div>
    <hr>
    {{ content() }}

    {% if persona is defined %}
        <!-- START CERTIFICACION CONTENT -->

        <div class="curriculum-bg-form borde-top" align="center">
            <div class="row">
                <div class="col-md-12">
                    <h3><strong>DATOS PERSONALES</strong></h3>
                    <hr>
                </div>

                <div class="col-md-3 col-md-offset-2">
                    {{ image('files/curriculum/perfil/default.jpg','alt':'Foto de perfil','width':'200','height':'300') }}
                </div>
                {{ form('persona/edit','method':'post') }}
                {{ hidden_field('persona_id','value':persona.getPersonaId()) }}
                <input type="hidden" name="<?php echo $this->security->getTokenKey() ?>"
                       value="<?php echo $this->security->getToken() ?>"/>
                <div class="col-md-6 ">
                    <dl class="dl-horizontal boxed">

                        <dt>Nombre Completo</dt>
                        <dd>{{ persona.getPersonaApellido() ~" "~ persona.getPersonaNombre() }} </dd>
                        <dt>Fecha de Nacimiento</dt>
                        <dd>{{ date('d/m/Y',(persona.getPersonaFechaNacimiento()) | strtotime) }}</dd>
                        <dt>Documento</dt>
                        <dd>{{ persona.obtenerTipoDocumento(persona.getPersonaTipodocumentoid()) }} {{ persona.getPersonaNumerodocumento() }}</dd>
                        <dt>Sexo</dt>
                        <dd>{% if  persona.getPersonaSexo() == 0 %} FEMENINO {% else %} MASCULINO {% endif %}</dd>
                        <dt>Teléfono Celular</dt>
                        <dd>{{ persona.getPersonaCelular() }}</dd>
                        <dt>Teléfono Fijo</dt>
                        <dd>{{ persona.getPersonaTelefono() }}</dd>
                        <dt>Codigo Postal</dt>
                        <dd>{{ persona.getLocalidad().getLocalidadCodigopostal() }}</dd>
                        <dt>Nacionalidad</dt>
                        <dd>{{ persona.getNacionalidad().getNacionalidadNombre() }}</dd>
                        <dt>Provincia</dt>
                        <dd>{{ persona.getLocalidad().getCiudad().getProvincia().getProvinciaNombre() }}</dd>
                        <dt>Ciudad</dt>
                        <dd>{{ persona.getLocalidad().getCiudad().getCiudadNombre() }}</dd>
                        <dt>Dirección</dt>
                        <dd>{{ persona.getLocalidad().getLocalidadDomicilio() }}</dd>
                        <dt>Estado Civil</dt>
                        <dd>{{ persona.obtenerEstadoCivil(persona.getPersonaEstadoCivilid() ) }}</dd>
                        <dt>E-Mail</dt>
                        <dd>{{ persona.getPersonaEmail() }}</dd>
                        <dt>Mi CV Adjunto</dt>
                        <dd>{{ link_to(curriculum.getCurriculumAdjunto(),'DESCARGAR','class':'alert-info','target':'_blank') }}</dd>
                        <dt>Última Modificación</dt>
                        <dd>{{ date('d/m/Y',(curriculum.getCurriculumUltimamodificacion()) | strtotime) }}</dd>
                        <dt></dt>

                    </dl>
                </div>
                <div class="col-md-12">
                    <hr>
                    <i class="glyphicon glyphicon-pencil btn btn-gris btn-icono-submit"></i>{{ submit_button('EDITAR DATOS PERSONALES', "class": "btn btn-gris") }}
                </div>
                {{ end_form() }}
            </div>
        </div>
        {# =======================================================#}
        <hr>
        <div class="curriculum-bg-form borde-top" align="center">
            <div class="row">
                <div class="col-md-12">
                    <h3><strong> EXPERIENCIA LABORAL</strong></h3>
                    <hr>
                </div>
                <div class="col-md-10 col-md-offset-1">

                    {% if experiencias is defined %}
                        {% for unaExperiencia in experiencias %}
                            <div class="col-md-6">
                                <ul id="listado-experiencia-laboral-persona" class="list-unstyled division-curriculum">
                                    <li class="contact_feature li-curriculum-ver">
                                        <h2 class="h4">
                                            <strong>{{ unaExperiencia.getExperienciaEmpresa() }}</strong>
                                            <strong class="pull-right">
                                                {{ link_to('experiencia/edit/' ~ unaExperiencia.getExperienciaId(),
                                                ' <i class="glyphicon glyphicon-pencil"></i>', "class": "alert-info", 'title':'Editar datos') }}
                                                {{ link_to('experiencia/inhabilitar/' ~ unaExperiencia.getExperienciaId(),
                                                '<i class="glyphicon glyphicon-trash"></i> ', "class": "alert-danger",'title':'Elimina el idioma') }}
                                            </strong>

                                        </h2>

                                        <p>
                                            <span><strong>Rubro: </strong>{{ unaExperiencia.getExperienciaRubro() }}</span><br>
                                            <span><strong>Cargo: </strong>{{ unaExperiencia.getExperienciaCargo() }}</span>
                                        </p>

                                        <p>
                                            <span><strong>Localidad: </strong>
                                                {{ unaExperiencia.getProvincia().getProvinciaNombre() }}</span>
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
                                    </li>
                                </ul>
                                <div class="col-md-12">
                                    <hr>
                                </div>
                            </div>

                        {% endfor %}
                    {% endif %}
                </div>
                <div class="col-md-12 ">
                    <hr>
                    {{ link_to('experiencia/new/' ~ persona.getPersonaCurriculumid(),
                    '<i class="glyphicon glyphicon-plus"></i> AGREGAR EXPERIENCIA LABORAL', "class": "btn btn-primary") }}
                </div>
            </div>
        </div>
        {# =======================================================#}
        <hr>
        <div class="curriculum-bg-form borde-top" align="center">
            <div class="row">
                <div class="col-md-12">
                    <h3><strong> FORMACIÓN ACADÉMICA</strong></h3>
                    <hr>
                </div>
                <div class="col-md-10 col-md-offset-1">
                    {% if formacion is defined %}
                        {% for unaFormacion in formacion %}
                            <div class="col-md-6">
                                <ul id="listado-formacion-laboral-persona" class="list-unstyled division-curriculum">
                                    <li class="contact_feature li-curriculum-ver">
                                        <h2 class="h4">
                                            <strong>{{ unaFormacion.getFormacionTitulo() }}</strong>
                                            <strong class="pull-right">
                                                {{ link_to('formacion/edit/' ~ unaFormacion.getFormacionId(),
                                                ' <i class="glyphicon glyphicon-pencil"></i>', "class": "alert-info", 'title':'Editar datos') }}
                                                {{ link_to('formacion/inhabilitar/' ~ unaFormacion.getFormacionId(),
                                                '<i class="glyphicon glyphicon-trash"></i> ', "class": "alert-danger",'title':'Elimina el idioma') }}
                                            </strong>
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
                                <div class="col-md-12">
                                    <hr>
                                </div>
                            </div>
                        {% endfor %}
                    {% endif %}
                </div>
                <div class="col-md-12 ">
                    <hr>
                    {{ link_to('formacion/new/' ~ persona.getPersonaCurriculumid(),
                    '<i class="glyphicon glyphicon-plus"></i> AGREGAR FORMACIÓN ACADÉMICA', "class": "btn btn-primary") }}
                </div>
            </div>
        </div>
        {# =======================================================#}
        <hr>
        <div class="curriculum-bg-form borde-top" align="center">
            <div class="row">
                <div class="col-md-12">
                    <h3><strong> IDIOMAS</strong></h3>
                    <hr>
                </div>
                <div class="col-md-10 col-md-offset-1">
                    {% if idiomas is defined %}
                        {% for unIdioma in idiomas %}
                            <div class="col-md-6">
                                <ul id="listado-formacion-laboral-persona" class="list-unstyled division-curriculum">
                                    <li class="contact_feature li-curriculum-ver">
                                        <h2 class="h4">
                                            <strong>{{ unIdioma.getIdiomasNombre() }}</strong>
                                            <strong class="pull-right">
                                                {{ link_to('idioma/inhabilitar/' ~ unIdioma.getIdiomasId(),
                                                '<i class="glyphicon glyphicon-trash"></i> ', "class": "alert-danger",'title':'Elimina el idioma') }}
                                            </strong>
                                        </h2>

                                        <p>
                                            <span><strong>Nivel: </strong>{{ unIdioma.getNivel().getNivelNombre() }}</span>
                                        </p>
                                    </li>
                                </ul>
                                <div class="col-md-12">
                                    <hr>
                                </div>
                            </div>
                        {% endfor %}
                    {% endif %}
                    <div class="col-md-12">
                        <hr>
                        {{ link_to('idiomas/new/' ~ persona.getPersonaCurriculumid(),
                        '<i class="glyphicon glyphicon-plus"></i> AGREGAR NUEVO IDIOMA', "class": "btn btn-primary") }}
                    </div>
                </div>
            </div>
        </div>
        {# =======================================================#}

        <hr>
        <div class="curriculum-bg-form borde-top" align="center">
            <div class="row">
                <div class="col-md-12">
                    <h3><strong> APTITUDES Y CURSOS</strong></h3>
                    <hr>
                </div>
                <div class="col-md-10 col-md-offset-1">
                    {% if conocimientos is defined %}
                        {% for conocimiento in conocimientos %}
                            <div class="col-md-6">
                                <ul id="listado-formacion-laboral-persona" class="list-unstyled division-curriculum">
                                    <li class="contact_feature li-curriculum-ver">
                                        <h2 class="h4">
                                            <strong>{{ conocimiento.getConocimientosNombre() }}</strong>
                                            <strong class="pull-right">
                                                {{ link_to('conocimientos/inhabilitar/' ~ conocimiento.getConocimientosId(),
                                                '<i class="glyphicon glyphicon-trash"></i> ', "class": "alert-danger",'title':'Elimina el idioma') }}
                                            </strong>
                                        </h2>

                                        <p>
                                            <span><strong>Nivel: </strong>{{ conocimiento.getNivel().getNivelNombre() }}</span>
                                        </p>
                                    </li>
                                </ul>
                                <div class="col-md-12">
                                    <hr>
                                </div>
                            </div>
                        {% endfor %}
                    {% endif %}
                    <div class="col-md-12">
                        <hr>
                        {{ link_to('conocimientos/new/' ~ persona.getPersonaCurriculumid(),
                        '<i class="glyphicon glyphicon-plus"></i> AGREGAR APTITUD/CURSO', "class": "btn btn-primary") }}
                    </div>
                </div>
            </div>
        </div>
        {# =======================================================#}
        <hr>
        <div class="curriculum-bg-form borde-top" align="center">
            <div class="row">
                <div class="col-md-12">
                    <h3><strong> SECTOR DE INTERES</strong></h3>
                    <hr>
                </div>
                <div class="col-md-12">
                    {% if empleos is defined %}
                        {% for unEmpleo in empleos %}
                            <ul id="listado-formacion-laboral-persona" class="list-unstyled division-curriculum">
                                <li class="contact_feature li-curriculum-ver">
                                    <h2 class="h4">
                                        <div class="col-md-3 col-md-offset-2">
                                            <p>
                                                <strong>DEPENDENCIA</strong><br>
                                                {{ unEmpleo.getPuesto().getDependencia().getDependenciaNombre() }}
                                            </p>
                                            <hr>

                                        </div>
                                        <div class="col-md-3">
                                            <p>
                                                <strong>Puesto</strong><br>
                                                {{ unEmpleo.getPuesto().getPuestoNombre() }}
                                            </p>
                                            <hr>
                                        </div>
                                        {% if  unEmpleo.getSectorinteres() != null %}
                                            <div class="col-md-3">
                                                <p>
                                                    <strong>Sector de Interes</strong><br>
                                                    {{ unEmpleo.getSectorinteres().getSectorinteresNombre() }}
                                                </p>
                                                <hr>
                                            </div>
                                        {% endif %}
                                    </h2>
                                    <div align="center">

                                        <p>
                                            <span><strong>Disponibilidad
                                                    Horaria: </strong>{{ unEmpleo.getEmpleoDisponibilidad() }}</span><br>
                                            <span><strong>Posee carnet de
                                                    conducir? </strong>{% if unEmpleo.getEmpleoCarnet() == 1 %}SI{% else %}NO{% endif %}</span>
                                        </p>
                                    </div>
                                </li>
                            </ul>

                        {% endfor %}
                    {% endif %}
                    <div class="col-md-12">
                        <hr>
                        {{ link_to('informatica/new/' ~ persona.getPersonaCurriculumid(),
                        '<i class="glyphicon glyphicon-pencil"></i> EDITAR SECTOR DE INTERES', "class": "btn btn-gris") }}
                    </div>
                </div>
            </div>
        </div>
    {% endif %}
</div>
