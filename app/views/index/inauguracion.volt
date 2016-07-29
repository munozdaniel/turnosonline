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

    .modal-body {
        padding: 5px !important;
    }

    .modal-content {
        border-radius: 0;
    }

    .modal-dialog img {
        text-align: center;
        margin: 0 auto;
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

    /*override modal for demo only*/
    .modal-dialog {
        max-width: 500px;
        padding-top: 90px;
    }

    @media screen and (min-width: 768px) {
        .modal-dialog {
            width: 500px;
            padding-top: 90px;
        }
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
                    <ins>AHORA SÍ, LLEGAMOS A NUESTRA CASA NUEVA</ins>
                    <br>
                </h1>
                <h3>
                    <small><em style=" color:#FFF !important;"> Te mostramos como fue la inauguración de nuestro
                            edificio</em></small>
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
                        <div class="col-md-4 bg-danger" style="height: 300px;">

                        </div>
                        <div class="col-md-4 bg-info" style="height: 150px;">

                        </div>
                    </div>
                    <div class="row" >
                        <h3> Galería</h3>
                        <a class="btn btn-danger"  onclick="flipGallery()"></a>
                        <div id="flipGallery">
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

</section>