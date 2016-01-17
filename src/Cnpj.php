<?php

namespace Umbrella\YaBoleto;

use Umbrella\YaBoleto\Exception\CnpjInvalidoException;

final class Cnpj extends Documento
{
    /**
     * Mascara constructor.
     * @param string $value
     */
    public function __construct($value)
    {
        $this->validate($value);
        parent::__construct($value);
    }

    public function validate($value)
    {
        if (!Validator::cnpj($value)) {
            throw new CnpjInvalidoException(sprintf("O CNPJ %s informado é inválido", $value));
        }

        return $this;
    }
}
