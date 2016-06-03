<section id="onepage" class="admin bg_line">
    <div class="container ">
        <div align="center">
            <div class="curriculum-bg-header modal-header " align="left">
                <h1>
                    <ins>GUÍA RÁPIDA PARA SOLICITAR TURNOS ONLINE</ins>
                    <br>
                </h1>
                <h3>
                    <small><em style=" color:#FFF !important;"> Por cualquier consulta puede llamarnos al (0299)
                                4433978 Int 10</em>
                    </small>
                </h3>
                <table class="" width="100%">
                    <tr>
                        <td align="right">{{ link_to("index", "<i class='fa fa-sign-out'></i> SALIR",'class':'btn btn-lg btn-primary') }}</td>
                    </tr>
                </table>

            </div>
            <hr>
            {{ content() }}
            <div class="curriculum-bg-form borde-top">
                <div class="row">
                    <div class="col-md-6 col-md-offset-1" align="left">
                        <article class="" id="">
                            <h3>Estimados Lectores</h3>

                            <div class="bodycopy">
                                <p>Desde Atención a Afiliados queremos informarles que <strong>Próximamente</strong>
                                    vamos a
                                    estar habilitando
                                    un nuevo servicio para que puedan solicitar turnos desde la comodidad de su casa, a
                                    través
                                    de cualquier dispositivo
                                    con acceso a internet.
                                </p>

                                <p> En esta sección vamos a mostrarles los pasos a seguir para poder obtener un
                                    turno.</p>
                            </div>
                        </article>

                    </div>
                    <div class="col-md-5">
                        {{ image('img/turnos/presentacion/pres_bg.jpg','heigth':'150','width':'325') }}
                    </div>
                </div>
            </div>
            <div class="curriculum-bg-form borde-top">
                <div class="row">
                    <div class=" col-md-12">
                        <div class=" col-md-6">
                            <h1>
                                GUÍA BÁSICA
                            </h1>

                            <p><strong>Seleccione un paso para ver la explicación</strong></p>

                            <hr>
                            <ul id="ul">
                                <li id="paso-1" class="hr cursor-hand">
                                    <button type="button" class="btn btn-blue btn-circle margin-right-5">
                                        1º
                                    </button>
                                    <a class="hover-background " onmouseover="cambiarInstruccion(1)">Verifique cuando
                                        estará habilitado el período para solicitar turnos.</a>
                                </li>
                                <li id="paso-2" class="hr cursor-hand">
                                    <button type="button" class="btn btn-blue btn-circle margin-right-5">2º</button>
                                    <a class="hover-background" onmouseover="cambiarInstruccion(2)"> Cuando esté habilitado dicho período, se habilitará el botón para solicitar turnos.</a>
                                </li>
                                <li id="paso-3" class="hr cursor-hand">
                                    <button type="button" class="btn btn-blue btn-circle margin-right-5">
                                        3º
                                    </button>
                                    <a class="hover-background" onmouseover="cambiarInstruccion(3)">Complete el formulario con sus datos personales.</a>
                                </li>
                                <li id="paso-4" class="hr cursor-hand">
                                    <button type="button" class="btn btn-blue btn-circle margin-right-5">
                                        4º
                                    </button>
                                    <a class="hover-background" onmouseover="cambiarInstruccion(4)">Nuestros empleados
                                        analizarán su petición.</a>
                                </li>
                                <li id="paso-5" class="hr cursor-hand">
                                    <button type="button" class="btn btn-blue btn-circle margin-right-5">
                                        5º
                                    </button>
                                    <a class="hover-background" onmouseover="cambiarInstruccion(5)"> Confirme el correo
                                        que le fue enviado.</a>
                                </li>
                                <li id="paso-6" class="cursor-hand">
                                    <button type="button" class="btn btn-blue btn-circle margin-right-5">
                                        6º
                                    </button>
                                    <a class="hover-background" onmouseover="cambiarInstruccion(6)">
                                        Asistencia</a>
                                </li>
                            </ul>
                        </div>
                        <div class="col-md-6">
                            <div id="paso_dinamico" align="center">
                                <div id="contenido-0">
                                    <h3><br></h3>

                                    {{ image('img/turnos/presentacion/2.png') }}
                                </div>
                                <div id="contenido-1" class="ocultar">
                                    <h3> Verificar Período para Solicitar Turnos</h3>

                                    <p> En la sección
                                        <ins>Servicios</ins>
                                        se dispondrá un enlace para ver el calendario de períodos.
                                    </p>
                                    {{ image('img/turnos/presentacion/1.jpg') }}
                                    <br>
                                    {{ link_to('turnos/calendario','VER CALENDARIO','class':'btn btn-primary','target':'_blank') }}
                                </div>

                                <div id="contenido-2" class="ocultar">
                                    <h3> Servicio Habilitado</h3>

                                    <p>Cuando el período esté disponible se habilitará el botón
                                        <ins>Solicitar Turno</ins>
                                    </p>
                                    {{ image('img/turnos/presentacion/2.png') }}
                                    <br>
                                    {{ link_to('index#service','VER SERVICIO','class':'btn btn-primary','target':'_blank') }}
                                </div>

                                <div id="contenido-3" class="ocultar">
                                    <h3> Completar Formulario</h3>

                                    <p>Al hacer click en el botón del Paso 2 podrá acceder a un formulario en el que
                                        deberá
                                        cargar
                                        sus datos personales.
                                        <strong>Es importante que utilice un correo válido</strong></p>
                                    {{ image('img/turnos/presentacion/3.jpg') }}
                                </div>

                                <div id="contenido-4" class="ocultar">
                                    <h3> Espera del Análisis</h3>

                                    <p>Su pedido será analizado por nuestros agentes y se le enviará una respuesta al
                                        correo ingresado en el Paso 3. </p>
                                    {{ image('img/turnos/presentacion/4.jpg') }}
                                    <br>
                                </div>

                                <div id="contenido-5" class="ocultar">
                                    <h3> Confirmar Correo</h3>

                                    <p> En el correo enviado por nuestros empleados encontrará un enlace para que
                                        pueda
                                        confirmar su
                                        asistencia
                                        <strong>(en un plazo determinado)</strong>, al hacerlo se generará un código y se le indicará las fechas para su asistencia. <strong>ES IMPORTANTE QUE GUARDE EL CÓDIGO.</strong>
                                    </p>
                                    {{ image('img/turnos/presentacion/5.jpg') }}
                                </div>
                                <div id="contenido-6" class="ocultar">
                                    <h3> Asistencia</h3>

                                    <p> Cuando asista a nuestra institución deberá ingresar su código en la <strong>terminal
                                            de
                                            afiliados</strong> para que lo podamos atender.</p>
                                    {{ image('img/turnos/presentacion/6.jpg') }}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="curriculum-bg-form borde-top">
                <div class="row">
                    <div class=" col-md-6 col-md-offset-3">
                        <h1>¿NO TIENE LA POSIBILIDAD DE ACCEDER VIA ONLINE?</h1>
                        <br>
                        <h4>En nuestra Institución dispondremos de una terminal para que pueda solicitar un turno.</h4>
                    </div>

                    <div class="col-md-12">
                        <hr>
                        <div class="col-md-4">
                            <div align="right">
                                {{ image('img/turnos/presentacion/6.jpg','alt':'persona terminal','align':'center','width':'350','height':'200') }}
                            </div>
                        </div>
                        <div class="col-md-8">
                            <ul style="text-align: left">
                                <li class="hr cursor-hand">
                                    <button type="button" class="btn btn-warning btn-circle margin-right-5">
                                        1º
                                    </button>
                                    Acceda a la terminal.
                                </li>
                                <li class="hr cursor-hand">
                                    <button type="button" class="btn btn-warning btn-circle margin-right-5">
                                        2º
                                    </button>
                                    Ingrese los datos solicitados.
                                </li>
                                <li class="hr cursor-hand">
                                    <button type="button" class="btn btn-warning btn-circle margin-right-5">
                                        3º
                                    </button>
                                    Transcurridas 48hs, usted deberá acercarse a nuestra institución o llamar al 0299-4433978 int 10 para confirmar su asistencia.
                                </li>
                                <li class="hr cursor-hand">
                                    <button type="button" class="btn btn-warning btn-circle margin-right-5">
                                        4º
                                    </button>
                                        Deberá acercarse a nuestra Institución entre las fechas informadas por nuestros agentes para comenzar los trámites del préstamo personal.
                                </li>
                            </ul>
                        </div>

                    </div>


                </div>
            </div>
        </div>
    </div>
