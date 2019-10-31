# Bank Account
[![CircleCI](https://circleci.com/gh/zawiszaty/bank-account.svg?style=svg)](https://circleci.com/gh/zawiszaty/bank-account)
### Modular Monolith example.
## How to run?
1. You must have installed docker, docker-compose and make locally.
1. `make start`
1. API of your Laravel microservice is available on http://localhost:9898/api/account
1. Login into monolith container `make monolith`
1. Run `bin/console app:account` and that's it :P 
## How to change API implementation?
Default implementation is laravel microservice but another available is 
in memory eventStore implementation. 
1. Open  `monolith/config/services.yaml`
1. Change:
    ```yaml
       App\UI\CLI\AccountCommand:
           class: App\UI\CLI\AccountCommand
           arguments:
               - '@App\Module\Account\API\LaravelAccountAPI'
           tags:
               - { name: 'console' } 
   ```
   To:
   ```yaml
    App\UI\CLI\AccountCommand:
        class: App\UI\CLI\AccountCommand
        arguments:
            - '@App\Module\Account\API\ImplAccountAPI'
        tags:
            - { name: 'console' }
   ```
## How to create you own?
1. Create your implementation adapter in API folder, implement interface Account API and that's it. :P