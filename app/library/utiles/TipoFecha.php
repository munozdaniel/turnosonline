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
        else return "";
    }
}