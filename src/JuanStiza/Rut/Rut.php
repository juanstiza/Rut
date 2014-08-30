<?php

namespace JuanStiza\Rut;

class Rut {

    /**
     * El dígito verificador del Rut.
     * @var string
     */
    public $dv = '';

    /**
     * El Rut.
     * @var integer
     */
    public $rut = null;

    /**
     * Determina si el Rut es válido.
     * @var bool
     */
    public $isValid = false;

    /**
     * Creo un Rut a partir de un string.
     */
    public function __construct($rut)
    {
        $args = func_get_args();
        if (count($args) == 1)
        {
            /**
             * Para el caso de un Rut escrito con puntos y guión.
             * Ej.: 12.345.678-9
             */
            if (preg_match('/([0-9\.]+)(\-)([0-9kK])/',$args[0],$matches))
            {
                $this->rut = (integer) $matches[1];
                $this->dv = $matches[3];
            /**
             * Para el caso en el que no escribimos guión, NI puntos.
             * Ej.: 12345678K
             */
            }
            elseif (preg_match('/([0-9]+)([0-9kK])/', $args[0], $matches))
            {
                $this->rut = (integer) $matches[1];
                $this->dv = $matches[2];
            }
        }
        else
        {
            /**
             * Para el caso donde se especifica el dígito verificador.
             */
            $rut = $args[0];
            $digitoVerificador = (string) $args[1];
            if (!preg_match('/[0-9kK]/',$digitoVerificador)) throw new Exception('Wrong format!');
            if (!is_integer((integer)$rut)) throw new Exception('Must be integer');
            $this->rut = $rut;
            $this->dv = $digitoVerificador;
        }

        /* Definimos si el Rut es válido. */
        $this->isValid = $this->dv == self::validate($this->rut);
    }

    /**
     * Devuelve el dígito verificador para un determinado Rut.
     * @param $rut
     * @return string
     */
    private function validate($rut)
    {
        $s = 1;
        for ($i = 0;$rut != 0; $rut /= 10) {
            $s = ($s + $rut % 10 * (9 - $i++%6)) % 11;
        }
        return chr($s?$s+47:75);
    }

    /**
     * Devuelve el dígito verificador para determinado rut.
     * @param $rut
     * @return string
     */
    public static function getDigit($rut)
    {
        return self::validate((integer) $rut);
    }

}

