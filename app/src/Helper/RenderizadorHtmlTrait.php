<?php

namespace Alura\Cursos\Helper;

// Trait para renderizar html
trait RenderizadorHtmlTrait
{
    public function renderizaHtml(string $caminhoTemplate, array $dados): string
    {
        // Extract variables from associated array
        extract($dados);

        // Initialize buffer to save html in variables
        ob_start();
        require __DIR__ . '/../../view/'. $caminhoTemplate;

        // save html into a var
        $html = ob_get_contents();

        //clean buffer
        ob_get_clean();

        return $html;
    }
}