</section>

<script>
    function cambiarInstruccion(expression) {
        $("#contenido-0").empty();
        var contenido1 = $("#contenido-1");
        var contenido2 = $("#contenido-2");
        var contenido3 = $("#contenido-3");
        var contenido4 = $("#contenido-4");
        var contenido5 = $("#contenido-5");
        var contenido6 = $("#contenido-6");
        switch (expression) {
            case 1:
                contenido1.show(700);
                contenido2.hide(700);
                contenido3.hide(700);
                contenido4.hide(700);
                contenido5.hide(700);
                contenido6.hide(700);
                break;
            case 2:
                contenido1.hide(700);
                contenido2.show(700);
                contenido3.hide(700);
                contenido4.hide(700);
                contenido5.hide(700);
                contenido6.hide(700);
                break;
            case 3:
                contenido1.hide(700);
                contenido2.hide(700);
                contenido3.show(700);
                contenido4.hide(700);
                contenido5.hide(700);
                contenido6.hide(700);
                break;
            case 4:
                contenido1.hide(700);
                contenido2.hide(700);
                contenido3.hide(700);
                contenido4.show(700);
                contenido5.hide(700);
                contenido6.hide(700);
                break;
            case 5:
                contenido1.hide(700);
                contenido2.hide(700);
                contenido3.hide(700);
                contenido4.hide(700);
                contenido5.show(700);
                contenido6.hide(700);
                break;
            case 6:
                contenido1.hide(700);
                contenido2.hide(700);
                contenido3.hide(700);
                contenido4.hide(700);
                contenido5.hide(700);
                contenido6.show(700);
                break;
        }

    }
</script>