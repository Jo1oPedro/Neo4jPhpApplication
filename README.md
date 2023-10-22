Fluxo de desenvolvimento:

1°: ./vendor/bin/psalm para identificar possiveis erros de parametrização, retorno e etc.
2°: vendor/bin/php-cs-fixer fix src/ --dry-run --diff para identificar possiveis erros referentes as padronizações das psrs do php.
