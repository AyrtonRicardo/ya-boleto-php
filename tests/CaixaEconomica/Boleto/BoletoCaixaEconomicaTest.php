<?php

/*
 * The MIT License
 *
 * Copyright 2013 Umbrella Tech.
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
namespace Umbrella\Ya\Boleto\Tests\CaixaEconomica\Boleto;

use DateTime;
use LogicException;
use Umbrella\Ya\Boleto\AbstractConvenio;
use Umbrella\Ya\Boleto\Bancos\CaixaEconomica\Boleto\CaixaEconomica as BoletoCaixaEconomica;
use Umbrella\Ya\Boleto\Bancos\CaixaEconomica\Boleto\CaixaEconomica as CaixaEconomica2;
use Umbrella\Ya\Boleto\Bancos\CaixaEconomica\CaixaEconomica;
use Umbrella\Ya\Boleto\Bancos\CaixaEconomica\Carteira\CarteiraSicob;
use Umbrella\Ya\Boleto\Bancos\CaixaEconomica\Carteira\CarteiraSigcb;
use Umbrella\Ya\Boleto\Bancos\CaixaEconomica\Convenio;
use Umbrella\Ya\Boleto\Cedente;
use Umbrella\Ya\Boleto\PessoaFisica;
use Umbrella\Ya\Boleto\Sacado;
use Umbrella\Ya\Boleto\Tests\BoletoTestCase;
use Umbrella\Ya\Boleto\Tests\Mock\Carteira as CarteiraMock;

/**
 * Description of BoletoCaixaEconomicaTest
 *
 * @author edmo
 */
class BoletoCaixaEconomicaTest extends BoletoTestCase
{

    protected function bancoProvider()
    {
        return new CaixaEconomica("1101-0", "015776-7");
    }

    protected function convenioSigcbProvider()
    {
        $carteira = new CarteiraSigcb();
        return new Convenio($this->bancoProvider(), $carteira, "256945", "2");
    }

    protected function convenioSigcbTipoProvider()
    {
        $carteira = new CarteiraSigcb('RG');
        return new Convenio($this->bancoProvider(), $carteira, "256945", "2");
    }

    protected function convenioSicobProvider()
    {
        $carteira = new CarteiraSicob();
        return new Convenio($this->bancoProvider(), $carteira, "256945", "2");
    }

    public function boletoProvider()
    {
        return array(
            array($this->pessoaProvider(), $this->convenioSigcbProvider()),
            array($this->pessoaProvider(), $this->convenioSicobProvider()),
            array($this->pessoaProvider(), $this->convenioSigcbTipoProvider()),
        );
    }

    public function testCriacaoBoleto()
    {
        $banco = new CaixaEconomica('1101', '015776');
        $carteira = new CarteiraSigcb();
        $convenio = new Convenio($banco, $carteira, '808080', '789631');
        $pf = new PessoaFisica('Edmo Farias da Costa', "12345678909");
        $sacado = new Sacado($pf);
        $cedente = new Cedente('Empresa x', '92559708000103');

        $dataValida = date("Y-m-d");
        $data = new DateTime($dataValida);

        $boletoCEF = new CaixaEconomica2($sacado, $cedente, $convenio);
        $boletoCEF->setValorDocumento('388.99')
            ->setNumeroDocumento('01235')
            ->setDataVencimento($data)
            ->getLinhaDigitavel();
    }

    /**
     * @dataProvider boletoProvider
     */
    public function testCriacaoBoletoComBanco($pessoa, AbstractConvenio $convenio)
    {
        list($sacado, $cedente) = $pessoa;
        $boleto = new BoletoCaixaEconomica($sacado, $cedente, $convenio);
        $boleto->setValorDocumento(12.50)
            ->setNumeroDocumento("024588722")
            ->setDataVencimento(new DateTime("2014-02-28"))
            ->getLinhaDigitavel();

        $this->assertNotEmpty($boleto);
    }

