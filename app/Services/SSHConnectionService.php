<?php


namespace App\Services;


class SSHConnectionService
{
    public function run(string $serviceName, array $runScript)
    {
        return \SSH::into($serviceName)
            ->run($runScript, function ($output) {
                return $output;
            });
    }
}