
<div class="account-container ">
    {{ form("curriculum/verificarDatos", "method":"post", "autocomplete" : "off", 'class':'form-horizontal') }}
    <fieldset>

        <legend><i class="fa fa-search"></i> BUSCAR MI CURRICULUM</legend>
        {{ content() }}

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

            {{ form.render('BUSCAR CURRICULUM') }}
            {{ link_to('persona/new','NUEVO CURRICULUM','class':'btn btn-large btn-info') }}

</form>
</div>