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
namespace Umbrella\Ya\Boleto;

/**
 * Contem as funcionalidades basicas para uma carteira
 * @author italo <italolelis@lellysinformatica.com>
 * @since 1.0.0
 */
interface ConvenioInterface
{

    /**
     * Retorna o layout do codigo de barras
     * @return string
     */
    public function getLayout();

    /**
     * @return AbstractConvenio
     */
    public function setLayout($layout);

    /**
     * Retorna o nosso numero
     * @return string
     */
    public function getNossoNumero();

    /**
     * Define o nosso numero
     * @param  string                                 $nossoNumero
     * @return \Umbrella\Ya\Boleto\Carteira\CarteiraInterface
     */
    public function setNossoNumero($nossoNumero);

    /**
     * Retorna os padroes de tamanhos para calculo do codigo de barras
     * @return string
     */
    public function getTamanhos();

    /**
     * Altera o valor de uma composiao dos tamanhos da carteira
     * @return void
     */
    public function alterarTamanho($index, $tamanho);
}
