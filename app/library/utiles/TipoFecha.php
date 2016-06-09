<?php

class TipoFecha
{
    public static function modificaFecha($fecha)
    {
        if ($fecha == '0000-00-00') return '00-00-0000';

        if($fecha != null && $fecha != '')
        {
            $fechaFormat = new DateTime($fecha);
            return $fechaFormat->format('d-m-Y');
        }
        else
            return '00-00-0000';
    }

    public static function formatoCorrecto($fecha)
    {
        $fechaMod = new DateTime($fecha);
        $dia = $fechaMod->format('d');
        $mes = $fechaMod->format('m');
        $anio = $fechaMod->format('Y');
        $anioActual = Date('Y');

        if(($dia>=1 && $dia<=31) && ($mes>=1 && $mes<=12) && ($anio>=1990 && $anio<=$anioActual))
            return true;
        else
            return false;
    }

    /**
     * Data una fecha en formato 'Y-m-d' obtiene el mes y el dia para devolverlo en letras
     * @param $fecha
     * @return string
     */
    public static function fechaEnLetrasSinAnio($fecha)
    {
        $texto ="";

        if ($fecha != null && $fecha != "")
        {
            $ff = new DateTime($fecha);
            $dia = $ff->format('d');
            $mes = $ff->format('m');

            switch($mes)
            {
                case 1: $mes = 'Enero'; break;
                case 2: $mes = 'Febrero'; break;
                case 3: $mes = 'Marzo'; break;
                case 4: $mes = 'Abril'; break;
                case 5: $mes = 'Mayo'; break;
                case 6: $mes = 'Junio'; break;
                case 7: $mes = 'Julio'; break;
                case 8: $mes = 'Agosto'; break;
                case 9: $mes = 'Septiembre'; break;
                case 10: $mes = 'Octubre'; break;
                case 11: $mes = 'Noviembre'; break;
                case 12: $mes = 'Diciembre'; break;
            }

            $texto = $dia.' de '.$mes;
        }

        return $texto;
    }

    public static function fechaEnLetras($fecha)
    {
        if ($fecha == '00-00-0000') return "";

        if( $fecha != null && $fecha != "")
        {
            $fechaAmanipular = new DateTime($fecha);
            $dia = $fechaAmanipular->format('d');
            $mes = $fechaAmanipular->format('m');
            $anio = $fechaAmanipular->format('Y');

            switch($mes)
            {
                case 1: $mes = 'Enero'; break;
                case 2: $mes = 'Febrero'; break;
                case 3: $mes = 'Marzo'; break;
                case 4: $mes = 'Abril'; break;
                case 5: $mes = 'Mayo'; break;
                case 6: $mes = 'Junio'; break;
                case 7: $mes = 'Julio'; break;
                case 8: $mes = 'Agosto'; break;
                case 9: $mes = 'Septiembre'; break;
                case 10: $mes = 'Octubre'; break;
                case 11: $mes = 'Noviembre'; break;
                case 12: $mes = 'Diciembre'; break;
            }
            return $dia.' de '.$mes.' de '.$anio;
        }
        else
            return "";
    }

    /**
     * Suma los dias ingresados a la fecha y lo retorna en formato para base de datos.
     * @param $dias
     * @param $date
     * @return bool|int|string
     */
    public static function sumarDiasAlDate($dias,$date){
        $nuevafecha = strtotime ( '+'.$dias.' day' , strtotime ( $date ) ) ;
        $nuevafecha = date ( 'Y-m-d' , $nuevafecha );
        return $nuevafecha;
    }
   /* public function modificaFechaTimer()
    {
        $horaActual = date('H');

        if ($horaActual >=8)
        {
            $diaAnio = date('z');
            $fecha = Date("mY H:i:s");
        }


        //------------
       // $fechaFormat = new DateTime($date);
        //$anioQueViene = $fechaFormat->format('Y') + 1;
        //$proxFechaVencimiento = Date("31-12-$anioQueViene"); //se inserta la proxima fecha de vencimiento, 1 a�o exacto mas a la fecha de entrega del certificado
        //return $proxFechaVencimiento;
    }*/
    /**
     * Devuelve todos los dias que hay entre dos fechas.
     * @param $strDateFrom
     * @param $strDateTo
     * @return array
     */
    public static function devolverTodosLosDiasEntreFechas($strDateFrom,$strDateTo)
    {
        // takes two dates formatted as YYYY-MM-DD and creates an
        // inclusive array of the dates between the from and to dates.

        // could test validity of dates here but I'm already doing
        // that in the main script

        $aryRange=array();

        $iDateFrom=mktime(1,0,0,substr($strDateFrom,5,2),     substr($strDateFrom,8,2),substr($strDateFrom,0,4));
        $iDateTo=mktime(1,0,0,substr($strDateTo,5,2),     substr($strDateTo,8,2),substr($strDateTo,0,4));

        if ($iDateTo>=$iDateFrom)
        {
            array_push($aryRange,date('Y/m/d',$iDateFrom)); // first entry
            while ($iDateFrom<$iDateTo)
            {
                $iDateFrom+=86400; // add 24 hours
                array_push($aryRange,date('Y/m/d',$iDateFrom));
            }
        }
        return $aryRange;
    }
}