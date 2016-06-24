<style type="text/css">
    .ca {
        font: 500 14px 'roboto';
        color: #333;
        background-color:#fafafa;
    }
    a {
        text-decoration: none;
    }
    ul.ul-style,ol.ol-style,li.li-style {
        list-style: none;
        padding: 0;
        margin: 0;
    }
    .calendar-hd{
        padding-bottom: 40px !important;
        border-bottom: 2px dotted gray;
    }

    p {
        margin: 0;
    }
    #dt {
        margin: 30px auto;
        height: 28px;
        width: 200px;
        padding: 0 6px;
        border: 1px solid #ccc;
        outline: none;
    }
</style>

<section id="onepage" class="admin bg_line">
    <div class="container ">
        <div align="center">
            <div class="curriculum-bg-header modal-header " align="left">

                <h1>
                    <ins>CALENDARIO</ins>
                </h1>
                <h3>
                    <small><em style=" color:#FFF !important;"> A continuación se visualizará el periodo para solicitar turnos.</em></small>
                </h3>

            </div>
            <hr>
            {{ content() }}
            <div class="curriculum-bg-form borde-top" align="center">
                <div class="row">

                    <div class="col-md-5">
                        <div class="banner-top" align="left">
                            <h1>Información</h1>
                            <hr>
                            <p><i class="fa fa-square" style="color: rgba(224,243,250,1)"></i> Fecha Actual</p>
                            <p><i class="fa fa-square" style="color: green;"></i> <strong>Solicitar Turnos</strong></p>
                            <p><i class="fa fa-square" style="color: orange;"></i> <strong>Atención de Turnos</strong></p>
                        </div>

                    </div>
                    <div id="demo" class="col-md-7">

                        <div id="ca"></div>

                        <input type="text" id="dt" placeholder="trigger calendar" class="ocultar">
                        <div id="dd"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
