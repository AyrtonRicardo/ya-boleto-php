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
namespace Umbrella\Ya\Boleto\Tests\Santander\Boleto;

use DateTime;
use LogicException;
use Umbrella\Ya\Boleto\Bancos\Santander\Boleto\Santander as BoletoSantander;
use Umbrella\Ya\Boleto\Bancos\Santander\Carteira\Carteira101;
use Umbrella\Ya\Boleto\Bancos\Santander\Carteira\Carteira102;
use Umbrella\Ya\Boleto\Bancos\Santander\Carteira\Carteira201;
use Umbrella\Ya\Boleto\Bancos\Santander\Carteira\Carteira57;
use Umbrella\Ya\Boleto\Bancos\Santander\Convenio;
use Umbrella\Ya\Boleto\Bancos\Santander\Santander;
use Umbrella\Ya\Boleto\Tests\BoletoTestCase;

/**
 * Description of BoletoBancoBrasilTest
 *
 * @author italo
 */
class BoletoSantanderTest extends BoletoTestCase
{

    protected function bancoProvider()
    {
        $banco = new Santander("3857", "6188974");
        $banco->setIos(0);
        return $banco;
    }

    protected function convenio101Provider()
    {
        $carteira = new Carteira101();
        return new Convenio($this->bancoProvider(), $carteira, "0033418619006188974", "2");
    }

    protected function convenio102Provider()
    {
        $carteira = new Carteira102();
        return new Convenio($this->bancoProvider(), $carteira, "0033418619006188974", "2");
    }

    protected function convenio201Provider()
    {
        $carteira = new Carteira201();
        return new Convenio($this->bancoProvider(), $carteira, "0033418619006188974", "2");
    }

    protected function convenio57Provider()
    {
        $carteira = new Carteira57();
        return new Convenio($this->bancoProvider(), $carteira, "0033418619006188974", "2");
    }

    public function boletoProvider()
    {
        return array(
            array($this->pessoaProvider(), $this->convenio101Provider()),
            array($this->pessoaProvider(), $this->convenio102Provider()),
            array($this->pessoaProvider(), $this->convenio201Provider()),
            array($this->pessoaProvider(), $this->convenio57Provider())
        );
    }

    /**
     * @dataProvider boletoProvider
     */
    public function testCriacaoBoletoComBanco($pessoa, $convenio)
    {
        $boleto = new BoletoSantander($pessoa[0], $pessoa[1], $convenio);
        $boleto->setValorDocumento(1.00)
            ->setNumeroDocumento("024588722")
            ->setDataVencimento(new DateTime("2013-11-02"))
            ->getLinhaDigitavel();

        $this->assertNotEmpty($boleto);
    }

    /**
     * @dataProvider boletoProvider
     */
    public function testBoletoComValorAlto($pessoa, $convenio)
    {
        $boleto = new BoletoSantander($pessoa[0], $pessoa[1], $convenio);
        $boleto->setValorDocumento("1.500,00")
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
        $boleto = new BoletoSantander($pessoa[0], $pessoa[1], $convenio);
        $boleto->setValorDocumento(1.00)
            ->setDesconto(2.00)
            ->setNumeroDocumento("024588722")
            ->setDataVencimento(new DateTime("2013-11-02"))
            ->getLinhaDigitavel();

        $this->assertNotEmpty($boleto);
    }

    /**
     * @expectedException \InvalidArgumentException
     * @dataProvider boletoProvider
     */
    public function testValidacaoDadosObrigatorios($pessoa, $convenio)
    {
        $boleto = new BoletoSantander($pessoa[0], $pessoa[1], $convenio);
        $boleto->setValorDocumento(1.00)
            ->setNumeroDocumento("024588722")
            ->setDataVencimento(new DateTime("2013-11-02"))
            ->getLinhaDigitavel();

        $boleto->validarDadosObrigatorios();

        $this->assertNotEmpty($boleto);
    }
}
