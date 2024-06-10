<?php

namespace Html;

trait StringEscaper
{
    /**
     * Permet de se protéger les caractères spéciaux pouvant dégrader la page Web.
     * @param string $string : la chaine de caractère sans ces caractères spéciaux
     * @return string
     */
    public function escapeString(?string $string = ""): string
    {
        return htmlspecialchars($string, ENT_QUOTES | ENT_HTML5);
    }

    public function stripTagsAndTrim(?string $text): string
    {
        $text = $this->escapeString($text);
        $text = strip_tags($text);
        $text = trim($text);
        return $text ?? "";

    }
}
