
<div class="account-container "align="center">
    {{ form("curriculum/verificarDatos", "method":"post", "autocomplete" : "off", 'class':'form-horizontal') }}
    <fieldset>

        <legend><i class="fa fa-search"></i> BUSCAR MI CURRICULUM</legend>
        {{ content() }}

        <div class="form-group">
            {{ form.label('persona_numeroDocumento',['class':'col-md-4 control-label']) }}
            <div class="col-md-4">
            {{ form.render('persona_numeroDocumento',['class':'form-control input-md']) }}
            </div>
        </div>
        <div class="form-group">
            {{ form.label('persona_email',['class':'col-md-4 control-label']) }}
            <div class="col-md-4">
                {{ form.render('persona_email',['class':'form-control input-md']) }}
            </div>
        </div>
    </fieldset>
    <div >
            {{ form.render('BUSCAR CURRICULUM') }}
        <a href="#registro" role="button" data-toggle="modal" tabindex="102" class="btn btn-large btn-info"><i class="fa  fa-plus-circle"></i> REGISTRARSE</a>

    </div>

</form>
</div>
<!--=========== MODAL CREAR OPERADORA ================-->
<div id="registro" class="modal fade " tabindex="-1">

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
<!--===========  MODAL CREAR OPERADORA ================-->