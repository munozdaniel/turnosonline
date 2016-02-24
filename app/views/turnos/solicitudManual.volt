<section id="onepage" class="admin bg-rayado">

    {# <meta http-equiv="refresh" content="35">#}

    <style>
        .heading h2 {
            font-size: 35px;
            line-height: 35px;
        }
    </style>

    <script type="text/javascript">
        var myVar = setInterval(function () {
            myTimer()
        }, 1000);
        function myTimer() {
            $('#cantAutorizados').load(document.URL + ' #cantAutorizados');
        }
        function otro() {
            var estadoSeleccionado = document.getElementById('miselect').value;

            if (estadoSeleccionado === 'AUTORIZADO' || estadoSeleccionado === '') {
                var cant = {{ cantAutorizados }};
                if (cant > 0) {
                    if ({{ cantAutorizados }} === {{ cantTurnos }} )
                    alert('No hay mas turnos disponibles en este periodo. Se debe denegar la solicitud.')
                }
            }
        }

    </script>

    <div class="container">
        <div class="row" align="center" style="margin-top: 30px;">
            <div class="heading">
                <h2 class="wow fadeInLeftBig">Solicitud manual</h2>
                {{ link_to('administrar/index','class':'btn btn-lg btn-primary pull-left','<i class="fa fa-undo"></i> VOLVER') }}
                <p>
                    <i class="fa fa-info-circle"
                       style="vertical-align: middle;font-size: 35px;color: #5e7b97;margin-left: 2%;margin-right: 1%;"></i>
                    <em>Por favor, llene los siguientes campos para ingresar una solicitud de turno.</em> <br/><br/>
                </p>
            </div>
        </div>
        <div class="row form-blanco borde-top borde-left-4 borde-right-4">
            <div class="col-sm-6">
                <div class="fuente-14"><strong>
                        <ins>PERIODO DE SOLICITUD DE TURNOS :</ins>
                    </strong>{{ fechaI }} - {{ fechaF }}
                </div>
                <div class="fuente-14"><strong>
                        <ins>DIA DE ATENCI&Oacute;N :</ins>
                    </strong> {{ diaA }}
                </div>
            </div>
            <div class="col-sm-6">
                {% if (cantTurnos == cantAutorizados) %}
                    <div class="fuente-14" style="color:red;">
                        <strong>
                            <ins>TOTAL DE TURNOS :</ins>
                        </strong> {{ cantTurnos }}
                    </div>
                    <div class="fuente-14" id="idCantA" style="color:red;">
                        <strong>
                            <ins>TURNOS AUTORIZADOS :</ins>
                        </strong> <strong id="cantAutorizados">{{ cantAutorizados }}</strong>
                    </div>
                {% else %}
                    <div class="fuente-14">
                        <strong>
                            <ins>TOTAL DE TURNOS :</ins>
                        </strong> {{ cantTurnos }}
                    </div>
                    <div class="fuente-14" id="idCantA">
                        <strong>
                            <ins>TURNOS AUTORIZADOS :</ins>
                        </strong> <strong id="cantAutorizados">{{ cantAutorizados }}</strong>
                    </div>
                {% endif %}
            </div>

        </div>

        <div class="row form-blanco borde-top borde-left-4 borde-right-4">
            <div class="col-md-12">
                {{ content() }}
            </div>
            {{ form('turnos/solicitudManual','method':'post','style':'','class':'') }}
            <div class="col-md-12" style="margin-bottom: 30px;">
                <em style="color:tomato">* Campos obligatorios.</em> <br/><br/>
                {% for elto in formulario %}
                    <div class="col-md-4">
                        {{ elto.label(['class': 'control-label']) }}
                        {{ elto }}
                        {{ formulario.messages(elto.getName()) }}
                    </div>
                    {% if loop.index == 3 OR loop.index == 6 %}
                        <div class="col-md-12">
                            <hr>
                        </div>
                    {% endif %}
                {% endfor %}
                <div class="col-md-4">
                    <label for="miselect">
                        <b style="color: red">* Estado de la solicitud:</b>
                    </label>
                    <select id="miselect" name="estado" onchange="otro()" required="true" class="form-control">
                        <option value="">SELECCIONAR UNA OPCIÓN</option>
                        <option value="AUTORIZADO">AUTORIZADO</option>
                        <option value="DENEGADO">DENEGADO</option>
                    </select>
                </div>

            </div>

            <div class="row">
                <div class="col-lg-6 col-lg-offset-4">
                    {{ submit_button('GUARDAR DATOS','class':'btn btn-blue btn-lg btn-block','style':'width:320px;') }}
                </div>
            </div>

            {{ end_form() }}
        </div>
    </div>

    {{ end_form() }}
    </div>
    </div>
</section>
<!-- cdn for modernizr, if you haven't included it already -->
<script src="http://cdn.jsdelivr.net/webshim/1.12.4/extras/modernizr-custom.js"></script>
<!-- polyfiller file to detect and load polyfills -->
<script src="http://cdn.jsdelivr.net/webshim/1.12.4/polyfiller.js"></script>
<script>
    webshims.setOptions('waitReady', false);
    webshims.setOptions('forms-ext', {types: 'date'});
    webshims.polyfill('forms forms-ext');
</script>
