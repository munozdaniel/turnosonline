<div class="curriculum-bg-header modal-header " align="left">
    <h1>
        <ins>DATOS PERSONALES</ins>
        <br>

        <h3 class="">
            <em>
                <small style=" color:#FFF !important;"> Es importante llenar estos campos, ya que indican el único medio de poder contactarnos con usted. </small>
            </em>
        </h3>
    </h1>
    <table class="" width="100%">
        <tr>
            <td align="right">
                {{ link_to("curriculum/login", "Salir",'class':'btn btn-lg btn-primary') }}


            </td>
        </tr>
    </table>

</div>
<div class="modal-body col-md-12">

    {{ form("persona/create","enctype":"multipart/form-data", "method":"post", 'class':'curriculum-bg-form borde-top') }}

    {{ content() }}

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
        <div class="  col-sm-12  col-md-6">

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
                    {{ formulario.render('ciudad_id',['title':'Primero seleccione la provincia']) }}
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
                <div class="col-sm-12 font col-md-4 col-md-offset-0">
                    {{ formulario.label('persona_celular' ) }}
                </div>
                <div class="col-sm-8">
                    {{ formulario.render('persona_celular') }}
                </div>
            </div>


            {{ formulario.render('script_ciudadProvincia') }}

        </div>
        <div class="row">
            <div class="col-md-12">
                <hr>
            </div>
            <div class="col-md-12 form-group">
                <div class="col-md-6">
                    <label for="curriculum_adjunto">Adjuntar CV <small>[ PDF ]</small></label>
                    <input name="curriculum_adjunto" type="file" title="El archivo debe ser un PDF" class="form-control"/>
                </div>
                <div class="col-md-6">
                    <label for="curriculum_foto">Foto de Perfil <small>[ 300x400 máx - JPG/JPEG]</small></label>
                    <input name="curriculum_foto" type="file"  title="El archivo debe ser un JPG" class="form-control"/>
                </div>

            </div>
            </div>
        <div class="col-md-12">
            <hr>
        </div>
        <div class="col-md-6 col-md-offset-3">
            {{ submit_button("GRABAR Y CONTINUAR ►",'class':'btn btn-large btn-block btn-info font-bold') }}
        </div>
    </div>



    </form>
</div>
