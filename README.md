```bash
composer install
.env.local - DATABASE_URL=sqlite:///%kernel.project_dir%/var/data.db
./bin/console d:mi:mi
./bin/console d:f:l
symfony server:start
```

```curl
GET http://127.0.0.1:8000/showroom/{brand} - case sentive
```

```curl
POST http://127.0.0.1:8000/trade-in
body:
brand:BMW
model:1
class:C
price:$10000
showroomId:38
clientId:1
```
