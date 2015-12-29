
<div class="account-container ">
    {{ form("curriculum/verificarDatos", "method":"post", "autocomplete" : "off", 'class':'form-horizontal') }}
    {{ content() }}
    <fieldset>

        <legend>INICIAR SESIÓN</legend>

        <div class="form-group">
            {{ form.label('nroDocumento',['class':'col-md-4 control-label']) }}
            <div class="col-md-4">
            {{ form.render('nroDocumento',['class':'form-control input-md']) }}
            </div>
        </div>
        <div class="form-group">
            {{ form.label('email',['class':'col-md-4 control-label']) }}
            <div class="col-md-4">
                {{ form.render('email',['class':'form-control input-md']) }}
            </div>
        </div>
    </fieldset>

            {{ form.render('Ingresar') }}
            {{ form.render('csrf', ['value': security.getToken()]) }}
            {{ link_to('persona/new','Registrarse','class':'btn btn-large btn-warning') }}

</form>
</div>