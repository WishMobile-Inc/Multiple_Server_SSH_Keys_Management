<?php


namespace App\Services;


class UpdateServerSSHKeyService
{
    private $SSHKeyService;
    private $serverInfoList;
    private $SSHConnectionService;

    public function __construct(
        SSHKeyService $SSHKeyService,
        SSHConnectionService $SSHConnectionService
    ) {
        $this->SSHKeyService = $SSHKeyService;
        $this->SSHConnectionService = $SSHConnectionService;
        $this->serverInfoList = collect(config('remote.connections'));
    }

    public function update(string $serviceName)
    {
        $serverInfo = $this->getServerInfoList($serviceName);
        $this->runUpdateScript($serviceName, $serverInfo['developer_ssh_key_groups']);
    }

    private function runUpdateScript(string $serverName, array $sshGroups)
    {
        $script = $this->getUpdateSSHKeysScript($sshGroups);
        $this->SSHConnectionService->run($serverName, $script);
    }

    private function getServerInfoList(string $serverName): array
    {
        return $this->serverInfoList
            ->first(function ($serverInfo, $serverInfoName) use ($serverName) {
                return $serverInfoName === $serverName;
            });
    }

    private function getUpdateSSHKeysScript(array $sshGroups): array
    {
        $sshKeys = $this->SSHKeyService
            ->getByGroup($sshGroups)
            ->pluck('key')
            ->implode(PHP_EOL . PHP_EOL);

        return [
            "echo '" . $sshKeys . "' > /root/.ssh/authorized_keys",
            'chmod 600 /root/.ssh/authorized_keys',
        ];
    }
}