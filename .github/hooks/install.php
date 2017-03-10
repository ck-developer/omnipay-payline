<?php

if (file_exists('.git/hooks/pre-commit')) {
    copy('.git/hooks/pre-commit', '.git/hooks/pre-commit.back');
    echo "A Git pre-commit file was found, a backup was created.\n";
}
if (file_exists(__DIR__ . '/pre-commit')) {
    copy(__DIR__ . '/pre-commit', '.git/hooks/pre-commit');
    chmod('.git/hooks/pre-commit', 0750);
    echo "\e[32mPre-commit Hook has been installed.\e[0;m\n";
}