    /**
     * @dataProvider boletoProvider
     */
    public function testBoletoComValorAlto($pessoa, $convenio)
    {
        list($sacado, $cedente) = $pessoa;
        $boleto = new BoletoCaixaEconomica($sacado, $cedente, $convenio);
        $boleto->setValorDocumento("315.500,00")
            ->setNumeroDocumento("23456")
            ->setDataVencimento(new DateTime("2013-11-02"))
            ->getLinhaDigitavel();

        $this->assertNotEmpty($boleto);
    }

    /**
     * @expectedException LogicException 
     * @dataProvider boletoProvider
     */
    public function testValorNegativo($pessoa, $convenio)
    {
        list($sacado, $cedente) = $pessoa;
        $boleto = new BoletoCaixaEconomica($sacado, $cedente, $convenio);
        $boleto->setValorDocumento(1.00)
            ->setDesconto(2.00)
            ->setNumeroDocumento("024588722")
            ->setDataVencimento(new DateTime("2013-11-02"))
            ->getLinhaDigitavel();

        $this->assertNotEmpty($boleto);
    }

    public function validarCamposObrigatoriosProvider()
    {
        $getMensagemException = function (array $nomesDosCampos) {
            $dadosFaltantes = implode("', '", $nomesDosCampos);
            return "Faltam dados a serem fornecidos ao boleto. ('{$dadosFaltantes}')";
        };

        $carteiraNormal = new CarteiraMock();
        $carteiraNormal->setNumero(18);

        $carteiraNumeroNull = new CarteiraMock();
        $carteiraNumeroNull->setNumero(null);

        $bancoNormal = new CaixaEconomica('agenciaTantoFaz', 'contaTantoFaz');
        $bancoAngenciaNull = new CaixaEconomica(null, 'contaTantoFaz');
        $bancoAngenciaContaNull = new CaixaEconomica(null, null);

        $convenioNormal = new Convenio($bancoNormal, $carteiraNormal, 'convenioTantoFaz', 'nossoNumeroTantoFaz');
        $convenioAgenciaNull = new Convenio($bancoAngenciaNull, $carteiraNormal, 'convenioTantoFaz',
                                            'nossoNumeroTantoFaz');
        $convenioAgenciaContaNull = new Convenio($bancoAngenciaContaNull, $carteiraNormal, 'convenioTantoFaz',
                                                 'nossoNumeroTantoFaz');
        $convenioAgenciaContaCarteiraNull = new Convenio($bancoAngenciaContaNull, $carteiraNumeroNull,
                                                         'convenioTantoFaz', 'nossoNumeroTantoFaz');

        return array(
            array(
                $this->pessoaProvider(),
                $convenioNormal,
                $getMensagemException(array('valor')),
            ),
            array(
                $this->pessoaProvider(),
                $convenioAgenciaNull,
                $getMensagemException(array('valor', 'agencia')),
            ),
            array(
                $this->pessoaProvider(),
                $convenioAgenciaContaNull,
                $getMensagemException(array('valor', 'agencia', 'conta')),
            ),
            array(
                $this->pessoaProvider(),
                $convenioAgenciaContaCarteiraNull,
                $getMensagemException(array('valor', 'agencia', 'conta', 'carteira')),
            ),
        );
    }

    /**
     * @dataProvider validarCamposObrigatoriosProvider
     */
    public function testValidarCamposObrigatorios($pessoa, Convenio $convenio, $mensagem)
    {
        $this->setExpectedException('InvalidArgumentException', $mensagem);
        list($sacado, $cedente) = $pessoa;
        $boleto = new BoletoCaixaEconomica($sacado, $cedente, $convenio);
        $boleto->setValorDocumento(null)->setConvenio($convenio);
        $boleto->validarDadosObrigatorios();
        $this->assertNotEmpty($boleto->getErros());
    }
}
