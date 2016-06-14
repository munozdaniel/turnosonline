<?php

/**
 * Habilitado para todos los usuarios.
 */
class SolicitudturnoController extends ControllerBase
{
    /**
     * Setea el template que no utiliza login.
     */
    public function initialize()
    {
        $this->view->setTemplateAfter('admin');
        $this->importarFechaFirefox();
        $this->assets->collection('headerJs')
            ->addJs('js/jquery.min.js');
        $this->assets->collection('footerInline')->addInlineJs("$(\".navbar-fixed-top\").addClass('past-main');");
        parent::initialize();
    }

    /**
     * Formulario para solicitar un turno online
     */
    public function indexAction()
    {
        $this->tag->setTitle('Solicitar Turno');

        $ultimoPeriodo = Fechasturnos::findFirst(array('fechasTurnos_activo=1'));
        $this->view->formulario = new TurnosOnlineForm();
        $this->view->deshabilitar = true;
        //Verificamos si existe un periodo disponible.
        if (!$ultimoPeriodo) {
            $this->flash->error("<h1>NO HAY NINGÚN PERIODO DISPONIBLE</h1>");
            $this->flash->notice($this->tag->linkTo(array('turnos/calendario', "<h1><i class='fa fa-calendar'></i> CONSULTAR CALENDARIO</h1>", 'class' => 'text-decoration-none ')));
            return $this->redireccionar('solicitudTurno/turnoProcesado');
        }
        //Verifificamos si el plazo para solicitar turnos venció.
        if (!$ultimoPeriodo->esPlazoParaSolicitarTurno()) {
            $this->flash->error("<h1>EL PLAZO PARA SOLICITAR TURNO NO ESTÁ HABILITADO </h1>");
            $this->flash->notice($this->tag->linkTo(array('turnos/calendario', "<h1><i class='fa fa-calendar'></i> CONSULTAR CALENDARIO</h1>", 'class' => 'text-decoration-none ')));
            return $this->redireccionar('solicitudTurno/turnoProcesado');
        }
        //verificamos si hay turnos disponibles.
        if (!$ultimoPeriodo->hayTurnosDisponibles()) {
            $this->flash->error("<h1>LAMENTABLEMENTE NO HAY TURNOS DISPONIBLES</h1>");
            $this->flash->notice($this->tag->linkTo(array('turnos/calendario', "<h1><i class='fa fa-calendar'></i> CONSULTAR CALENDARIO</h1>", 'class' => 'text-decoration-none ')));
            return $this->redireccionar('solicitudTurno/turnoProcesado');
        }
        $this->view->formulario = new TurnosOnlineForm();
        $this->view->deshabilitar = false;
    }

