<?php

return [
    'default_ssh_groups' => explode(',', env('DEFAULT_SSH_GROUPS', 'administrator')),
    'ssh_keys' => [
        [
            'owner' => 'Jian',
            'key' => 'ssh-rsa ABCDE1234 Jian@Company',
        ],
        [
            'owner' => 'Ken',
            'key' => 'ssh-rsa QWERT4321 Ken@Company',
        ],
        [
            'owner' => 'Bill',
            'key' => 'ssh-rsa DKKWOW3221 Bill@Company',
        ],
    ],
    'groups' => [
        'administrator' => [
            'Jian',
        ],
        'developer' => [
            'Jian', 'Ken', 'Bill',
        ],
    ],
];