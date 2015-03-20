<?php
/*
 * The MIT License
 *
 * Copyright 2013 italo.
 *
 * Permission is hereby granted, free of charge, to any person obtaining a copy
 * of this software and associated documentation files (the "Software"), to deal
 * in the Software without restriction, including without limitation the rights
 * to use, copy, modify, merge, publish, distribute, sublicense, and/or sell
 * copies of the Software, and to permit persons to whom the Software is
 * furnished to do so, subject to the following conditions:
 *
 * The above copyright notice and this permission notice shall be included in
 * all copies or substantial portions of the Software.
 *
 * THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
 * IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
 * FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
 * AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
 * LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
 * OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN
 * THE SOFTWARE.
 */

namespace Umbrella\YaBoleto;

/**
 * Classe que representa uma pessoa física.
 * 
 * @author  Italo Lelis <italolelis@lellysinformatica.com>
 * @package YaBoleto
 */
class PessoaFisica extends Pessoa
{
    /** @var string CPF da pessoa física */
    protected $cpf;

    /**
     * Inicializa uma nova instância da classe \Umbrella\YaBoleto\PessoaFisica.
     * 
     * @param string $nome             Nome da pessoa física
     * @param string $cpf              CPF da pessoa física
     * @param array  $enderecoCompleto Endereço da pessoa jurídica - array('logradouro' => '', 'cep' => '', 'cidade' => '', 'uf' => '')
     */
    public function __construct($nome, $cpf, array $endereco)
    {
        parent::__construct($nome, $endereco);
        $this->setCpf($cpf);
    }

    /**
     * Retorna o CPF da pessoa física.
     * 
     * @return string
     */
    public function getCpf()
    {
        return $this->cpf;
    }

    /**
     * Define o CPF da pessoa física.
     * 
     * @param string $cpf CPF da pessoa física
     * @return \Umbrella\YaBoleto\PessoaFisica
     */
    public function setCpf($cpf)
    {
        if (!Validator::cpf($cpf)) {
            throw new \InvalidArgumentException("O CPF informado é inválido");
        }
        $this->cpf = $cpf;

        return $this;
    }

}
