<?php


namespace App\Services;


use Illuminate\Support\Collection;

class SSHKeyService
{
    private $groups;
    private $sshKeys;

    public function __construct()
    {
        $this->groups = collect(config('developer_ssh_keys.groups'));
        $this->sshKeys = collect(config('developer_ssh_keys.ssh_keys'));
    }

    public function getAll(): Collection
    {
        return $this->sshKeys;
    }

    public function find(string $name): string
    {
        return $this->sshKeys
            ->first(function ($ssgKey) use ($name) {
                return $ssgKey['owner'] === $name;
            });
    }

    public function get(array $names): Collection
    {
        return $this->sshKeys
            ->filter(function ($ssgKey) use ($names) {
                return in_array($ssgKey['owner'], $names);
            });
    }

    public function getByGroup(array $groupNames): Collection
    {
        $members = $this->groups
            ->filter(function ($groupMembers, $groupName) use ($groupNames) {
                return in_array($groupName, $groupNames);
            })
            ->collapse()
            ->unique()
            ->toArray();
        return $this->get($members);
    }
}