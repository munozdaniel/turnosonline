
<section id="certificacion">

    <style>
        .alert {padding: 10px;margin-bottom: 300px}
    </style>

    <div class="container">
        <div class="box efecto3">
            {{ content() }}
            <div class="pull-right">{{ link_to('turnos/turnosSolicitados','class':'btn btn-lg btn-default btn-block btn-volver','<i class="fa fa-undo"></i> VOLVER') }}</div>
        </div>
    </div>
</section>
