<!-- kebutuhan -->
1. PHP : v7.4
link : https://sourceforge.net/projects/xampp/files/XAMPP%20Windows/7.4.33/xampp-windows-x64-7.4.33-0-VC15-installer.exe/download

2. Composer v2.0^
link : https://getcomposer.org/

3. Node 14.0
link : https://nodejs.org/en/blog/release/v14.17.3

<!-- install composer -->
LINK : https://getcomposer.org/download/

<!-- documentasi codingan -->
LINK : https://laravel.com/docs/5.4

<!-- composer version v1.0.0 -->
1. Buka command line
2. Ketikan `composer self-update --1`


<!-- mulai project baru -->
1. buat file dengan nama .env pada root project
2. salin code pada .env.example ke .env 
3. pada root project jalankan command line kemudian ketikan perinatah
    1. composer install <!-- jika tidak ada folder vendor di root project -->
    2. php artisan key:generate 

<!-- pengeturan database -->
1. buat database baru pada phpmyadmin untuk mysql
2. pada file .env edit pada bagian berikut
    DB_CONNECTION=mysql <!-- keneksi ke database, contoh : jika menggunakan msqyl -->
    DB_HOST=localhost <!-- host database -->
    DB_PORT=3306 <!-- port database -->
    DB_DATABASE=mrapat_lte <!-- nama database -->
    DB_USERNAME=root <!-- user database -->
    DB_PASSWORD= <!-- password database -->
3.  pada root project jalankan command line kemudian ketikan perinatah
    1. php artisan migrate
    2. php artisan db:seed

<!-- jalankan project -->
1. pada root project jalankan command line kemudian ketikan perinatah
    1. php artisan serve
2. pada brouser buka alamat 
    URL : http://localhost:8000

atau

1. buat folder baru pada C:/xampp/htdocs/mrapat_lite
2. copy project ini kedalam C:/xampp/htdocs/mrapat_lite
3. pada broser buka 
    URL : http://localhost/mrapat_lite/public


<!-- login sistem -->
1. akun default admin
    username : admin@admin.com
    password : 123456
2. akun default sekretaris bidang
    username : sekretaris@bidang.com
    password : 123456
3. akun pengawai
    username : [nip]
    password : pengawai
