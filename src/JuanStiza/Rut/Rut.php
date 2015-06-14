<?php

namespace JuanStiza\Rut;

class Rut {

    /**
     * Rut's verifying digit
     * @var string
     */
    public $dv = '';

    /**
     * The Rut
     * @var integer
     */
    public $rut = null;

    /**
     * Determins if Rut is valid.
     * @var bool
     */
    public $isValid = false;

    /**
     * Contstruct
     * @param string $rut The rut string
     * @param string $dv  The verifying digit
     */
    public function __construct($rut)
    {
        $args = func_get_args();
        /**
         * If we don't have a verifying digit.
         */
        if (count($args) == 1)
        {
            $sanitize = trim((string) $args[0]);
            $sanitize = str_replace( '.', '',$sanitize);
            $sanitize = str_replace( '-', '',$sanitize);
            $this->dv = substr($sanitize, -1);
            $this->rut = substr($sanitize, 0, strlen($sanitize) - 1);
            if (strlen($this->rut) < 1) throw new \Exception("Rut has wrong length.");
        }
        // We have it
        else
        {
            $rut = $args[0];
            $this->dv = (string) $args[1];
            if (!is_integer((integer) $rut))
              throw new \Exception('Rut '.$this->rut.' must be integer');
            $this->rut = $rut;
        }
        if (!preg_match('/[0-9kK]/',$this->dv))
          throw new \Exception('Verifying digit: '.$this->dv.' has wrong format');

        $this->isValid = $this->dv == self::findDV((integer) $this->rut);
        return $this;
    }

    /**
     * Returns the verifying digit for a partial Rut.
     * @param $rut  integer   The partial Rut
     * @return string
     */
    public static function findDV($rut)
    {
        $s = 1;
        for ($i = 0;$rut != 0; $rut /= 10) {
            $s = ($s + $rut % 10 * (9 - $i++%6)) % 11;
        }
        return chr($s?$s+47:75);
    }

    /**
     * Return formated string
     * @param  string $numberSeparator Decimal separator
     * @param  string $digitSeparator  Verifying digit separator
     * @return string                  Formated Rut, defaults: xx.xxx.xxx-d
     */
    public function format($numberSeparator = '.', $digitSeparator = '-')
    {
      return number_format($this->rut, 0, '', $numberSeparator) . $digitSeparator . $this->dv;
    }

}
