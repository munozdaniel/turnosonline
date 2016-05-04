<ul id="menu">
    <li data-menuanchor="first"><a href="#first">First slide</a></li>
    <li data-menuanchor="second"><a href="#second">Second slide</a></li>
    <li data-menuanchor="third"><a href="#third">Third slide</a></li>
</ul>

<div id="contenedor-presentacion">

    <div class="ms-left">
        <div class="ms-section section1-izq" id="Titulo-izq">
            <div class="content" align="center">
                <h1>TURNOS ONLINE <br>PARA PRÉSTAMOS PERSONALES</h1>

                <h3>Próximamente</h3>
                <br>
                {{ image('img/turnos/presentacion/10.png') }}
            </div>
        </div>

        <div class="ms-section section2-izq" id="left2">
            <div class="content">

                <h1> Guía Rápida
                    <br>
                    <small>A continuación te mostramos los pasos a seguir para solicitar un turno online.</small>
                </h1>
                <hr>
                <ul>
                    <li id="paso-1" class="hr cursor-hand">
                        <button type="button" class="btn btn-blue btn-circle margin-right-5">
                            1º
                        </button>
                        <a class="hover-background font-blanco" onmouseover="cambiarInstruccion(1)">Verifique cuando
                            estará habilitado el periodo para solicitar turno.</a>
                    </li>
                    <li id="paso-2" class="hr cursor-hand">
                        <button type="button" class="btn btn-blue btn-circle margin-right-5">
                            2º
                        </button>
                        <a class="hover-background font-blanco" onmouseover="cambiarInstruccion(2)"> Si el período se
                            encuentra disponible, se habilitará el botón para solicitar turnos.</a>
                    </li>
                    <li id="paso-3" class="hr cursor-hand">
                        <button type="button" class="btn btn-blue btn-circle margin-right-5">
                            3º
                        </button>
                        <a class="hover-background font-blanco" onmouseover="cambiarInstruccion(3)">Completa con tus
                            datos personales el formulario.</a>
                    </li>
                    <li id="paso-4" class="hr cursor-hand">
                        <button type="button" class="btn btn-blue btn-circle margin-right-5">
                            4º
                        </button>
                        <a class="hover-background font-blanco" onmouseover="cambiarInstruccion(4)">Nuestros empleados
                            analizarán su estado de deuda y se le enviará un correo con la respuesta
                            correspondiente.</a>
                    </li>
                    <li id="paso-5" class="hr cursor-hand">
                        <button type="button" class="btn btn-blue btn-circle margin-right-5">
                            5º
                        </button>
                        <a class="hover-background font-blanco" onmouseover="cambiarInstruccion(5)"> Confirme el correo
                            enviado por nuestros empleados.</a>
                    </li>
                    <li id="paso-6" class="cursor-hand">
                        <button type="button" class="btn btn-blue btn-circle margin-right-5">
                            6º
                        </button>
                        <a class="hover-background font-blanco" onmouseover="cambiarInstruccion(6)">
                            Asistencia</a>
                    </li>
                </ul>
                <div align="center"><a href="#third"><i class="fa fa-5x fa-arrow-down"></i></a></div>

            </div>


        </div>

        <div class="ms-section   section2-izq font-blanco" id="left3" align="center">
            {#RIGHT LEFT#}
            <h1>NO TIENES LA POSIBILIDAD DE ACCEDER VIA ONLINE? <br><strong>NO TE PREOCUPES</strong></h1>
            <h4>Te brindamos una terminal para que vengas personalmente a solicitar el turno.</h4>
        </div>
    </div>

    <div class="ms-right">
        <div class="ms-section font-gotham" id="right1">

            <div class="letter">
                <p>Estimados Lectores,</p>

                <p>
                    Desde Atención a Afiliados queremos hacerles llegar información de las nuevas formas de obtener
                    información de calidad, ante la necesidad de contar con mejores modalidades tecnológicas efectivas
                    para nuestros afiliados y poder brindar un mejor funcionamiento, de excelente calidad de servicios y
                    de información adecuada.
                </p>

                <p>
                    Ver Guía
                </p>
            </div>
        </div>

        <div class="ms-section fondo-blanco-circles" id="right2">
            <div align="center"><a href="#first"><i class="fa fa-5x fa-arrow-up" style="color: rgba(0, 0, 0, 0.37)"></i></a>
            </div>

            <div id="paso_dinamico" align="center">
                <div id="contenido-0">

                    <p><strong>Selecciona un paso para ver la explicación</strong></p>

                </div>
                <div id="contenido-1" class="ocultar">
                    <h3> Verificar Periodo para Solicitar Turnos</h3>

                    <p> En la sección
                        <ins>Servicios</ins>
                        se dispondrá un enlace para ver el calendario de periodos.
                    </p>
                    {{ image('img/turnos/presentacion/1.jpg') }}
                    <br>
                    {{ link_to('turnos/calendario','VER CALENDARIO','class':'btn btn-primary','target':'_blank') }}
                </div>

                <div id="contenido-2" class="ocultar">
                    <h3> Servicio Habilitado</h3>

                    <p>Cuando el período esté disponible se habilitará el boton
                        <ins>Solicitar Turno</ins>
                    </p>
                    {{ image('img/turnos/presentacion/2.png') }}
                    <br>
                    {{ link_to('index#service','VER SERVICIO','class':'btn btn-primary','target':'_blank') }}
                </div>

                <div id="contenido-3" class="ocultar">
                    <h3> Completar Formulario</h3>

                    <p>Al hacer click en el botón del paso 2 podremos acceder a un formulario en el que deberás cargar
                        tus datos personales.
                        <strong>Es importante que utilice un correo válido</strong></p>
                    {{ image('img/turnos/presentacion/3.jpg') }}
                </div>

                <div id="contenido-4" class="ocultar">
                    <h3> Espera del Análisis</h3>

                    <p>Su pedido será analizado por nuestro equipo y se le enviará una respuesta al correo. </p>
                    {{ image('img/turnos/presentacion/4.jpg') }}
                    <br>
                </div>

                <div id="contenido-5" class="ocultar">
                    <h3> Confirmar Correo</h3>

                    <p> En el correo enviado por nuestros empleados encontrarás un enlace para que puedas confirmar tu
                        asistencia
                        <strong>(en un plazo determinado)</strong>, al hacerlo se generará un codigo.</p>
                    {{ image('img/turnos/presentacion/5.jpg') }}
                </div>
                <div id="contenido-6" class="ocultar">
                    <h3> Asistencia</h3>

                    <p> Cuando asista a nuestra oficina deberá ingresar su codigo en la <strong>terminal de
                            afiliados</strong> para ser atendido.</p>
                    {{ image('img/turnos/presentacion/6.jpg') }}
                </div>
            </div>
        </div>

        <div class="ms-section fondo-blanco-circles font-blank " id="right3" align="left">
            {#RIGHT 3#}
            <h1 align="center" style="margin: 15px;">Accede a nuestra terminal</h1>

            <div align="center">
                {{ image('img/turnos/presentacion/6.jpg','alt':'persona terminal','align':'center') }}
            </div>
            <ul style="margin: 15px;">
                <li id="paso-1" class="hr cursor-hand">
                    <button type="button" class="btn btn-blue btn-circle margin-right-5">
                        1º
                    </button>
                    <a class="hover-background">
                        Ingresar el legajo y el número de documento.</a>
                </li>
                <li id="paso-2" class="hr cursor-hand">
                    <button type="button" class="btn btn-blue btn-circle margin-right-5">
                        2º
                    </button>
                    <a class="hover-background">
                        Esperar que nuestros empleados analicen tu solicitud.</a>
                </li>
                <li id="paso-3" class="hr cursor-hand">
                    <button type="button" class="btn btn-blue btn-circle margin-right-5">
                        3º
                    </button>
                    <a class="hover-background">
                        Una vez que finalicen el análisis de tu solicitud será llamado para otorgarle la información
                        correspondiente.
                    </a>
                </li>
            </ul>
        </div>
    </div>
</div>
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
