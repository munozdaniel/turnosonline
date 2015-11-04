<?php
use Phalcon\Forms\Element\Text;
use Phalcon\Validation\Validator\PresenceOf;
use Phalcon\Validation\Validator\StringLength;

class CertificacionController extends ControllerBase
{
    public function initialize()
    {
        $this->tag->setTitle('Certificación Negativa');
        $this->view->setTemplateAfter('admin');
        parent::initialize();
        $this->assets->collection('footerInline')
            ->addInlineJs("$(\".navbar-fixed-top\").addClass('past-main');");
        $this->assets
            ->collection('footer')->addJs('js/tooltip.js');
    }

    public function indexAction()
    {

        $this->view->certificacionForm = new CertificacionForm;

    }

    public function generarAction()
    {
        $certificacionForm = new CertificacionForm();
        if (!$this->request->isPost()) {
            $certificacionForm->clear();
            $this->redireccionar('certificacion/index');
        } else {
            $data = $this->request->getPost();

            if ($certificacionForm->isValid($data) != false) {

                $this->tag->setTitle('');//Para que no muestre el titulo en el pdf.
                $dni = $this->request->getPost('nroDoc', array('int'));
                $persona = Datospersona::findFirstByDatospersona_nroDoc($dni);
                $beneficio = new Datosbeneficio();
                $tipoBeneficio = -1;//Inicializo, porque sino el pdf no se genera.
                $tipoDni = -1;//Inicializo, porque sino el pdf no se genera.
                if ($persona) {
                    $tipoDni = Tipodoc::findFirst('tipodoc_id', $persona->datospersona_tipoDoc);
                    $idPersona = $persona->datospersona_id;
                    $beneficio = Datosbeneficio::findFirstByDatosbeneficio_datosPersonal($idPersona);
                    if ($beneficio)
                        $tipoBeneficio = Tipobeneficio::findFirstByTipobeneficio_id($beneficio->datosbeneficio_tipoBeneficio);
                }

                //GENERAR PDF
                $this->view->disable();
                // Get the view data
                $html = $this->view->getRender('certificacion', 'generar', array(
                    'nroDocumento' => $dni,
                    'beneficio' => $beneficio,
                    'persona' => $persona,
                    'tipoBeneficio' => $tipoBeneficio,
                    'tipoDni' => $tipoDni

                ));
                $pdf = new mPDF();
                $pdf->WriteHTML($html, 2);
                $pdf->Output('certificacion.pdf', "I");
            } else {
                foreach ($certificacionForm->getMessages() as $message) {
                    $this->flash->message("validador", $message);
                }
            }
        }
        $this->redireccionar('certificacion/index');
    }

}

