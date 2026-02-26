<?php

function echapperHtml($s) 
{
    return htmlspecialchars((string)$s, ENT_QUOTES, 'UTF-8');
}