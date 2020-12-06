# Multiple Server SSH Keys Management

## Installation
### Initialize Laravel and packages
```bash
cp .env.example .env
chown -R 1000:1000 storage bootstrap/cache
chmod 755 -R storage bootstrap/cache
composer install
```

### Initialize and setting config files
#### Update Server config file: `config/remote`
```bash
cp config/remote-example config/remote
```

#### Update developer SSH keys config file: `config/developer_ssh_keys`
```bash
cp config/developer_ssh_keys-example config/developer_ssh_keys
```

#### Update default SSH groups: `.env`
```
DEFAULT_SSH_GROUPS=administrator,developer
```



## Usage
```bash
php artisan update_server_ssh_key
```