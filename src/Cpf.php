<?php

namespace Umbrella\YaBoleto;

use Respect\Validation\Validator;
use Umbrella\YaBoleto\Exception\CpfInvalidoException;

final class Cpf extends Documento
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
        if (!Validator::cpf()->validate($value)) {
            throw new CpfInvalidoException(sprintf("O CPF %s informado é inválido", $value));
        }

        return $this;
    }
}
