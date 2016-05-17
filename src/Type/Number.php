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

namespace Umbrella\YaBoleto\Type;

/**
 * Classe para manipulação de números.
 *
 * @author  Italo Lelis <italolelis@gmail.com>
 * @package YaBoleto
 */
class Number
{
    /**
     * Retorna um número formatado.
     *
     * @param  integer $number
     * @return integer
     */
    public static function format($number)
    {
        return (int)($number * 100);
    }

    /**
     * Calcula o módulo 11.
     *
     * @param  integer $number
     * @param  string $ifTen
     * @param  string $ifZero
     * @param  boolean $returnFull
     * @param  integer $maxFactor
     * @param  string $separator
     * @return string
     */
    public static function modulo11(
        $number,
        $ifTen = '0',
        $ifZero = '0',
        $returnFull = false,
        $maxFactor = 9,
        $separator = '-'
    ) {
        $numLen = strlen($number) - 1;
        $sum = 0;
        $factor = 2;

        for ($i = $numLen; $i >= 0; $i--) {
            $sum += substr($number, $i, 1) * $factor;
            $factor = $factor >= $maxFactor ? 2 : $factor + 1;
        }
        #Resto da divisão
        $rest = ($sum * 10) % 11;
        #ifTen
        $rest = $rest == 10 ? $ifTen : $rest;
        #ifZero
        $rest = $rest === 0 ? $ifZero : $rest;
        #Verificando se é 0, 10
        switch ($rest) {
            case 10:
                $ifTen;
                break;
            case 0:
                $ifZero;
                break;
            default:
                $rest;
                break;
        }

        if ($returnFull === false) {
            return $rest;
        } else {
            return $number . $separator . $rest;
        }
    }

    /**
     * Calcula o módulo 10.
     *
     * @param  string $num
     * @return integer
     */
    public static function modulo10($num)
    {
        $numtotal10 = 0;
        $fator = 2;
        $numeros = array();
        $parcial10 = array();

        // Separacao dos numeros
        for ($i = strlen($num); $i > 0; $i--) {
            // pega cada numero isoladamente
            $numeros[$i] = substr($num, $i - 1, 1);
            // Efetua multiplicacao do numero pelo (falor 10)
            // 2002-07-07 01:33:34 Macete para adequar ao Mod10 do Itau
            $temp = $numeros[$i] * $fator;
            $temp0 = 0;
            foreach (preg_split('//', $temp, -1, PREG_SPLIT_NO_EMPTY) as $k => $v) {
                $temp0 += $v;
            }
            $parcial10[$i] = $temp0;
            // monta sequencia para soma dos digitos no (modulo 10)
            $numtotal10 += $parcial10[$i];
            if ($fator == 2) {
                $fator = 1;
            } else {
                $fator = 2; // intercala fator de multiplicacao (modulo 10)
            }
        }

        // varias linhas removidas, vide funcoes original
        // Calculo do modulo 10
        $resto = $numtotal10 % 10;
        $digito = 10 - $resto;
        if ($resto == 0) {
            $digito = 0;
        }

        return $digito;
    }

    /**
     * Calcula o fator vencimento.
     *
     * @param  \DateTime $data
     * @return integer
     */
    public static function fatorVencimento(\DateTime $data)
    {
        $dataBase = new \DateTime("1997-10-07");

        return (int)$data->diff($dataBase, true)->format('%r%a');
    }

}
