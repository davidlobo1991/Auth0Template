# Trenkwalder

### Check Requirements

- execute 'php bin/symfony_requirements'

### Setup Instructions Development

- use PHP Version > 7.0
- execute 'npm update'
- execute 'gulp'

### Setup Instructions Production

- use PHP Version > 7.0
- execute 'npm update'
- execute 'gulp --production'

### Start local test server in dev mode

bin/console server:start

### Start local test server in prod mode

bin/console server:start --env=prod

### Stop local test server

bin/console server:stop

### Update DB

php bin/console doctrine:schema:update --force

### Debug Translation Keys

php bin/console debug:translation xx TrenkwalderBundle

e.g for german

php bin/console debug:translation de TrenkwalderBundle

### Update Translation Keys

php bin/console translation:update xx TrenkwalderBundle --force --output-format=xlf

e.g for german

php bin/console translation:update de TrenkwalderBundle --force --output-format=xlf

### parameters.yml.dist

ask the project owner for all parameters
