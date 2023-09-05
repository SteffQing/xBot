# xBot
Automated Trading.

## Trading Algorithm
The bot uses a configurable "ratio" value to calculate how much the price of the "Traded Pair" should change in relation to the change in the price of the "Base Pair", such that if "Base Pair" have a 10% change in price with a set "ratio" 0.1 (1/10), the bot will trade "Trading Pair" at 1% change in it's price for either a BUY or a SELL (being random).

The trade size is random value with a configurable "Variation Percentage Range" percentage of the configurable "Order Size".

> Only SPOT (limit) trading is currently supported.

## Production Deployment
- Clone the project to your server.
#### Setup Database
Make sure you have MySQL installed.
- Run `CREATE SCHEMA xbot;` to create the database.
#### Install dependencies
- `composer install` 
- `yarn install` (or `npm install`).
#### Setup Environment
- `cp .env.example .env`.
- Update `.env` with production details, e.g:
    ```js
    APP_ENV=production
    APP_DEBUG=false
    DB_USERNAME=your_database_username
    DB_PASSWORD=your_database_password
    ```
- Run `php artisan key:generate`.
- Run `php artisan migrate --seed`

#### Access the Application
Your application should now be deployed and running in the production environment.
Go to your configured URL and log in.
> Default Admin login details:
> - Username: super@xbot.com
> - Password: password

#### Set up Schedule Cron Job
Add a single cron entry on your server to run `php artisan schedule:run` every minute. e.g:
> cd /path-to-your-project && php artisan schedule:run >> /dev/null 2>&1


## Credit
Developed by <a href="http://emmanuel.mantenar.com" target="_blank" rel="noopener noreferrer">Emmanuel Adesina</a>
