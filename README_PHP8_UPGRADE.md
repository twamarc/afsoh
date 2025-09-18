# PHP 8 Upgrade Bootstrap

This package contains your app code with:
- Short open tags normalized to `<?php`
- Legacy compatibility shims (`includes/compat/legacy_compat.php`) for `ereg*`, `split`, `each`, `set_magic_quotes_runtime`
- A PEAR::DB-compatible wrapper over PDO (`includes/DB.php`), wired via `includes/connect.inc.php`
- Docker stack for PHP 8.3 + Nginx + MySQL 8 (see `docker-compose.yml`)
- Minimal starter `schema.sql` (adjust as needed to match real data model)

## Run locally
```bash
docker compose up -d --build
docker compose exec db bash -lc "mysql -u root -proot < /var/lib/mysql-files/schema.sql" # or import `schema.sql` manually
```

## Next steps
- Replace legacy PayPal toolkit with modern API if you still need payments.
- Consider replacing the bundled PHPMailer class with composer `phpmailer/phpmailer`.
- Gradually replace POSIX regex (`ereg*`) with PCRE `preg_*` natively and remove the shim.
