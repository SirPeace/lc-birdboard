<?php

function get_theme_class(): string
{
    /** @var User|null $user */
    $user = auth()?->user();

    return $user?->dark_theme ? 'theme-dark' : 'theme-light';
}
