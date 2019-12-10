<?php

namespace System;

class Console
{
    public function handle()
    {
        $command = $_SERVER['argv'][1] ?? 'help';
        $arguments = array_slice($_SERVER['argv'], 2);

        $method = $command . 'Command';
        if (method_exists($this, $method)) {
            echo call_user_func([$this, $method], $arguments);
            exit(0);
        }

        echo "ERROR. No available method '{$method}' in Console!\n\n";
        exit(-1);
    }

    private function helpCommand()
    {
        echo "Read README.md\n";
    }
}
