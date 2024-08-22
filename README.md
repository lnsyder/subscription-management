# Subscription Management

Başlamadan Önce:

Projeyi yerel bilgisayarınızda çalıştırmak için aşağıdaki adımları takip edebilirsiniz:

### 1) Projeyi bilgisayarınıza klonlayın:
```
git clone https://github.com/lnsyder/subscription-management.git
cd subscription-management
```
### 2) Docker konteynerlarını ayağa kaldırın:
```
docker-compose up -d --build
```
### 3) Gerekli bağımlılıkları yükleyin:
```
docker exec -it subscription-management-app bash -c "composer install"
```
### 4) Veritabanı bilgilerini girin:
.env dosyasına aşağıdaki parametreyi ekleyin:
```
DB_CONNECTION=pgsql
DB_HOST=database
DB_PORT=5432
DB_DATABASE=postgres
DB_USERNAME=user
DB_PASSWORD=password
```
### 5) Veritabanını oluşturun:
```
docker exec -it subscription-management-app bash -c "php artisan migrate"
```
### Uygulama artık http://localhost/ adresinden erişilebilir olacaktır.

### 6) Projenin kullanımı:
Ana dizinde paylaşılan Postman Collection'ını Postman'e import edin.

#### Auth/Register (POST):
Kullanıcı oluşturmak için bu bu requesti kullanabilirsiniz.

#### Auth/Login (POST):
Giriş yapmak için bu requesti kullanabilirsiniz.

#### Subscription/Create (POST):
Abonelik eklemek için bu requesti kullanabilirsiniz.

#### Subscription/Update (PUT):
Aboneliği güncellemek için bu requesti kullanabilirsiniz.

#### Subscription/Delete (DELETE):
Aboneliği silmek için bu requesti kullanabilirsiniz.

#### Transaction/Create (POST):
Ödeme eklemek için bu requesti kullanabilirsiniz.

#### Transaction/Create (POST):
Ödeme eklemek için bu requesti kullanabilirsiniz.

#### User/Show (GET):
Kullanıcı ve bilgilerini listelemek için bu requesti kullanabilirsiniz.

### 7) Command/Job kullanımı:

.env dosyasına aşağıdaki parametreyi ekleyin:
```
QUEUE_CONNECTION=database
```
Joblar kuyruk yapısıyla çalışmaktadır.
Abonelik yenileme zamanı gelmiş kişileri job kuyruğuna almak için aşağıdaki komutu tetikleyin:
```
docker exec -it subscription-management-app bash -c "php artisan subscriptions:renew"
```
Sonrasında aşağıdaki komutu tetikleyerek kuyruğa alınan jobları işleme alabilirsiniz:
```
docker exec -it subscription-management-app bash -c "php artisan queue:work"
```

### Kullanılan Teknolojiler:

PHP 8.3.10

Laravel Framework 11.21.0

PostgreSQL 16
