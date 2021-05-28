<?php

namespace Alura\Cursos\Helper;

// trait para definir mensagens no template
trait FlashMessageTrait
{
    // recebo os parametros da mensagem e salvo em session
    public function defineMensagem(string $tipoMensagem, string $mensagem): void
    {
        $_SESSION['mensagem'] = $mensagem;
        $_SESSION['tipoMensagem'] = $tipoMensagem;
    }
}