[![codecov](https://codecov.io/gh/BASAKSemih/ecf-studi/branch/develop/graph/badge.svg?token=CZO8CCBHJ4)](https://codecov.io/gh/BASAKSemih/ecf-studi)
# ECF BASAK Semih

# Lien du site : http://hypnoshotel.basaksemih.com/
# Lien pour le code coverage : codecoverage.hypnoshotel.basaksemih.com

## Requirement 

- PHP 8.0 or higher
- Composer 2
- Maria DB & Mysql
- NPM Webpack-encore
- Symfony CLI optionnal 

## Installation & Configuration

```bash
  git clone git@github.com:BASAKSemih/ecf-studi-BASAK-Semih.git
  cd ecf-studi-BASAK-Semih
  
  composer i & npm i 
  # ! Configure the .env link your database
  symfony console doctrine:database:create or php bin/console doctrine:database:create
  make database (using composer script and Makefile for updating schema, fixtures
  
  # Running Application Development server
  symfony serve in a bash,
  # New Terminal
  npm run watch (watching SCSS,CSS,HTML,JAVASCRIPT for build asset to have a very pleasant performance)
```
