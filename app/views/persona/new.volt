
{{ form("persona/create", "method":"post", 'class':'form-horizontal') }}

{{ content() }}


<div align="center">
    <h1>Formá parte de IMPS / Trabajá con Nosotros</h1>

    <h3>Ingresa tus datos personales para registrarte en el sistema</h3>
</div>

<table width="100%">
    <tr>
        <td align="left">{{ link_to("persona", "Volver",'class':'btn btn-large btn-warning') }}</td>
        <td align="right">{{ submit_button("Continuar >> ",'class':'btn btn-large btn-info') }}</td>
    </tr>
</table>
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="row">
                <div class="col-md-6">
                    {{ formulario.label('persona_apellido' )}}
                    {{ formulario.render('persona_apellido',['class':'form-control']) }}
                    <hr>
                </div>
                <div class="col-md-6">
                    {{ formulario.label('persona_nombre' )}}
                    {{ formulario.render('persona_nombre',['class':'form-control']) }}
                    <hr>
                </div>
                <div class="col-md-6 ">
                    {{ formulario.label('persona_fechaNacimiento' )}}
                    {{ formulario.render('persona_fechaNacimiento',['class':'form-control']) }}
                    <hr>
                </div>
                <div class="col-md-6">
                    {{ formulario.label('persona_email' )}}
                    {{ formulario.render('persona_email',['class':'form-control']) }}
                    <hr>
                </div>
                <div class="col-md-6">
                    {{ formulario.label('persona_tipoDocumentoId' )}}
                    {{ formulario.render('persona_tipoDocumentoId',['class':'form-control']) }}
                    <hr>
                </div>
                <div class="col-md-6">
                    {{ formulario.label('persona_numeroDocumento' )}}
                    {{ formulario.render('persona_numeroDocumento',['class':'form-control']) }}
                    <hr>
                </div>
                <div class="col-md-6">
                    {{ formulario.label('persona_sexo' )}}
                    {{ formulario.render('persona_sexo',['class':'form-control']) }}
                    <hr>
                </div>
                <div class="col-md-6">
                    {{ formulario.label('persona_estadoCivilId' )}}
                    {{ formulario.render('persona_estadoCivilId',['class':'form-control']) }}
                    <hr>
                </div>
                <div class="col-md-6">
                    {{ formulario.label('persona_nacionalidadId' )}}
                    {{ formulario.render('persona_nacionalidadId',['class':'form-control']) }}
                    <hr>
                </div>
                <div class="col-md-6">
                    {{ formulario.label('localidad_codigoPostal' )}}
                    {{ formulario.render('localidad_codigoPostal',['class':'form-control']) }}
                    <hr>
                </div>
                <div class="col-md-6">
                    {{ formulario.label('provincia_id' )}}
                    {{ formulario.render('provincia_id',['class':'form-control']) }}
                    <hr>
                </div>
                <div class="col-md-6">
                    {{ formulario.label('ciudad_id' )}}
                    {{ formulario.render('ciudad_id',['class':'form-control']) }}
                    <hr>
                </div>
                <div class="col-md-12">
                    {{ formulario.label('localidad_domicilio' )}}
                    {{ formulario.render('localidad_domicilio',['class':'form-control']) }}
                    <hr>
                </div>
                <div class="col-md-6">
                    {{ formulario.label('persona_telefono' )}}
                    {{ formulario.render('persona_telefono',['class':'form-control']) }}
                    <hr>
                </div>
                <div class="col-md-6">
                    {{ formulario.label('persona_celular' )}}
                    {{ formulario.render('persona_celular',['class':'form-control']) }}
                    <hr>
                </div>

                <div class="col-md-6">
                    {{ formulario.render('ciudad_provincia',['class':'form-control']) }}
                    <hr>
                </div>
            </div>
        </div>
    </div>
</div>




<div class="col-md-12">
{{ submit_button("Continuar >> ",'class':'btn btn-large btn-info') }}
</div>

</form>

