<section id="onepage" class="admin bg_line">
    <div class="container ">
        <div align="center">
            <div class="curriculum-bg-header modal-header " align="left">
                <h1>
                    <ins>EMPRENDIMIENTO MARIMENUCO</ins>
                    <br>
                </h1>
                <table class="" width="100%">
                    <tr>
                        <td align="right">{{ link_to("index", "<i class='fa fa-sign-out'></i> SALIR",'class':'btn btn-lg btn-primary') }}</td>
                    </tr>
                </table>

            </div>
            <hr>
            {{ content() }}
            <div class="curriculum-bg-form borde-top" align="left" style="padding: 20px;">
                <div class="row">
                    <div class="col-md-12">
                        <p>
                            El <strong>I.M.P.S.</strong> informa a sus afiliados que como resultado de nuestra
                            participación en la
                            Licitación Pública Nacional Nº 2, ha sido beneficiado por Decreto Provincial Nº 1657/12 de
                            la adjudicación en venta del lote 7 de aproximadamente 65 Ha, en el Istmo que separa los
                            Lagos Mari Menuco y Los Barreales.
                            En dicho lote el <strong>I.M.P.S.</strong> desarrollará un complejo turístico de
                            aproximadamente 15 Ha que
                            contará con un camping, quincho y demás dependencias.
                            En la superficie restante se plantea una urbanización, con lotes de 500 m2 aproximadamente,
                            los que serán ofrecidos en venta a nuestros afiliados.
                            El valor del lote será determinado una vez finalizados los proyectos de infraestructura
                            contemplándose una forma de pago accesible con un anticipo inicial y cuotas.</p>
                    </div>

                    <div class="col-md-12">
                        <hr>
                        <div class="col-sm-6 col-md-3">
                            {{ link_to('public/img/informacion/04.jpg','class':'thumbnail','target':'_blank',
                            image('img/informacion/04-mini.jpg','alt':'terreno 1')) }}
                        </div>
                        <div class="col-sm-6 col-md-3">
                            {{ link_to('public/img/informacion/02.jpg','class':'thumbnail','target':'_blank',
                            image('img/informacion/02-mini.jpg','alt':'terreno 1')) }}
                        </div>
                        <div class="col-sm-6 col-md-3">
                            {{ link_to('public/img/informacion/03.jpg','class':'thumbnail','target':'_blank',
                            image('img/informacion/03-mini.jpg','alt':'terreno 1')) }}
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
</section>