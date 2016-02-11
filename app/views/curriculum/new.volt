<table width="100%">
    <tr>
        <td align="left">{{ link_to("curriculum/login", "Finalizar") }}</td>
    </tr>
</table>
<div class="col-sm-6 col-sm-offset-3 form-box">
    {{ form("curriculum/create", "method":"post",'class':'registration-form') }}
        {{ content() }}
        {{ partials('parcial/datospersonales') }}

        <fieldset>
            <div class="form-top">
                <div class="form-top-left">
                    <h3>Step 2 / 3</h3>
                    <p>Set up your account:</p>
                </div>
                <div class="form-top-right">
                    <i class="fa fa-key"></i>
                </div>
            </div>
            <div class="form-bottom">
                <div class="form-group">
                    <label class="sr-only" for="form-email">Email</label>
                    <input type="text" name="form-email" placeholder="Email..." class="form-email form-control" id="form-email">
                </div>
                <div class="form-group">
                    <label class="sr-only" for="form-password">Password</label>
                    <input type="password" name="form-password" placeholder="Password..." class="form-password form-control" id="form-password">
                </div>
                <div class="form-group">
                    <label class="sr-only" for="form-repeat-password">Repeat password</label>
                    <input type="password" name="form-repeat-password" placeholder="Repeat password..."
                           class="form-repeat-password form-control" id="form-repeat-password">
                </div>
                <button type="button" class="btn btn-previous">Previous</button>
                <button type="button" class="btn btn-next">Next</button>
            </div>
        </fieldset>

        <fieldset>
            <div class="form-top">
                <div class="form-top-left">
                    <h3>Step 3 / 3</h3>
                    <p>Social media profiles:</p>
                </div>
                <div class="form-top-right">
                    <i class="fa fa-twitter"></i>
                </div>
            </div>
            <div class="form-bottom">
                <div class="form-group">
                    <label class="sr-only" for="form-facebook">Facebook</label>
                    <input type="text" name="form-facebook" placeholder="Facebook..." class="form-facebook form-control" id="form-facebook">
                </div>
                <div class="form-group">
                    <label class="sr-only" for="form-twitter">Twitter</label>
                    <input type="text" name="form-twitter" placeholder="Twitter..." class="form-twitter form-control" id="form-twitter">
                </div>
                <div class="form-group">
                    <label class="sr-only" for="form-google-plus">Google plus</label>
                    <input type="text" name="form-google-plus" placeholder="Google plus..." class="form-google-plus form-control" id="form-google-plus">
                </div>
                <button type="button" class="btn btn-previous">Previous</button>
                <button type="submit" class="btn">Sign me up!</button>
            </div>
        </fieldset>

    </form>

</div>





{{ form("curriculum/create", "method":"post") }}

<table width="100%">
    <tr>
        <td align="left">{{ link_to("curriculum", "Go Back") }}</td>
        <td align="right">{{ submit_button("Save") }}</td>
    </tr>
</table>

{{ content() }}

<div align="center">
    <h1>Create curriculum</h1>
</div>

<table>
    <tr>
        <td align="right">
            <label for="curriculum_personaId">Curriculum Of PersonaId</label>
        </td>
        <td align="left">
            {{ text_field("curriculum_personaId", "type" : "numeric") }}
        </td>
    </tr>
    <tr>
        <td align="right">
            <label for="curriculum_experienciaId">Curriculum Of ExperienciaId</label>
        </td>
        <td align="left">
            {{ text_field("curriculum_experienciaId", "type" : "numeric") }}
        </td>
    </tr>
    <tr>
        <td align="right">
            <label for="curriculum_formacionId">Curriculum Of FormacionId</label>
        </td>
        <td align="left">
            {{ text_field("curriculum_formacionId", "type" : "numeric") }}
        </td>
    </tr>
    <tr>
        <td align="right">
            <label for="curriculum_idiomasId">Curriculum Of IdiomasId</label>
        </td>
        <td align="left">
            {{ text_field("curriculum_idiomasId", "type" : "numeric") }}
        </td>
    </tr>
    <tr>
        <td align="right">
            <label for="curriculum_informaticaId">Curriculum Of InformaticaId</label>
        </td>
        <td align="left">
            {{ text_field("curriculum_informaticaId", "type" : "numeric") }}
        </td>
    </tr>
    <tr>
        <td align="right">
            <label for="curriculum_habilitado">Curriculum Of Habilitado</label>
        </td>
        <td align="left">
            {{ text_field("curriculum_habilitado", "type" : "numeric") }}
        </td>
    </tr>

    <tr>
        <td></td>
        <td>{{ submit_button("Save") }}</td>
    </tr>
</table>

</form>
