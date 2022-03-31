<?php

if (!function_exists('str_only_alphanumeric')) {
    /**
     * Retorna somente as letras e dígitos de uma string
     * - Letras com acento também são removidas
     *
     * @param  string $value
     * @return string
     */
    function str_only_alphanumeric(?string $value): string
    {
        return preg_replace('/[^a-zA-Z0-9]+/', '', $value);
    }
}

if (!function_exists('str_only_digits')) {
    /**
     * Retorna somente os dígitos de uma string
     *
     * @param  string $value
     * @return string
     */
    function str_only_digits(?string $value): string
    {
        return preg_replace('~\D~', '', $value);
    }
}

if (!function_exists('dec_to_brl')) {
    /**
     * Retorna o valor da conversão do valor decimal para real brasileiro
     *
     * @param  string $value
     * @return string
     */
    function dec_to_brl(?string $value): string
    {
        return number_format($value, 2, ',', '.');
    }
}

if (!function_exists('brl_to_dec')) {
    /**
     * Retorna o valor da conversão do valor real brasileiro para decimal
     *
     * @param  string $value
     * @return string
     */
    function brl_to_dec(?string $value): string
    {
        $value = str_replace(['R$', '.', ','], ['', '', '.'], $value);
        return trim($value);
    }
}

if (!function_exists('date_to_br')) {
    /**
     * Retorna o valor da conversão da data americana para o formato brasileiro
     *
     * @param  string $value
     * @return string
     */
    function date_to_br(?string $value): string
    {
        return date('d/m/Y', strtotime($value));
    }
}

if (!function_exists('datetime_to_br')) {
    /**
     * Retorna o valor da conversão da data e hora (datetime) americana para o
     * formato brasileiro
     *
     * @param  string $value
     * @return string
     */
    function datetime_to_br(?string $value): string
    {
        return date('d/m/Y H:i:s', strtotime($value));
    }
}

if (!function_exists('bracket_to_dot')) {
    /**
     * Retorna o nome na notação com pontos
     * Ex.: A string "product[brand][name]" retornará "product.brand.name"
     *
     * @param  string $value
     * @return string
     */
    function bracket_to_dot(?string $value): string|null
    {
        if (empty($value)) {
            return null;
        }

        if (mb_strpos($value, '[') === false && mb_strpos($value, ']') === false) {
            return $value;
        }

        return mb_ereg_replace('\]', '', mb_ereg_replace('\[', '.', $value));
    }
}
