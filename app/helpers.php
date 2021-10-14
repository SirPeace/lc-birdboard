<?php

function gravatar_url(string $email): string
{
    return "https://gravatar.com/avatar/".md5($email)."?d=mp&s=60";
}
