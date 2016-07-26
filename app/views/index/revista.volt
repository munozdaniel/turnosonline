
<style type="text/css">
    body{
        /* Permalink - use to edit and share this gradient: http://colorzilla.com/gradient-editor/#3f4c6b+0,3f4c6b+100;Blue+Grey+Flat */
        background: #f4f4f4 url(../img/curriculum/bg.gif) repeat top left;
    }

</style>
<div class="alert alert-warning alert-dismissible" role="alert">
    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
        <span aria-hidden="true">&times;</span></button>
    <strong>TIPS</strong>
    <ul class="">
        <li>
           <i class="fa fa-dot-circle-o"></i> Para <strong>CAMBIAR DE PÁGINA</strong> puede utilizar las flechas del teclado, o arrastrando una esquina.
        </li>
        <li>
            <i class="fa fa-dot-circle-o"></i> Para hacer <strong>ZOOM</strong> solo basta con hacer  click en cualquier zona.
        </li>
    </ul>
</div>
<div class="col-md-12 pull-left">
    {{ link_to('index/catalogo','Volver al Catálogo','class':'btn btn-blue btn-flat ') }}
</div>

<div id="onepage" class="modal-body col-md-12 ">
{{ content() }}
     {{ hidden_field('volumen','value':volumen) }}

    <div id="canvas">

        <div class="zoom-icon zoom-icon-in"></div>

        <div class="magazine-viewport">
            <div class="container">
                <div class="magazine">
                    <!-- Next button -->
                    <div ignore="1" class="next-button"></div>
                    <!-- Previous button -->
                    <div ignore="1" class="previous-button"></div>
                </div>
            </div>


        </div>

    </div>
</div>