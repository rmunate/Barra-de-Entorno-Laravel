<?php

namespace App\Clases;

use Illuminate\Foundation\Application;

/**
 * --------------------------------------------------------------------------
 * BARRA DE ENTORNO PARA PROYECTOS MONOLITICOS LARAVEL
 * --------------------------------------------------------------------------
 *
 * Permite mostrarle al usuario el entorno sobre el cual se está corriendo el sistema.
 * Permite al equipo de trabajo colaborativo conocer la infraestructura del sistema.
 * Diseño sutil y profesional.
 * Ideal para Proyectos Laravel.
 *
 * --------------------------------------------------------------------------
 *
 * AUTOR: ING. RAUL MAURICIO UÑATE CASTRO
 * V: 1.0.1
 * STATIC::CLASS
 *
 * METODOS USO ESTATICO
 * @method  EnvBar::all() | Retorna un array con el detalle del Entorno de la herramienta.
 * @method  EnvBar::html([inf,dev,pro]) | Retorna los Festivos de un Año o de Todos los Años Disponibles en la clase.
 *
 */

class EnvBar {

    /**
     * Consulta Datos Entorno.
     * @return Object
     */
    public static function all(){

        /* Versionaes */
        $versionPhp = phpversion();
        $versionLaravel = Application::VERSION;

        /* Ambiente */
        if (isset($_SERVER['HTTP_REFERER'])) {
            $url = $_SERVER['HTTP_REFERER'];
            $url = strval($url);
            /* Protocolo */
            $protocolo = explode(':',$url)[0];
            $protocolo = strval($protocolo);
        } else {
            $protocolo = strval($_SERVER['REQUEST_SCHEME']);
        }

        /* Dominio */
        $dominio = $_SERVER['SERVER_NAME'];
        $dominio = strval($dominio);

        /*Domimios Locales */
        $dominiosLocales = array('.test','localhost','public','.server','127.0.0.1');

        /*Domimios Web */
        $dominiosWeb = array('.com.co','.com','.co','.net','.org','.info','.biz','.edu','.edu.co','.mil','.gob','.xxx','.xyz','.site', '.shop', '.me', '.art', '.space','.fit', '.cloud', '.monster', '.inc', '.health', '.foundation', '.host', '.fun', '.photography', '.party');

        if ($protocolo == 'http') {
            /* Validar si es un dominio Local */
            foreach ($dominiosLocales as $dominioLocal) {
                if (str_contains($dominio, $dominioLocal)) {
                    $dominioEspecifico = $dominioLocal;
                    $entorno = 'Entorno Local';
                }
            }
            /* Validar si es un dominio Web  */
            foreach ($dominiosWeb as $dominioWeb) {
                if (str_contains($dominio, $dominioWeb)) {
                    $dominioEspecifico = $dominioWeb;
                    $entorno = 'Entorno de Pruebas (QA)';
                }
            }
        } else if ($protocolo == 'https'){
            foreach ($dominiosWeb as $dominioWeb) {
                if (str_contains($dominio, $dominioWeb)) {
                    $dominioEspecifico = $dominioWeb;
                    $entorno = 'Producción';
                }
            }
        } else {
            $dominioEspecifico = 'undefined';
            $entorno = 'undefined';
        }

        return (object) array(
            'PHP' => $versionPhp,
            'LARAVEL_FRAMEWORK' => $versionLaravel,
            'PROTOCOLO' => $protocolo,
            'DOMINIO' => $dominio,
            'DOMINIO_ESPECIFICO' => ltrim($dominioEspecifico, '.'),
            'ENTORNO' => $entorno,
        );
    }

