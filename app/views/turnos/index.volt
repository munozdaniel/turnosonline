<section id="onepage" class="admin bg-rayado">

    <div class="container">
        <div class="row" align="center" style="margin-top: 30px;">
            <div class="heading">
                <h2 class="wow fadeInLeftBig">Solicite turnos para <br> préstamos personales</h2>
                {{ link_to('index/index','class':'btn btn-lg btn-primary pull-left','<i class="fa fa-undo"></i> VOLVER') }}
                <p>
                    <i class="fa fa-info-circle"
                       style="vertical-align: middle;font-size: 35px;color: #5e7b97;margin-left: 2%;margin-right: 1%;"></i>
                    <em>Por favor, llene los siguientes campos para ingresar una solicitud de turno.</em> <br/><br/>
                </p>
            </div>
        </div>
        <div class="row form-blanco borde-top borde-left-4 borde-right-4">
            <div class="col-md-12">
                <h1> {{ content() }}</h1>
            </div>

            {{ form('turnos/guardarTurnoOnline','method':'post','style':'','class':'') }}
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

            </div>

            <div class="row">
                <div class="col-lg-6 col-lg-offset-3">
                    {% if deshabilitar is defined %}
                        {{ submit_button('GUARDAR DATOS','class':'btn btn-blue btn-lg btn-block disabled') }}
                    {% else %}
                        {{ submit_button('GUARDAR DATOS','class':'btn btn-blue btn-lg btn-block') }}
                    {% endif %}
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