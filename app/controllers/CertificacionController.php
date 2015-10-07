<?php

class CertificacionController extends ControllerBase
{
    public function initialize()
    {
        $this->tag->setTitle('Certificación Negativa');
        parent::initialize();
        $this->assets->collection('footerInline')
            ->addInlineJs("$(\".navbar-fixed-top\").addClass('past-main');");
    }

    public function indexAction()
    {

    }
    public function generarAction()
    {
        if ($this->request->isPost()) {
            $this->tag->setTitle('');
            $dni            =   $this->request->getPost('certificacion-nroDoc');
            $persona        =   Datospersona::findFirstByDatospersona_nroDoc($dni);
            $beneficio      =   new Datosbeneficio();
            $tipoBeneficio  =   -1;//Inicializo, porque sino el pdf no se genera.
            $tipoDni        =   -1;//Inicializo, porque sino el pdf no se genera.
            if($persona) {
                $tipoDni   = Tipodoc::findFirst('tipodoc_id',$persona->datospersona_tipoDoc);
                $idPersona = $persona->datospersona_id;
                $beneficio = Datosbeneficio::findFirstByDatosbeneficio_datosPersonal($idPersona);
                if($beneficio)
                    $tipoBeneficio = Tipobeneficio::findFirst('tipobeneficio_id',$beneficio->datosbeneficio_tipoBeneficio );
            }

            //GENERAR PDF
           $this->view->disable();
            // Get all the data from the database
            $data = Novedades::find();
            // Get the view data
            $html = $this->view->getRender('certificacion', 'generar', array(
                'nroDocumento'  =>  $dni,
                'beneficio'     =>  $beneficio,
                'persona'       =>  $persona,
                'tipoBeneficio' =>  $tipoBeneficio,
                'tipoDni'       =>  $tipoDni

            ));
            $pdf = new mPDF();
            $pdf->WriteHTML($html, 2);
            $pdf->Output('certificacion.pdf', "I");
        }
    }

}

