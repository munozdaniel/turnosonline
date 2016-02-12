<div class="curriculum-bg-header modal-header " align="left">
    <h1>
        <ins>BUSCAR MI CURRICULUM</ins>
        <br>

        <h3 class="">
            <ins>
                <small style=" color:#FFF !important;">Formá parte de IMPS / Trabajá con Nosotros</small>
            </ins>
        </h3>
    </h1>
    <table class="" width="100%">
        <tr>
            <td align="right">
                <a href="#registro" role="button" data-toggle="modal" tabindex="102" class="btn btn-large  btn-info"><i
                            class="fa  fa-plus-circle"></i> REGISTRARSE</a>

            </td>
        </tr>
    </table>

</div>
<div class="modal-body col-md-12 ">

    {{ form("curriculum/verificarDatos", "method":"post", "autocomplete" : "off", 'class':'curriculum-bg-form borde-top ') }}

    <legend>Ingrese sus datos</legend>

    <div class="row form-group">
        <div id="idiomas_mensaje" class="col-md-8 col-md-offset-2  ">
            {{ content() }}
        </div>

        <div class="col-sm-12 col-md-2 col-md-offset-2">
            {{ form.label('persona_numeroDocumento',['class':'col-md-4 control-label']) }}
        </div>
        <div class="col-sm-4">
            {{ form.render('persona_numeroDocumento',['class':'form-control input-md']) }}
        </div>

    </div>
    <div class="row form-group">

        <div class="col-sm-12 col-md-2 col-md-offset-2">
            {{ form.label('persona_email',['class':'col-md-4 control-label']) }}
        </div>
        <div class="col-sm-4">
            {{ form.render('persona_email',['class':'form-control input-md']) }}
        </div>
        <div class="col-md-12"><br></div>
        <div class="col-md-10 col-md-offset-1">
            <fieldset class="">
                <legend class="legendStyle ">
                    {{ form.render('BUSCAR CURRICULUM') }}

                </legend>

            </fieldset>
        </div>
    </div>

    {{ end_form() }}
</div>


<!--=========== MODAL CREAR OPERADORA ================-->
<div id="registro" class="modal fade" tabindex="-1">
<div class="  col-md-7 col-md-offset-3">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title"> INGRESE SU CASILLA DE CORREO</h4>
            </div>
            <div class="modal-body margin-left-right-one"
                 style="border-left: 0 !important; border-right: 0 !important;">
                <div class="row">
                    <div class="col-md-4 col-md-offset-4 ">
                        {{ form("curriculum/confirmarCasilla", "method":"post", "autocomplete" : "off", 'class':'form-horizontal') }}
                        <label>Email</label>
                        {{ email_field('confirmar_email','placeholder':'ejemplo@imps.org.ar','class':'form-control input-md','required':'') }}

                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-orange pull-left" data-dismiss="modal">CERRAR</button>
                {{ submit_button('ENVIAR','class':'btn btn-blue') }}
            </div>
            </form>

        </div>
    </div>
    </div>
</div>
<!--===========  MODAL CREAR OPERADORA ================-->