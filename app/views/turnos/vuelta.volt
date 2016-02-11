
<section id="certificacion">

    <style>
        .alert {padding: 10px;margin-bottom: 300px}
    </style>

    <div class="container">
        <div class="col-md-12 pull-right">{{ link_to('turnos/turnosSolicitados','class':'btn btn-lg btn-default btn-block btn-volver','<i class="fa fa-undo"></i> VOLVER') }}</div>

        <div class="box efecto3">
            {{ content() }}
            <div class="col-xs-12 col-xs-offset-4">
                {{ link_to('turnos/turnosSolicitados','class':'btn btn-lg btn-blue btn-default btn-volver','style':'width:300px;','<i class="fa fa-undo"></i> VOLVER ') }}
            </div>
        </div>
    </div>
</section>
