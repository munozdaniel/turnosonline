<section id="certificacion">

   {# <meta http-equiv="refresh" content="35">#}

    <style>
        .heading h2 {font-size: 35px;line-height: 35px;}
    </style>

    <script type="text/javascript">

        var myVar = setInterval(function(){ myTimer() }, 1000);

        function myTimer()
        {
            $('#cantAutorizados').load(document.URL +  ' #cantAutorizados');
        }

        function otro()
        {
            var estadoSeleccionado = document.getElementById('miselect').value;

            if (estadoSeleccionado === 'AUTORIZADO' || estadoSeleccionado === '')
            {
                var cant= {{ cantAutorizados }};
                if( cant > 0 )
                {
                    if( {{ cantAutorizados }} === {{ cantTurnos }} )
                    alert('No hay mas turnos disponibles en este periodo. Se debe denegar la solicitud.')
                }

            }
        }

    </script>

    <div class="container">

        <div class="row">
            <div class="col-lg-12 col-md-12">
                <div class="about_area">
                    <div class="heading">
                        <h2 class="wow fadeInLeftBig">Solicitud manual</h2>

                        <div class="pull-right">{{ link_to('administrar/index','class':'btn btn-lg btn-default btn-block btn-volver','<i class="fa fa-undo"></i> VOLVER') }}</div>
                        <br>

                        <p><i class="fa fa-info-circle" style="vertical-align: middle;font-size: 35px;color: #5e7b97;margin-left: 2%;margin-right: 1%;"></i>
                            <em>Por favor, llene los siguientes campos para ingresar una solicitud de turno.</em> <br/><br/>
                            </p>
                    </div>

                    <table>
                        <tr>
                            <td>
                                <div class="fuente-14"> <strong><ins>PERIODO DE SOLICITUD DE TURNOS :</ins> </strong>{{ fechaI }} - {{ fechaF }}
                                </div>
                                <div class="fuente-14"> <strong><ins>DIA DE ATENCI&Oacute;N :</ins> </strong> {{ diaA }}
                                </div>
                            </td>

                            <td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
                            <td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
                            <td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
                            <td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
                            <td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
                            <td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
                            <td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
                            <td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
                            <td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
                            <td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>

                            <td>
                                {% if (cantTurnos == cantAutorizados) %}
                                    <div class="fuente-14" style="color:red;">
                                        <strong><ins>TOTAL DE TURNOS :</ins> </strong> {{ cantTurnos }}
                                    </div>
                                    <div class="fuente-14" id="idCantA" style="color:red;">
                                        <strong><ins>TURNOS AUTORIZADOS :</ins> </strong> <strong id="cantAutorizados">{{ cantAutorizados }}</strong>
                                    </div>
                                {% else %}
                                    <div class="fuente-14">
                                        <strong><ins>TOTAL DE TURNOS :</ins> </strong> {{ cantTurnos }}
                                    </div>
                                    <div class="fuente-14" id="idCantA">
                                        <strong><ins>TURNOS AUTORIZADOS :</ins></strong> <strong id="cantAutorizados">{{ cantAutorizados }}</strong>
                                    </div>
                                {% endif %}
                            </td>
                        </tr>
                    </table>
                </div>
            </div>
        </div>

        <div class="row formulario-turnos">

            <div class="col-md-12">
                {{ content() }}
            </div>

            <div class="col-lg-8 col-md-8 col-md-offset-2">

                <div class="about_content wow bounceInUp ">
                    {{ form('turnos/solicitudManual','method':'post','style':'','class':'') }}
                         <em style="color:tomato">* Campos obligatorios.</em> <br/><br/>

                        {% for elto in formulario %}
                            <div class="row">

                                <div class="col-lg-3  col-md-3  col-sm-6 col-xs-12 col-md-offset-2">
                                    {{ elto.label(['class': 'control-label']) }}
                                </div>

                                <div class="col-lg-9  col-md-9  col-sm-6 col-xs-12 col-md-offset-5">
                                    {{ elto }}
                                    {{ formulario.messages(elto.getName()) }}
                                </div>

                            </div><br/>
                        {% endfor %}

                        <div class="col-lg-7 col-md-7 col-md-offset-2">
                            <b style="color: red">*</b></b><b>Estado de la solicitud:</b>
                                 <select id="miselect" name="estado" onchange="otro()" class="col-lg-7 col-md-7 col-md-offset-5" style="width: 300px !important;height: 40px !important;">
                                     <option value=""></option>
                                     <option value="AUTORIZADO">AUTORIZADO</option>
                                     <option value="DENEGADO" >DENEGADO</option>
                                 </select>
                            <br/><br/><br/>
                        </div>

                        <br/><br/><br/><br/><br/>

                    <div class="row">
                        <div class="col-lg-9 col-lg-offset-2">
                            {{ submit_button('GUARDAR DATOS','class':'btn btn-blue btn-lg btn-block') }}
                        </div>
                    </div>

                    {{ end_form() }}
                </div>
            </div>
        </div>
    </div>
</section>


