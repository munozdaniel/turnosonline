<style>
    ul {
        padding: 0 0 0 0;
        margin: 0 0 0 0;
    }

    ul li {
        list-style: none;
        margin-bottom: 25px;
    }

    ul li img {
        cursor: pointer;
    }


    .controls {
        width: 50px;
        display: block;
        font-size: 11px;
        padding-top: 8px;
        font-weight: bold;
    }

    .next {
        float: right;
        text-align: right;
    }


    @media screen and (max-width: 1500px) {
        #ads {
            display: none;
        }
    }
</style>

<section id="onepage" class="admin bg_line">
    <div class="container ">
        <div align="center">
            <div class="curriculum-bg-header modal-header " align="left">
                <h1>
                    <ins>NUEVA SEDE</ins>
                    <br>
                </h1>
                <h3>
                    <small>
                        <em style=" color:#FFF !important;"> Así fue la inauguración de nuestro edificio </em>
                    </small>
                </h3>
                <table class="" width="100%">
                    <tr>
                        <td align="right">{{ link_to("index", "<i class='fa fa-sign-out'></i> SALIR",'class':'btn btn-lg btn-primary') }}</td>
                    </tr>
                </table>

            </div>
            <hr>
            {{ content() }}

            <div class="curriculum-bg-form borde-top" align="center">
                <div class="container">
                    <div class="row">
                        <div class="col-sm-6">
                            <div class="embed-responsive embed-responsive-16by9">
                                <iframe class="embed-responsive-item" src="//www.youtube.com/embed/d_iLSPwxqUo"></iframe>
                            </div>
                        </div>
                        <div class="col-md-4 bg-info" >
                            <h4>Video de la Inauguración de la Nueva Sede</h4>
                            <p></p>

                        </div>

                    </div>
                    <div class="row" >
                        <h3> Galería</h3>
                        <a id="gallery" class="btn btn-danger"  onclick="flipGallery()"></a>
                        <div id="flipGallery">
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
<script>
    $(document).ready(function () {
        //INAUGURACION: Eliminar cuando no se necesite
        $( "#gallery" ).trigger( "click" );
    });
</script>
</section>