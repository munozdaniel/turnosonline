
<section id="certificacion">

    <style>
        .alert {padding: 10px;margin-bottom: 300px}
    </style>

    <div class="container">
        <div class="row">
            <div class="col-lg-12 col-md-12">
                <div class="about_area">
                    <div class="heading">
                        <div class="pull-right">{{ link_to('turnos/turnosSolicitados','class':'btn btn-lg btn-default btn-block btn-volver','<i class="fa fa-undo"></i> VOLVER') }}</div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row edicion">
            <div class="col-md-12">
                {{ content() }}
            </div>
       </div>
    </div>
</section>
