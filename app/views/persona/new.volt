{{ form("persona/create", "method":"post", 'class':'form-horizontal') }}

{{ content() }}
<div class=" modal-header" align="left">
    <h1>Formá parte de IMPS / Trabajá con Nosotros</h1>

    <h1>
        <ins>Datos Personales</ins>
    </h1>
</div>
<table width="100%">
    <tr>
        <td align="left">{{ link_to("curriculum/login", "Salir",'class':'btn btn-large btn-warning') }}</td>
    </tr>
</table>
<div class="modal-body row">
<div class="form-group col-sm-12 col-md-6">
    <div class="row form-group">
        <div class="col-sm-12 col-md-4 col-md-offset-0">
            {{ formulario.label('persona_apellido' ) }}
        </div>
        <div class="col-sm-8">
            {{ formulario.render('persona_apellido') }}
        </div>
    </div>
    <div class="row form-group">
        <div class="col-sm-12 col-md-4 col-md-offset-0">
            {{ formulario.label('persona_nombre' ) }}
        </div>
        <div class="col-sm-8">
            {{ formulario.render('persona_nombre') }}
        </div>
    </div>
    <div class="row form-group">
        <div class="col-sm-12 col-md-4 col-md-offset-0">
            {{ formulario.label('persona_fechaNacimiento' ) }}
        </div>
        <div class="col-sm-8">
            {{ formulario.render('persona_fechaNacimiento') }}
        </div>
    </div>
    <div class="row form-group">
        <div class="col-sm-12 col-md-4 col-md-offset-0">
            {{ formulario.label('persona_email' ) }}
        </div>
        <div class="col-sm-8">
            {{ formulario.render('persona_email') }}
        </div>
    </div>

    <div class="row form-group">
        <div class="col-sm-12 col-md-4 col-md-offset-0">
            {{ formulario.label('persona_tipoDocumentoId' ) }}
        </div>
        <div class="col-sm-8">
            {{ formulario.render('persona_tipoDocumentoId') }}
        </div>
    </div>
    <div class="row form-group">
        <div class="col-sm-12 col-md-4 col-md-offset-0">
            {{ formulario.label('persona_numeroDocumento' ) }}
        </div>
        <div class="col-sm-8">
            {{ formulario.render('persona_numeroDocumento') }}
        </div>
    </div>
    <div class="row form-group">
        <div class="col-sm-12 col-md-4 col-md-offset-0">
            {{ formulario.label('persona_sexo' ) }}
        </div>
        <div class="col-sm-8">
            {{ formulario.render('persona_sexo') }}
        </div>
    </div>
    <div class="row form-group">
        <div class="col-sm-12 col-md-4 col-md-offset-0">
            {{ formulario.label('persona_estadoCivilId' ) }}
        </div>
        <div class="col-sm-8">
            {{ formulario.render('persona_estadoCivilId') }}
        </div>
    </div>
</div>
    <div class="modal-body  col-sm-12  col-md-6">

        <div class="row form-group">
            <div class="col-sm-12 col-md-4 col-md-offset-0">
                {{ formulario.label('persona_nacionalidadId' ) }}
            </div>
            <div class="col-sm-8">
                {{ formulario.render('persona_nacionalidadId') }}
            </div>
        </div>
        <div class="row form-group">
            <div class="col-sm-12 col-md-4 col-md-offset-0">
                {{ formulario.label('localidad_codigoPostal' ) }}
            </div>
            <div class="col-sm-8">
                {{ formulario.render('localidad_codigoPostal') }}
            </div>
        </div>
        <div class="row form-group">
            <div class="col-sm-12 col-md-4 col-md-offset-0">
                {{ formulario.label('provincia_id' ) }}
            </div>
            <div class="col-sm-8">
                {{ formulario.render('provincia_id') }}
            </div>
        </div>
        <div class="row form-group">
            <div class="col-sm-12 col-md-4 col-md-offset-0">
                {{ formulario.label('ciudad_id' ) }}
            </div>
            <div class="col-sm-8">
                {{ formulario.render('ciudad_id') }}
            </div>
        </div>
        <div class="row form-group">
            <div class="col-sm-12 col-md-4 col-md-offset-0">
                {{ formulario.label('localidad_domicilio' ) }}
            </div>
            <div class="col-sm-8">
                {{ formulario.render('localidad_domicilio') }}
            </div>
        </div>
        <div class="row form-group">
            <div class="col-sm-12 col-md-4 col-md-offset-0">
                {{ formulario.label('persona_telefono' ) }}
            </div>
            <div class="col-sm-8">
                {{ formulario.render('persona_telefono') }}
            </div>
        </div>
        <div class="row form-group">
            <div class="col-sm-12 col-md-4 col-md-offset-0">
                {{ formulario.label('persona_celular' ) }}
            </div>
            <div class="col-sm-8">
                {{ formulario.render('persona_celular') }}
            </div>
        </div>
        {{ formulario.render('script_ciudadProvincia') }}

    </div>
</div>

<div class="col-md-12">
    {{ submit_button("Continuar >> ",'class':'btn btn-large btn-info') }}
</div>

</form>