    /**
     * Barra HTML para Front
     * @return Html
     */
    public static function html(string $versiones = 'PLEH', string $desarollador = null, string $urlProduccion = null){

        /* Validacion Parametros */
        if (strlen($versiones) <= 4) {

            /* Consulta de Data */
            $data = Self::all();
            $phpVersion = $data->PHP;
            $laravelVersion = $data->LARAVEL_FRAMEWORK;
            $entorno = $data->ENTORNO;
            $http = strtoupper($data->PROTOCOLO);

            /* Estilos */
            $style  =   '
            <style>
                .altum-bar {

                    /* Padding Interno */
                    padding-top: 10px;
                    padding-bottom: 10px;
                    padding-right: 15px;

                    /* Alineacion */
                    text-align: right;

                    /* Estilo de Texto */
                    font-size: 13px;
                    font-family: "Lucida Grande", "Lucida Sans Unicode", "Lucida Sans", Geneva, Verdana, sans-serif;
                    direction: ltr;
                    z-index: 6000000;
                    color: #472904;
                    letter-spacing: normal;
                    line-height: 1;

                    /* Bordes */
                    border-top: 1px solid #283747;
                    box-sizing: border-box;
                    -webkit-border-top-left-radius: 10px;
                    -moz-border-radius-topleft: 10px;
                    border-top-left-radius: 10px;

                    /* Posicion */
                    position: fixed;
                    bottom: 0;
                    right: 0;

                    /* Ancho */
                    width: 80%;

                    /* Display */
                    display: block;

                    /* Fondo */
                    background: #f5f5f5;
                }
            </style>';

            /* Contenedor */
            $divOpen = '<div class="altum-bar">';

            $vPHP = '
            <!-- Seccion Version PHP -->
            <svg xmlns="http://www.w3.org/2000/svg" width="28.480492" height="15.439" viewBox="0 0 640 512" fill="#014568"><path d="M320 104.5c171.4 0 303.2 72.2 303.2 151.5S491.3 407.5 320 407.5c-171.4 0-303.2-72.2-303.2-151.5S148.7 104.5 320 104.5m0-16.8C143.3 87.7 0 163 0 256s143.3 168.3 320 168.3S640 349 640 256 496.7 87.7 320 87.7zM218.2 242.5c-7.9 40.5-35.8 36.3-70.1 36.3l13.7-70.6c38 0 63.8-4.1 56.4 34.3zM97.4 350.3h36.7l8.7-44.8c41.1 0 66.6 3 90.2-19.1 26.1-24 32.9-66.7 14.3-88.1-9.7-11.2-25.3-16.7-46.5-16.7h-70.7L97.4 350.3zm185.7-213.6h36.5l-8.7 44.8c31.5 0 60.7-2.3 74.8 10.7 14.8 13.6 7.7 31-8.3 113.1h-37c15.4-79.4 18.3-86 12.7-92-5.4-5.8-17.7-4.6-47.4-4.6l-18.8 96.6h-36.5l32.7-168.6zM505 242.5c-8 41.1-36.7 36.3-70.1 36.3l13.7-70.6c38.2 0 63.8-4.1 56.4 34.3zM384.2 350.3H421l8.7-44.8c43.2 0 67.1 2.5 90.2-19.1 26.1-24 32.9-66.7 14.3-88.1-9.7-11.2-25.3-16.7-46.5-16.7H417l-32.8 168.7z"/></svg>
            <!-- Version -->
            <span>' . $phpVersion . '</span>';

            $vLaravel = '
            <!-- Seccion Version Laravel -->
            <svg xmlns="http://www.w3.org/2000/svg" width="28.480492" height="15.439" viewBox="0 0 512 512" fill="#014568"><path d="M504.4,115.83a5.72,5.72,0,0,0-.28-.68,8.52,8.52,0,0,0-.53-1.25,6,6,0,0,0-.54-.71,9.36,9.36,0,0,0-.72-.94c-.23-.22-.52-.4-.77-.6a8.84,8.84,0,0,0-.9-.68L404.4,55.55a8,8,0,0,0-8,0L300.12,111h0a8.07,8.07,0,0,0-.88.69,7.68,7.68,0,0,0-.78.6,8.23,8.23,0,0,0-.72.93c-.17.24-.39.45-.54.71a9.7,9.7,0,0,0-.52,1.25c-.08.23-.21.44-.28.68a8.08,8.08,0,0,0-.28,2.08V223.18l-80.22,46.19V63.44a7.8,7.8,0,0,0-.28-2.09c-.06-.24-.2-.45-.28-.68a8.35,8.35,0,0,0-.52-1.24c-.14-.26-.37-.47-.54-.72a9.36,9.36,0,0,0-.72-.94,9.46,9.46,0,0,0-.78-.6,9.8,9.8,0,0,0-.88-.68h0L115.61,1.07a8,8,0,0,0-8,0L11.34,56.49h0a6.52,6.52,0,0,0-.88.69,7.81,7.81,0,0,0-.79.6,8.15,8.15,0,0,0-.71.93c-.18.25-.4.46-.55.72a7.88,7.88,0,0,0-.51,1.24,6.46,6.46,0,0,0-.29.67,8.18,8.18,0,0,0-.28,2.1v329.7a8,8,0,0,0,4,6.95l192.5,110.84a8.83,8.83,0,0,0,1.33.54c.21.08.41.2.63.26a7.92,7.92,0,0,0,4.1,0c.2-.05.37-.16.55-.22a8.6,8.6,0,0,0,1.4-.58L404.4,400.09a8,8,0,0,0,4-6.95V287.88l92.24-53.11a8,8,0,0,0,4-7V117.92A8.63,8.63,0,0,0,504.4,115.83ZM111.6,17.28h0l80.19,46.15-80.2,46.18L31.41,63.44Zm88.25,60V278.6l-46.53,26.79-33.69,19.4V123.5l46.53-26.79Zm0,412.78L23.37,388.5V77.32L57.06,96.7l46.52,26.8V338.68a6.94,6.94,0,0,0,.12.9,8,8,0,0,0,.16,1.18h0a5.92,5.92,0,0,0,.38.9,6.38,6.38,0,0,0,.42,1v0a8.54,8.54,0,0,0,.6.78,7.62,7.62,0,0,0,.66.84l0,0c.23.22.52.38.77.58a8.93,8.93,0,0,0,.86.66l0,0,0,0,92.19,52.18Zm8-106.17-80.06-45.32,84.09-48.41,92.26-53.11,80.13,46.13-58.8,33.56Zm184.52,4.57L215.88,490.11V397.8L346.6,323.2l45.77-26.15Zm0-119.13L358.68,250l-46.53-26.79V131.79l33.69,19.4L392.37,178Zm8-105.28-80.2-46.17,80.2-46.16,80.18,46.15Zm8,105.28V178L455,151.19l33.68-19.4v91.39h0Z"/></svg>
            <!-- Version -->
            <span>' . $laravelVersion . '</span>';

            $vEntorno = '
            <!-- Seccion Entorno -->
            <svg xmlns="http://www.w3.org/2000/svg" width="28.480492" height="15.439" viewBox="0 0 448 512" fill="#014568"><path d="M427.84 380.67l-196.5 97.82a18.6 18.6 0 0 1-14.67 0L20.16 380.67c-4-2-4-5.28 0-7.29L67.22 350a18.65 18.65 0 0 1 14.69 0l134.76 67a18.51 18.51 0 0 0 14.67 0l134.76-67a18.62 18.62 0 0 1 14.68 0l47.06 23.43c4.05 1.96 4.05 5.24 0 7.24zm0-136.53l-47.06-23.43a18.62 18.62 0 0 0-14.68 0l-134.76 67.08a18.68 18.68 0 0 1-14.67 0L81.91 220.71a18.65 18.65 0 0 0-14.69 0l-47.06 23.43c-4 2-4 5.29 0 7.31l196.51 97.8a18.6 18.6 0 0 0 14.67 0l196.5-97.8c4.05-2.02 4.05-5.3 0-7.31zM20.16 130.42l196.5 90.29a20.08 20.08 0 0 0 14.67 0l196.51-90.29c4-1.86 4-4.89 0-6.74L231.33 33.4a19.88 19.88 0 0 0-14.67 0l-196.5 90.28c-4.05 1.85-4.05 4.88 0 6.74z" class="a"/></svg>
            <!-- Entorno -->
            <span>' . $entorno . '</span>';

            $vHTTP = '
            <!-- Seccion Protocolo -->
            <svg xmlns="http://www.w3.org/2000/svg" width="28.480492" height="15.439" viewBox="0 0 512 512" fill="#014568"><path d="M256-.0078C260.7-.0081 265.2 1.008 269.4 2.913L457.7 82.79C479.7 92.12 496.2 113.8 496 139.1C495.5 239.2 454.7 420.7 282.4 503.2C265.7 511.1 246.3 511.1 229.6 503.2C57.25 420.7 16.49 239.2 15.1 139.1C15.87 113.8 32.32 92.12 54.3 82.79L242.7 2.913C246.8 1.008 251.4-.0081 256-.0078V-.0078zM256 444.8C393.1 378 431.1 230.1 432 141.4L256 66.77L256 444.8z"/></svg>
            <!-- Protocolo -->
            <span>' . $http . '</span>';

            $divClose = '</div>';

            /* Separador */
            $vSeparador = '<span style="color: #014568;"> | </span>';

            $outHTML = array();
            if (str_contains($versiones, 'P')) {
                array_push($outHTML, $vPHP);
            }
            if (str_contains($versiones, 'L')) {
                array_push($outHTML, $vLaravel);
            }
            if (str_contains($versiones, 'E')) {
                array_push($outHTML, $vEntorno);
            }
            if (str_contains($versiones, 'H')) {
                array_push($outHTML, $vHTTP);
            }

            if ($desarollador != null) {
                $vDesarrollador = '
                <svg xmlns="http://www.w3.org/2000/svg" width="28.480492" height="15.439" viewBox="0 0 640 512" fill="#014568"><path d="M414.8 40.79L286.8 488.8C281.9 505.8 264.2 515.6 247.2 510.8C230.2 505.9 220.4 488.2 225.2 471.2L353.2 23.21C358.1 6.216 375.8-3.624 392.8 1.232C409.8 6.087 419.6 23.8 414.8 40.79H414.8zM518.6 121.4L630.6 233.4C643.1 245.9 643.1 266.1 630.6 278.6L518.6 390.6C506.1 403.1 485.9 403.1 473.4 390.6C460.9 378.1 460.9 357.9 473.4 345.4L562.7 256L473.4 166.6C460.9 154.1 460.9 133.9 473.4 121.4C485.9 108.9 506.1 108.9 518.6 121.4V121.4zM166.6 166.6L77.25 256L166.6 345.4C179.1 357.9 179.1 378.1 166.6 390.6C154.1 403.1 133.9 403.1 121.4 390.6L9.372 278.6C-3.124 266.1-3.124 245.9 9.372 233.4L121.4 121.4C133.9 108.9 154.1 108.9 166.6 121.4C179.1 133.9 179.1 154.1 166.6 166.6V166.6z"/></svg>
                <!-- Desarrollador -->
                <span>' . trim($desarollador) . '</span>';
                array_push($outHTML, $vDesarrollador);
            }

            if ($urlProduccion != null) {
                $vUrlDesarrollo = '
                <svg xmlns="http://www.w3.org/2000/svg" width="28.480492" height="15.439" viewBox="0 0 512 512" fill="#014568"><path d="M352 256C352 278.2 350.8 299.6 348.7 320H163.3C161.2 299.6 159.1 278.2 159.1 256C159.1 233.8 161.2 212.4 163.3 192H348.7C350.8 212.4 352 233.8 352 256zM503.9 192C509.2 212.5 512 233.9 512 256C512 278.1 509.2 299.5 503.9 320H380.8C382.9 299.4 384 277.1 384 256C384 234 382.9 212.6 380.8 192H503.9zM493.4 160H376.7C366.7 96.14 346.9 42.62 321.4 8.442C399.8 29.09 463.4 85.94 493.4 160zM344.3 160H167.7C173.8 123.6 183.2 91.38 194.7 65.35C205.2 41.74 216.9 24.61 228.2 13.81C239.4 3.178 248.7 0 256 0C263.3 0 272.6 3.178 283.8 13.81C295.1 24.61 306.8 41.74 317.3 65.35C328.8 91.38 338.2 123.6 344.3 160H344.3zM18.61 160C48.59 85.94 112.2 29.09 190.6 8.442C165.1 42.62 145.3 96.14 135.3 160H18.61zM131.2 192C129.1 212.6 127.1 234 127.1 256C127.1 277.1 129.1 299.4 131.2 320H8.065C2.8 299.5 0 278.1 0 256C0 233.9 2.8 212.5 8.065 192H131.2zM194.7 446.6C183.2 420.6 173.8 388.4 167.7 352H344.3C338.2 388.4 328.8 420.6 317.3 446.6C306.8 470.3 295.1 487.4 283.8 498.2C272.6 508.8 263.3 512 255.1 512C248.7 512 239.4 508.8 228.2 498.2C216.9 487.4 205.2 470.3 194.7 446.6H194.7zM190.6 503.6C112.2 482.9 48.59 426.1 18.61 352H135.3C145.3 415.9 165.1 469.4 190.6 503.6V503.6zM321.4 503.6C346.9 469.4 366.7 415.9 376.7 352H493.4C463.4 426.1 399.8 482.9 321.4 503.6V503.6z"/></svg>
                <!-- Desarrollador -->
                <strong>Producción: </strong><a href="//'.$urlProduccion.'">'.trim($urlProduccion).'</a>';
                array_push($outHTML, $vUrlDesarrollo);
            }

            /* Generar Salida */
            $outHtmlGenerate = $style;
            $outHtmlGenerate .= $divOpen;
            $iteracion = 0;
            foreach ($outHTML as $key => $value) {
                $outHtmlGenerate .= $value;
                if ($iteracion != (count($outHTML) - 1)) {
                    $outHtmlGenerate .= $vSeparador;
                }
                $iteracion++;
            }
            $outHtmlGenerate .= $divClose;

            if (env('APP_DEBUG',false)) {
                return $outHtmlGenerate;
            }

        }
    }

}
