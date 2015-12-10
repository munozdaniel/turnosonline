<section id="onepage" style="    background: -moz-linear-gradient(top, rgba(30,87,153,1) 0%, rgba(125,185,232,0) 100%);
    background: -webkit-linear-gradient(top, rgba(30,87,153,1) 0%,rgba(125,185,232,0) 100%);
    background: linear-gradient(to bottom, rgba(30,87,153,1) 0%,rgba(125,185,232,0) 100%);
    filter: progid:DXImageTransform.Microsoft.gradient( startColorstr='#1e5799', endColorstr='#007db9e8',GradientType=0 );">

    <div class="container">
        <div class="row ">
            <div class="col-md-12" style="text-align: center;">
                {{ content() }}
                <div class="box efecto3">
                {% if vencido == 1 %}
                    <h1 style="text-shadow: 2px 2px 9px rgb(219, 243, 255);margin-top: 100px;">
                        GRACIAS POR SU CONFIRMACIÓN
                    </h1>
                {% elseif vencido == 2%}
                    <h1 style="text-align: center;    text-shadow: 2px 2px 9px rgb(219, 243, 255);margin-top: 100px;">
                        LAMENTABLEMENTE EL PLAZO DE CONFIRMACIÓN HA FINALIZADO, POR FAVOR VUELVA A SOLICITAR EL TURNO.
                    </h1>
                    {% elseif vencido == -1 %}
                        <h1 style="text-align: center;    text-shadow: 2px 2px 9px rgb(219, 243, 255);margin-top: 100px;">
                           USTED YA HA CONFIRMADO EL TURNO.
                        </h1>
                {% endif %}
                </div>
                {{ link_to('index/index','<i class="fa fa-home"></i>INICIO','style':'font-size: xx-large;font-weight: bold;') }}
            </div>
        </div>
    </div>
</section>