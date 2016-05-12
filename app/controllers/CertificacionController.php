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
        $this->assets->collection('headerJs')
            ->addJs('js/jquery.min.js');
        $this->assets->collection('footerInline')
            ->addInlineJs("$(\".navbar-fixed-top\").addClass('past-main');");
    }

    public function indexAction()
    {
        $this->view->certificacionForm = new CertificacionForm;
    }

    public function generarAction()
    {
        $certificacionForm = new CertificacionForm();
        if (!$this->request->isPost())
        {
            $certificacionForm->clear();
            $this->redireccionar('certificacion/index');
        }
        else
        {
            $data = $this->request->getPost();

            if ($certificacionForm->isValid($data) != false)
            {
                $this->tag->setTitle('');//Para que no muestre el titulo en el pdf.
                $dni = $this->request->getPost('nroDoc', array('int'));

                $persona = Datospersona::findFirstByDatospersona_nroDoc($dni);

                $beneficio = new Datosbeneficio();

                $tipoBeneficio = -1;//Inicializo, porque sino el pdf no se genera.
                $tipoDni = -1;//Inicializo, porque sino el pdf no se genera.

                if ($persona)
                {
                    $tipoDni = Tipodoc::findFirst('tipodoc_id', $persona->datospersona_tipoDoc);
                    $idPersona = $persona->datospersona_id;

                    /*$beneficio = Datosbeneficio::findFirstByDatosbeneficio_datosPersonal($idPersona);
                    if ($beneficio)
                        $tipoBeneficio = Tipobeneficio::findFirstByTipobeneficio_id($beneficio->datosbeneficio_tipoBeneficio);*/

                    //new 19/04/2016 M.
                    $beneficios = Datosbeneficio::find(array("datosbeneficio_datosPersonal=?1","bind"=>array(1=>$idPersona)));

                    if(count($beneficios) > 0)
                    {
                        if(count($beneficios) == 1)
                        {
                            $tipoBeneficio = Tipobeneficio::findFirstByTipobeneficio_id($beneficios[0]->datosbeneficio_tipoBeneficio);
                            $beneficio = $beneficios[0];
                        }

                        else
                        {
                            if($beneficios[0]->datosbeneficio_tipoBeneficio == 4)
                            {
                                $tipoBeneficio = Tipobeneficio::findFirstByTipobeneficio_id($beneficios[1]->datosbeneficio_tipoBeneficio);
                                $beneficio = $beneficios[1];
                            }
                            else
                            {
                                $tipoBeneficio = Tipobeneficio::findFirstByTipobeneficio_id($beneficios[0]->datosbeneficio_tipoBeneficio);
                                $beneficio = $beneficios[0];
                            }
                        }
                    } //fin new 19/04/2016 M.

                }
                ini_set('max_execution_time', 300); //300 seconds = 5 minutes // si funciona pero la pagina anterior se corrompe

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
                $pdf = new mpdf();
                $pdf->WriteHTML($html, 2);
                $pdf->Output('certificacion.pdf', "I");
            }
            else
            {
                foreach ($certificacionForm->getMessages() as $message) {
                    $this->flash->message("validador", $message);
                }
            }
        }
        $this->redireccionar('certificacion/index');
    }
}

