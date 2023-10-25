# Neo4j PHP Applicatio

## Fluxo de desenvolvimento:

 - 1°: para identificar possiveis erros de parametrização, retorno e etc.
 
 ```
 /vendor/bin/psalm  
 ```

 - 2°:  para identificar possiveis erros referentes as padronizações das psrs do php.
 ```
 vendor/bin/php-cs-fixer fix src/ --dry-run --diff
 ```