    /**
     * Guarda los datos del afiliados para solicitar el turno.
     * 0. valida si esta dentro del periodo disponible para solicitar turnos.
     * 1. Verifica si hay turnos disponibles.
     * 2. valida sus campos.
     * 3. verifica si los datos ingresados pertenecen a un afiliado de siprea
     * 4. verifica que no haya solicitado otro turno en el periodo actual.
     * 5. verifica que el email no se haya utilizado
     */
    public function guardarTurnoOnlineAction()
    {
        $this->tag->setTitle('Solicitar Turno');

        if (!$this->request->isPost()) {
            return $this->response->redirect('index/index');
        }
        $this->view->formulario = new TurnosOnlineForm(null, array('disabled' => 'true'));

        $ultimoPeriodo = Fechasturnos::findFirst(array('fechasTurnos_activo=1'));
        // 0. valida si esta dentro del periodo disponible para solicitar turnos.
        if (!$ultimoPeriodo || !$ultimoPeriodo->esPlazoParaSolicitarTurno()) {
            return $this->redireccionar('solicitudTurno/index');
        }
        //1. Verifica si hay turnos disponibles
        if (!$ultimoPeriodo->hayTurnosDisponibles()) {
            return $this->redireccionar('solicitudTurno/index');
        }
        //2. valida los campos del formulario.
        $data = $this->request->getPost();
        $turnosOnlineForm = new TurnosOnlineForm();
        $this->view->formulario = $turnosOnlineForm;

        if ($turnosOnlineForm->isValid($data) == false) {
            foreach ($turnosOnlineForm->getMessages() as $mensaje) {
                $this->flash->error($mensaje);
            }
            return $this->redireccionar('solicitudTurno/index');
        }
        //Filtramos los campos
        $legajo = $this->request->getPost('solicitudTurno_legajo');
        $nombre = $this->request->getPost('solicitudTurno_nom', array('striptags', 'string', 'upper'));
        $nombre = rtrim($nombre);
        $nombre = ltrim($nombre);
        $apellido = $this->request->getPost('solicitudTurno_ape', array('striptags', 'string', 'upper'));
        $apellido = rtrim($apellido);
        $apellido = ltrim($apellido);
        $documento = $this->request->getPost('solicitudTurno_documento');
        $numTelefono = $this->request->getPost('solicitudTurno_numTelefono');
        $email = $this->request->getPost('solicitudTurno_email', array('email', 'trim', 'upper'));

        //verificar cantidad de digitos del legajo

        $cant = strlen($legajo);
        if ($cant < 6)
            $legajo = $this->cantCeros(6 - $cant) . $legajo;

        //3. verifica si los datos ingresados pertenecen a un afiliado de siprea
        $nombreCompleto = $this->comprobarDatosEnSiprea($legajo, $apellido);

        if (!$nombreCompleto) {
            $this->flash->error('<h1>USTED NO SE ENCUENTRA REGISTRADO EN EL SISTEMA, PARA OBTENER MAS INFORMACIÓN DIRÍJASE A NUESTRAS OFICINAS.</h1>');
            return $this->redireccionar('solicitudTurno/index');
        }
        // 4. verifica que no haya solicitado otro turno en el periodo actual.
        if ($this->tieneTurnoSolicitado($legajo, $nombreCompleto)) {
            $this->flash->error('<h1>SUS DATOS YA FUERON INGRESADOS, NO PUEDE OBTENER MÁS DE UN TURNO POR PERÍODO</h1>');
            return $this->redireccionar('solicitudTurno/index');
        }
        //5. verifica que el email no se haya utilizado
        if ($this->existeEmailEnElPeriodo($ultimoPeriodo, $email)) {
            $this->flash->error('<h1>EL EMAIL INGRESADO YA HA SIDO UTILIZADO PARA SOLICITAR UN TURNO</h1>');
            return $this->redireccionar('solicitudTurno/index');
        }
        //6. Guardar los datos.
        $turno = Solicitudturno::accionAgregarUnaSolicitudOnline($legajo, $nombreCompleto, $documento, $email,
            $numTelefono, $ultimoPeriodo->getFechasturnosId());

        if (!$turno)//la solicitud se ingreso con exito.
        {
            $this->flash->error('<h1>OCURRIO UN PROBLEMA, POR FAVOR VUELVA A INTENTARLO EN UNOS MINUTOS</h1>');
            return $this->redireccionar('solicitudTurno/index');
        }
        $this->flash->notice('<div align="left">
                                <h1>
                                <i class="fa fa-info-circle fa-3x pull-left" style="display: inline-block;"></i>
                                    LA SOLICITUD FUE INGRESADA CORRECTAMENTE
                                </h1>
                                <h3>
                                    Cuando nuestros empleados finalicen con el análisis de su estado
                                    de deuda se le enviará un correo electrónico para que confirme su asistencia.
                                </h3>
                                </div>  ');
        $turnosOnlineForm->clear();
        return $this->redireccionar('solicitudTurno/turnoProcesado');
    }

    /**
     * Controla el legajo para verificar que sea de un afiliado activo.
     * @param $valor
     * @return string
     */
    private function cantCeros($valor)
    {
        $cad = '0';
        switch ($valor) {
            case 1:
                $cad = '0';
                break;
            case 2:
                $cad = '00';
                break;
            case 3:
                $cad = '000';
                break;
            case 4:
                $cad = '0000';
                break;
        }

        return $cad;
    }

    /**
     * Verifica si el correo ya fue utilizado para solicitar un turno en el periodo activo
     * @param $email
     * @return bool
     */
    private function existeEmailEnElPeriodo($ultimoPeriodo, $email)
    {
        $solicitud = Solicitudturno::findFirst(
            array("conditions" => "solicitudTurnos_fechasTurnos=:fechasTurnos_id: AND solicitudTurno_email = :email:",
                "bind" => array("fechasTurnos_id" => $ultimoPeriodo->fechasTurnos_id, "email" => trim($email)))
        );
        if ($solicitud)
            return true;
        else
            return false;
    }

    /**
     * Verifica que los datos ingresados por parametros se encuentren en la bd de siprea.
     * @param $legajo int corresponde al legajo del afiliado.
     * @param $nombreCompleto String corresponde a los apellidos concatenados con los nombres, separados por espacio.
     * No es necesario que este completo.
     * @return bool|string
     */
    private function comprobarDatosEnSiprea($legajo, $apellido)
    {
        try {
            $sql = "SELECT AF.afiliado_legajo, AF.afiliado_apenom
                      FROM siprea2.afiliados AS AF
                       WHERE (AF.afiliado_apenom LIKE '%" . $apellido . "%')
                       AND (AF.afiliado_legajo like '" . $legajo . "')
                        AND (AF.afiliado_activo = 1);";
            $result = $this->dbSiprea->query($sql);
            $texto = '';

            if ($result->numRows() != 0) {
                $afiliados = $result->fetch();
                $texto = $afiliados["afiliado_apenom"];
            }
            return $texto;
        } catch (Phalcon\Db\Exception $e) {
            echo $e->getMessage(), PHP_EOL;
        }
        return false;
    }


    /**
     * Verifica con los datos del afiliado si ya solicito un turno en este periodo.
     * MJE ERROR: SUS DATOS YA FUERON INGRESADO, NO PUEDE SACAR MÁS DE UN TURNO POR PERÍODO
     * @return boolean devuelve si encontro o no.
     */
    private function tieneTurnoSolicitado($legajo, $nomApe)
    {
        try {
            $consulta = "SELECT ST.* FROM solicitudturno AS ST, Fechasturnos AS F WHERE (fechasTurnos_activo = 1)
                        AND (F.fechasTurnos_id = ST.solicitudTurnos_fechasTurnos) AND ((ST.solicitudTurno_legajo=:legajo:)
                        OR (ST.solicitudTurno_nomApe LIKE  :nomApe:))";

            $solicitudTurno = $this->modelsManager->executeQuery($consulta,
                array(
                    'legajo' => $legajo,
                    'nomApe' => $nomApe));
            //Si no encontro datos, es porque no solicito un turno en este periodo.
            if (count($solicitudTurno) == 0)
                return false;
        } catch (Exception $e) {
            echo $e->getMessage();
            echo $e->getTraceAsString();
        }
        return true;
    }

    /**
     * Muestra los mensajes correspondientes cuando el usuario solicita un turno online.
     */
    public function turnoProcesadoAction()
    {
        //este action solo se utiliza para poder redireccionarse a la vista correspondiente.
    }

    /**
     * Acepta la asistencia
     */
    public function aceptaAsistenciaAjaxAction()
    {
        $this->view->disable();
        $retorno = array();
        $retorno['success'] = false;
        $retorno['mensaje'] = "";
        if ($this->request->getPost('solicitudTurno_id') == ""
            || $this->request->getPost('solicitudTurno_id') == NULL
        ) {
            $retorno['mensaje'] = "Ocurrió un problema, no se encontró el Identificador del turno solicitado.
             Por favor inténtelo nuevamente, en caso que el problema persista comuníquese con Soporte Técnico.  " . $this->request->getPost('solicitudTurno_id');
            echo json_encode($retorno);
            return;
        }
        $solicitudTurno = Solicitudturno::findFirst(array('solicitudTurno_id=:solicitudTurno_id:', 'bind' =>
            array('solicitudTurno_id' => base64_decode($this->request->getPost('solicitudTurno_id')))));
        if (!$solicitudTurno) {
            $retorno['mensaje'] = "Ocurrió un problema, no se encontró el turno solicitado.<hr>
             Por favor inténtelo nuevamente, en caso que el problema persista comuníquese con Soporte Técnico.  ";
            echo json_encode($retorno);
            return;
        }
        if ($solicitudTurno->getSolicitudturnoEstadoasistenciaid() == 2) {
            $retorno['mensaje'] = "El turno seleccionado ya ha sido confirmado.";
            echo json_encode($retorno);
            return;
        }
        if ($solicitudTurno->getSolicitudturnoEstadoasistenciaid() == 3) {
            $retorno['mensaje'] = "El turno seleccionado no puede ser confirmado, ya que venció el plazo disponible.";
            echo json_encode($retorno);
            return;
        }
        if ($solicitudTurno->getSolicitudturnoEstadoasistenciaid() == 4) {
            $retorno['mensaje'] = "El turno seleccionado ya fue cancelado, el afiliado deberá solicitar un nuevo turno.";
            echo json_encode($retorno);
            return;
        }
        $dentroPlazoValido = true;
        if ($solicitudTurno->getSolicitudturnoEstadoasistenciaid() == 1) {
            if ($solicitudTurno->getSolicitudturnoTipoturnoid() == 1)
                $dentroPlazoValido = Fechasturnos::verificarConfirmacionDentroPlazoOnline($solicitudTurno->getSolicitudturnoFechapedido());
            else
                if ($solicitudTurno->getSolicitudturnoTipoturnoid() == 2)
                    $dentroPlazoValido = Fechasturnos::verificarConfirmacionDentroPlazoTerminal($solicitudTurno->getSolicitudturnoFechapedido());
            if (!$dentroPlazoValido) {
                //FIXME: Deberia acumular la sancion el evento de mysql
                $retorno['mensaje'] = "El plazo para confirmar el turno ha finalizado. <hr> Se ha acumulado una sanción. ";
                echo json_encode($retorno);
                return;
            }
            $periodo = Fechasturnos::findFirst(array('fechasTurnos_id=:solicitudTurno_fechasTurnos:',
                'bind' => array('solicitudTurno_fechasTurnos' => $solicitudTurno->getSolicitudturnosFechasturnos())));

            $this->db->begin();
            $solicitudTurno->setSolicitudturnoFechaconfirmacion(date('Y-m-d'));
            $solicitudTurno->setSolicitudturnoEstadoasistenciaid(2);//Confirmado
            $mensajeCodigo = "";
            if ($solicitudTurno->getSolicitudturnoEstado() == "AUTORIZADO") {
                if ($solicitudTurno->getSolicitudturnoCodigo() == null || trim($solicitudTurno->getSolicitudturnoCodigo()) == "") {
                    $codigo = $this->getRandomCode($periodo->getFechasTurnosId());
                    $solicitudTurno->setSolicitudturnoCodigo($codigo);
                }
                $mensajeCodigo = " <ins>Código</ins>: <strong class='strong-azul font-gotham' style='letter-spacing: 0.3em; font-size:22px;'> " . $solicitudTurno->getSolicitudturnoCodigo() . "</strong>";
                $mensajeCodigo .= "<br><br> <ins>Afiliado</ins>: <strong> " . $solicitudTurno->getSolicitudturnoNomape() . "</strong>";
                $mensajeCodigo .= "<br><br> <ins>Fecha de Atención</ins>: <strong> " . date('d/m/Y', strtotime($periodo->getFechasturnosDiaatencion())) . "</strong> al <strong>" . date('d/m/Y', strtotime($periodo->getFechasturnosDiaatencionfinal())) . "</strong>";
            }

            if (!$solicitudTurno->update()) {
                $this->db->rollback();
                $retorno['mensaje'] = "Ha ocurrido un error, no se pudieron actualizar los datos. <hr> Inténtelo nuevamente, en caso
                de que el problema persista comuníquese con el <strong>Soporte Técnico</strong>.";
                echo json_encode($retorno);
                return;
            }
        }
        $this->db->commit();
        $retorno['success'] = true;
        $retorno['mensaje'] = $mensajeCodigo;
        echo json_encode($retorno);
        return;
    }

    /**
     * Cancela la asistencia
     */
    public function cancelaAsistenciaAjaxAction()
    {
        $this->view->disable();
        $retorno = array();
        $retorno['success'] = false;
        $retorno['mensaje'] = "";
        if ($this->request->getPost('solicitudTurno_id') == ""
            || $this->request->getPost('solicitudTurno_id') == NULL
        ) {
            $retorno['mensaje'] = "Ocurrió un problema, no se encontró el <strong>IDentificador </strong> del turno solicitado.
             <hr> Por favor intenteló nuevamente, en caso que el problema persista comuníquese con Soporte Técnico.  ";
            echo json_encode($retorno);
            return;
        }
        $solicitudTurno = Solicitudturno::findFirst(array('solicitudTurno_id=:solicitudTurno_id:', 'bind' =>
            array('solicitudTurno_id' => base64_decode($this->request->getPost('solicitudTurno_id')))));
        if (!$solicitudTurno) {
            $retorno['mensaje'] = "Ocurrió un problema, no se encontró el turno solicitado.
             Por favor inténtelo nuevamente, en caso que el problema persista comuníquese con Soporte Técnico.  ";
            echo json_encode($retorno);
            return;
        }
        $dentroPlazoValido = true;
        //Lo deberia hacer el evento de mysql
        if ($solicitudTurno->getSolicitudturnoTipoturnoid() == 1)
            $dentroPlazoValido = Fechasturnos::verificarConfirmacionDentroPlazoOnline($solicitudTurno->getSolicitudturnoFechapedido());
        else
            if ($solicitudTurno->getSolicitudturnoTipoturnoid() == 2)
                $dentroPlazoValido = Fechasturnos::verificarConfirmacionDentroPlazoTerminal($solicitudTurno->getSolicitudturnoFechapedido());
        if (!$dentroPlazoValido) {
            //FIXME: Deberia acumular la sancion el evento de mysql
            $retorno['mensaje'] = "El plazo para confirmar el turno ha finalizado. <hr> Se ha acumulado una sanción. ";
            echo json_encode($retorno);
            return;
        }
        if ($solicitudTurno->getSolicitudturnoEstado() == "AUTORIZADO") {
            //Se libera un turno
            $periodo = Fechasturnos::findFirst(array('fechasTurnos_id=:solicitudTurno_fechasTurnos:',
                'bind' => array('solicitudTurno_fechasTurnos' => $solicitudTurno->getSolicitudturnosFechasturnos())));

            $this->db->begin();
            $solicitudTurno->setSolicitudturnoEstadoasistenciaid(4);
            if (!$periodo->decrementarCantAutorizados()) {
                $this->db->rollback();
                $retorno['mensaje'] = "Ha ocurrido un error, no se pudieron actualizar los datos con respecto a los turnos autorizados. <hr> Inténtelo nuevamente, en caso
                de que el problema persista comuníquese con el <strong>Soporte Técnico</strong>.";
                echo json_encode($retorno);
                return;
            }
            if (!$solicitudTurno->update()) {
                $this->db->rollback();
                $retorno['mensaje'] = "Ha ocurrido un error, no se pudieron actualizar los datos. Inténtelo nuevamente, en caso
            de que el problema persista comuníquese con el Soporte Técnico.";
                echo json_encode($retorno);
                return;
            }
            $mensajeCodigo = "<br> <ins>Afiliado</ins>: <strong> " . $solicitudTurno->getSolicitudturnoNomape() . "</strong>";
            $mensajeCodigo .= "<br> <ins>Fecha de Atención</ins>: <strong> " . date('d/m/Y', strtotime($periodo->getFechasturnosDiaatencion())) . "</strong> al <strong>" . date('d/m/Y', strtotime($periodo->getFechasturnosDiaatencionfinal())) . "</strong>";

        }
        $this->db->commit();
        $retorno['success'] = true;
        $retorno['mensaje'] = $mensajeCodigo;
        echo json_encode($retorno);
        return;
    }

    /**
     * El afiliado ingresa al link enviado por email y se redirecciona a esta accion.
     * <ul>Controlará que:
     *      <li>exista la solicitud y el periodo activo</li>
     *      <li>Si el estado es denegado: setea respuesta chequeada</li>
     *      <li>
     *          <ul>Si el estado es autorizado:
     *              <li>Verifica si el email ya fue confirmado</li>
     *              <li>Verifica si hay turnos disponibles</li>
     *              <li>Verifica si el plazo de confirmacion vencio</li>
     *              <li>Actualiza los datos de la solicitud</li>
     *          </ul>
     *      </li>
     * </ul>
     */
    public function confirmaEmailAction()
    {
        $idSolicitud = $this->request->get('id', 'trim');//Se obtiene por url.
        $id = base64_decode($idSolicitud);
        $solicitud = Solicitudturno::findFirst(array('solicitudTurno_id=:id:', 'bind' => array('id' => $id)));
        if (!$solicitud) {
            $this->flash->error("<h3>NO SE HA ENCONTRADO LA PETICIÓN SOLICITADA</h3>");
            return $this->redireccionar('solicitudTurno/resultadoConfirmacion');
        }
        $ultimoPeriodo = Fechasturnos::findFirst(array('fechasTurnos_activo=1 AND fechasTurnos_id=:solicitudTurno_id:',
            'bind' => array('solicitudTurno_id' => $solicitud->getSolicitudturnosFechasturnos())));
        if (!$ultimoPeriodo) {
            $this->flash->error("<h3><i class='fa fa-warning'></i> EL LINK HA CADUCADO, EL TURNO A CONFIRMAR NO PERTENECE AL PERIODO ACTIVO <br>
                                POR FAVOR VUELVA A SOLICITAR UN TURNO EN EL PRÓXIMO PERÍODO.  </h3>");
            return $this->redireccionar('solicitudTurno/resultadoConfirmacion');
        }
        $estado = $solicitud->getSolicitudturnoEstado();
        $this->db->begin();
        if ($estado == 'AUTORIZADO') {
            //Verifico si venció, según el tipo de turno.
            $dentroPlazoValido = false;
            if ($solicitud->getSolicitudturnoTipoturnoid() == 1)
                $dentroPlazoValido = Fechasturnos::verificarConfirmacionDentroPlazoOnline($solicitud->getSolicitudturnoFechapedido());
            else
                if ($solicitud->getSolicitudturnoTipoturnoid() == 2)
                    $dentroPlazoValido = Fechasturnos::verificarConfirmacionDentroPlazoTerminal($solicitud->getSolicitudturnoFechapedido());
            //Si venció, lo sanciono.
            if (!$dentroPlazoValido) {
                $solicitud->setSolicitudturnoEstadoasistenciaid(3);
                $solicitud->setSolicitudturnoSanciones($solicitud->getSolicitudturnoSanciones() + 1);
                //FIXME: Mostrar las reglas del juego
                if (!$solicitud->update())
                    $this->db->rollback();
                $this->db->commit();
                $this->view->solicitud = NULL;
                $this->flash->error("<h3>LAMENTABLEMENTE SE VENCIÓ EL TIEMPO PARA CONFIRMAR LA ASISTENCIA.</h3>");
                return $this->redireccionar('solicitudTurno/resultadoConfirmacion');
            }
            //Esta cancelado
            if ($solicitud->getSolicitudturnoEstadoasistenciaid() == 4) {
                $this->view->solicitud = NULL;
                $this->flash->error("<h3>USTED HA CANCELADO SU ASISTENCIA ANTERIORMENTE, DEBERÁ SOLICITAR UN TURNO NUEVAMENTE. </h3>");
                return $this->redireccionar('solicitudTurno/resultadoConfirmacion');
            }
            //No venció, preparo el comprobante y las variables para la vista.
            $idCodificado = base64_encode($solicitud->getSolicitudturnoId());
            $boton = $this->tag->form(array('solicitudTurno/comprobanteTurnoPost', 'method' => 'POST'));
            $boton .= $this->tag->hiddenField(array('solicitud_id', 'value' => $idCodificado));
            $boton .= "<button type='submit' class='btn btn-danger btn-lg' formtarget='_blank'><i class='fa fa-print'></i> Imprimir</button>";
            $boton .= "</form>";

            $this->view->solicitud = $solicitud;
            $this->view->periodo = $ultimoPeriodo;
            $this->view->mensaje_boton = $boton;

            //Ya fue confirmado
            if ($solicitud->getSolicitudturnoEstadoasistenciaid() == 2) {
                $this->view->mensaje_alerta = "Su asistencia ya ha sido confirmada";
                return $this->redireccionar('solicitudTurno/resultadoConfirmacion');
            }

            //Primera vez que confirma
            $solicitud->setSolicitudturnoEstadoasistenciaid(2);
            $solicitud->setSolicitudturnoFechaconfirmacion(Date('Y-m-d H:i:s'));
            //Si no tiene codigo le genero uno nuevo.
            if ($solicitud->getSolicitudturnoCodigo() == null || trim($solicitud->getSolicitudturnoCodigo()) == "") {
                $codigo = $this->getRandomCode($ultimoPeriodo->getFechasTurnosId());
                $solicitud->setSolicitudturnoCodigo($codigo);
            }
            if (!$solicitud->update()) {
                $this->flash->error("<h3><i class='fa fa-warning'></i> OCURRIÓ UN PROBLEMA AL PROCESAR LA SOLICITUD, POR FAVOR INTENTELO NUEVAMENTE.</h3>");
                $this->db->rollback();
                return $this->redireccionar('solicitudTurno/resultadoConfirmacion');
            }
            if (!$ultimoPeriodo->update()) {
                $this->flash->error("OCURRIO UN PROBLEMA AL PROCESAR LA SOLICITUD, POR FAVOR INTENTELO NUEVAMENTE.");
                $this->db->rollback();
                return $this->redireccionar('solicitudTurno/resultadoConfirmacion');
            }
            $this->view->mensaje_alerta = "Gracias por confirmar su asistencia";
            $this->db->commit();
            return $this->redireccionar('solicitudTurno/resultadoConfirmacion');
        }
    }

    /**
     * Cancelar un turno que proviene por email.
     */
    public function cancelarEmailAction()
    {
        $this->view->titulo = "CANCELAR ASISTENCIA";
        $idSolicitud = $this->request->get('id', 'trim');//Se obtiene por url.
        $id = base64_decode($idSolicitud);
        $solicitudTurno = Solicitudturno::findFirst(array('solicitudTurno_id=:id:', 'bind' => array('id' => $id)));
        if (!$solicitudTurno) {
            $this->flash->error("<h3>NO SE HA ENCONTRADO LA PETICIÓN SOLICITADA</h3>");
            return $this->redireccionar('solicitudTurno/resultadoConfirmacion');
        }
        $ultimoPeriodo = Fechasturnos::findFirst(array('fechasTurnos_activo=1 AND fechasTurnos_id=:solicitudTurno_id:',
            'bind' => array('solicitudTurno_id' => $solicitudTurno->getSolicitudturnosFechasturnos())));
        if (!$ultimoPeriodo) {
            $this->flash->error("<h3><i class='fa fa-warning'></i> EL LINK HA CADUCADO, LA ASISTENCIA NO SE PUEDE CANCELAR PORQUE NO HAY UN PERÍODO ACTIVO <br></h3>");
            return $this->redireccionar('solicitudTurno/resultadoConfirmacion');
        }
        if ($solicitudTurno->getSolicitudturnoEstadoasistenciaid() == 4) {
            $this->flash->error("<h3><i class='fa fa-warning'></i> LA ASISTENCIA YA SE ENCUENTRA CANCELADA</h3>");
            return $this->redireccionar('solicitudTurno/resultadoConfirmacion');
        }
        return $this->dispatcher->forward(array(
            "controller" => "solicitudTurno",
            "action" => "verTurno",
            "params" => array('solicitudTurno_id' => $this->request->get('id', 'trim'))
        ));

    }

    /**
     * public
     * Solicita legajo y codigo de operacion para Cancelar el turno solicitado.
     */
    public function buscarTurnoAction()
    {
        $this->tag->setTitle('Buscar Turno');
        $ultimoPeriodo = Fechasturnos::findFirstByFechasTurnos_activo(1);
        if (!$ultimoPeriodo) {
            $this->flash->error("EL PERIODO PARA LOS TURNOS ONLINE NO SE ENCUENTRA HABILITADO.");
            $this->view->deshabilitar = true;
        }
        $this->assets->collection('footerInline')->addInlineJs("  $(document).ready(function(){
            $('[data-toggle=\"tooltip\"]').tooltip();
        });");
    }

    /**
     * Verifica los datos de la solicitud para mostrar, o no, los datos del afiliado. Y su estado correspondiente.
     * @return null
     */
    public function verTurnoAction()
    {
        $this->tag->setTitle('Consulta de Turno');

        if (!$this->request->isPost()) {
            //Proviene de cancelarEmail
            $this->view->titulo = "Confirmar/Cancelar Asistencia";
            $idSolicitud = $this->dispatcher->getParam("solicitudTurno_id");
            $id = base64_decode($idSolicitud);
            $solicitudTurno = Solicitudturno::findFirst(array('solicitudTurno_id=:id:',
                'bind' => array('id' => $id)));
            if (!$solicitudTurno) {
                $this->flash->error('SU SOLICITUD DE TURNO NO SE ENCUENTRA CARGADA EN NUESTRA BASE DE DATOS');
                return $this->redireccionar('solicitudTurno/buscarTurno');
            }
        } else {
            $this->view->titulo = "Consulta de turno";
            //Validacion
            if (!$this->request->hasPost('legajo') || $this->request->getPost('legajo', 'int') == null) {
                $this->flash->error('INGRESE EL LEGAJO');
            }

            if (!$this->request->hasPost('codigo') || $this->request->getPost('codigo', 'alphanum') == null) {
                $this->flash->error('INGRESE EL CODIGO');
            }
            //Buscar Solicitud
            $legajo = $this->request->getPost('legajo', 'int');
            $codigo = $this->request->getPost('codigo', 'alphanum');
            $solicitudTurno = Solicitudturno::findFirst(array('solicitudTurno_legajo=:legajo: AND
         solicitudTurno_codigo=:codigo: ',
                'bind' => array('legajo' => $legajo, 'codigo' => $codigo)));
            if (!$solicitudTurno) {
                $this->flash->error('NO SE HA ENCONTRADO EL TURNO ASOCIADO CON LOS DATOS INGRESADO');
                return $this->redireccionar('solicitudTurno/buscarTurno');
            }
        }

        if ($solicitudTurno->getSolicitudturnoEstadoasistenciaid() != 1 && $solicitudTurno->getSolicitudturnoEstadoasistenciaid() != 2) {
            $this->flash->error('SR/A AFILIADO/A, USTED NO TIENE ASIGNADO UN TURNO. <br> LOS TURNOS QUE NO FUERON CANCELADOS O AQUELLOS CUYO PLAZO DE CONFIRMACIÓN HAN FINALIZADO SERÁN DESHABILITADOS.');
            return $this->redireccionar('solicitudTurno/buscarTurno');
        }
        //AUTORIZADO
        if ($solicitudTurno->getSolicitudturnoEstado() == "AUTORIZADO") {
            $dentroPlazoValido = true;
            if ($solicitudTurno->getSolicitudturnoTipoturnoid() == 1) {
                $dentroPlazoValido = Fechasturnos::verificarConfirmacionDentroPlazoOnline($solicitudTurno->getSolicitudturnoFechapedido());
                $fechaLimiteConfirmacion = strtotime('+4 day', strtotime($solicitudTurno->getSolicitudturnoFechapedido()));
                $fechaLimiteConfirmacion = date('Y-m-d', $fechaLimiteConfirmacion);
                $fechaVencimiento = TipoFecha::fechaEnLetras($fechaLimiteConfirmacion);

            } else {
                if ($solicitudTurno->getSolicitudturnoTipoturnoid() == 2) {
                    $dentroPlazoValido = Fechasturnos::verificarConfirmacionDentroPlazoTerminal($solicitudTurno->getSolicitudturnoFechapedido());
                    $fechaLimiteConfirmacion = strtotime('+3 day', strtotime($solicitudTurno->getSolicitudturnoFechapedido()));
                    $fechaLimiteConfirmacion = date('Y-m-d', $fechaLimiteConfirmacion);
                    $fechaVencimiento = TipoFecha::fechaEnLetras($fechaLimiteConfirmacion);

                }
            }
            if (!$dentroPlazoValido) {
                $this->flash->error('<h3>El plazo para confirmar/cancelar el turno ha finalizado el día ' . $fechaVencimiento . '. Por favor, vuelva a solicitar un turno nuevamente.</h3>');
                return $this->redireccionar('solicitudTurno/buscarTurno');
            }
            $this->view->solicitud_id = base64_encode($solicitudTurno->getSolicitudturnoId());
            //Pendiente de confirmacion
            if ($solicitudTurno->getSolicitudturnoEstadoasistenciaid() == 1) {
                $this->flash->notice('<h3>Su asistencia se encuentra <strong>PENDIENTE</strong> </h3>
                    <h4>Por favor, confirme/cancele su asistencia. Recuerde que tiene tiempo hasta el ' . $fechaVencimiento . ' de lo contrario el sistema acumulará una sanción.</h4>');
                $this->view->pendiente = true;
                $this->view->legajo = $solicitudTurno->getSolicitudturnoLegajo();
                $this->view->apeNom = $solicitudTurno->getSolicitudturnoNomape();
            }
            //Confirmado
            if ($solicitudTurno->getSolicitudturnoEstadoasistenciaid() == 2) {
                $this->flash->notice('<h3>Su asistencia se encuentra <strong>CONFIRMADA</strong> </h3>
                    <h4>Si desea cancelarla, recuerde que tiene tiempo hasta el ' . $fechaVencimiento . '.</h4>');
                $this->view->confirmado = true;
                $this->view->legajo = $solicitudTurno->getSolicitudturnoLegajo();
                $this->view->apeNom = $solicitudTurno->getSolicitudturnoNomape();
                $this->view->codigo = $solicitudTurno->getSolicitudturnoCodigo();

            }
        }//SI NO ES AUTORIZADO NO TIENE CODIGO.
    }

    /**
     * Generar numero aleatorio.
     * @return string
     */
    private function getRandomCode($periodo_id)
    {
        $codigo = "";
        $continuar = true;
        while ($continuar) {
            $an = "0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ";
            $su = strlen($an) - 1;
            $codigo = substr($an, rand(0, $su), 1) .
                substr($an, rand(0, $su), 1) .
                substr($an, rand(0, $su), 1) .
                substr($an, rand(0, $su), 1) .
                substr($an, rand(0, $su), 1) .
                substr($an, rand(0, $su), 1) .
                substr($an, rand(0, $su), 1);

            $solicitudes = Solicitudturno::findFirst(
                array('solicitudTurnos_fechasTurnos=:periodo_id: AND solicitudTurno_codigo LIKE :codigo:',
                    'bind' => array('periodo_id' => $periodo_id, 'codigo' => '%' . $codigo . '%')));
            if (!$solicitudes)
                $continuar = false;
        }
        return $codigo;
    }

    /**
     * Proviene de confirma Email. Muestra el resultado de la confirmacion.
     */
    public function resultadoConfirmacionAction()
    {

    }

    /**
     * Se utiliza para generar un comprobante pdf, los empleados de imps unicamente pueden utilizar este metodo.
     * @param $idSolicitud
     */
    public function comprobanteTurnoAction()
    {
        $idSolicitud = $this->request->get('id');
        //echo  $this->request->get('id') ." --- ". $id = base64_decode($idSolicitud); ;
        //$this->view->pick('turnos/turnosRespondidos');

        $idSolicitud = $this->request->get('id');
        $id = base64_decode($idSolicitud);
        $solicitud = Solicitudturno::findFirstBySolicitudTurno_id($id);

        if (!$solicitud)
            $mensaje = "ERROR";
        else
            $mensaje = 'EXITO';

        $this->tag->setTitle('');//Para que no muestre el titulo en el pdf.
        $this->view->disable();
        $html = $this->view->getRender('solicitudTurno', 'comprobanteTurno', array('solicitud' => $solicitud, 'mensaje' => $mensaje));
        $pdf = new mPDF();
        $pdf->SetHeader(date('d/m/Y'));
        $pdf->WriteHTML($html, 2);
        $pdf->Output('comprobanteTurno.pdf', "I");


    }

    /**
     * Genera el comprobante de turno en pdf mediante post. Se utiliza para el public en general.
     */
    public function comprobanteTurnoPostAction()
    {
        if (!$this->request->isPost()) {
            $this->flash->error("Ocurrió un problema, la URL solicitada no se encuentra disponible.");
            $this->redireccionar('index/index');
        }
        $idSolicitud = base64_decode($this->request->getPost('solicitud_id'));
        $solicitud = Solicitudturno::findFirstBySolicitudTurno_id($idSolicitud);

        if (!$solicitud)
            $mensaje = "ERROR";
        else
            $mensaje = 'EXITO';

        $this->tag->setTitle('');//Para que no muestre el titulo en el pdf.
        $this->view->disable();
        $html = $this->view->getRender('solicitudTurno', 'comprobanteTurno', array('solicitud' => $solicitud, 'mensaje' => $mensaje));
        $pdf = new mPDF();
        $pdf->SetHeader(date('d/m/Y'));
        $pdf->WriteHTML($html, 2);
        $pdf->Output('comprobanteTurno.pdf', "I");

    }


    /**
     * public
     * Muestra un calendario con los periodos disponibles.
     * @return string
     */
    public function calendarioAction()
    {
        $this->tag->setTitle('Calendario');
        $this->assets->collection('headerCss')->addJs("plugins/calendario/calendar.css");
        $this->assets->collection('footer')->addJs("plugins/calendario/calendar.js");
        $rangoJs = "";
        $ultimoPeriodo = Fechasturnos::findFirst(array('fechasTurnos_activo = 1'));
        if ($ultimoPeriodo) {
            $fechasSolicitud = TipoFecha::devolverTodosLosDiasEntreFechas($ultimoPeriodo->getFechasturnosIniciosolicitud(), $ultimoPeriodo->getFechasturnosFinsolicitud());
            $rangoJs = "[";
            foreach ($fechasSolicitud as $dia) {
                $rangoJs .= "{date:'$dia','value':'Periodo para SOLICITAR Turno','estilo':'    border: 2px solid green !important;'},";
            }
            $fechasAtencion = TipoFecha::devolverTodosLosDiasEntreFechas($ultimoPeriodo->getFechasturnosDiaatencion(), $ultimoPeriodo->getFechasturnosDiaatencionfinal());
            foreach ($fechasAtencion as $dia) {
                $rangoJs .= "{date:'$dia','value':'Periodo para ATENCIÓN Turno','estilo':' border: 2px solid orange !important;'},";
            }
            $rangoJs .= "]";
        }
        if ($rangoJs == "")
            return $this->flash->error("<h3>POR EL MOMENTO NO HAY NINGÚN PERÍODO DISPONIBLE</h3>");

        $this->assets->collection('footerInline')->addInlineJs("$('#ca').calendar({
                    // view: 'month',
                    width: 320,
                    height: 320,
                    // startWeek: 0,
                    // selectedRang: [new Date(), null],
                    customClass:'',
                    data: $rangoJs,
                            onSelected: function (view, date, data) {
                                console.log('view:' + view)
                                console.log('date:' + date)
                                console.log('data:' + (data || 'None'));
                            }
                        });

                        $('#dd').calendar({
                            trigger: '#dt',
                            // offset: [0, 1],
                            zIndex: 999,
                            onSelected: function (view, date, data) {
                                console.log('event: onSelected')
                            },
                            onClose: function (view, date, data) {
                                console.log('event: onClose')
                                console.log('view:' + view)
                                console.log('date:' + date)
                                console.log('data:' + (data || 'None'));
                            }
                        });
                      var _gaq = _gaq || [];
                      _gaq.push(['_setAccount', 'UA-36251023-1']);
                      _gaq.push(['_setDomainName', 'jqueryscript.net']);
                      _gaq.push(['_trackPageview']);

                      (function() {
                        var ga = document.createElement('script'); ga.type = 'text/javascript'; ga.async = true;
                        ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';
                        var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(ga, s);
                      })();
                    ");
    }

}
