s# TemplateSystem

**TemplateSystem** adalah template engine sederhana, mudah di gunakan dan cepat.

mudah karena tidak perlu mempelajari syntax syntax baru.
karena semua fungsional menggunakan fungsi fungsi PHP asli.

> karena sangat sederhana, _*TemplateSystem*_ juga bisa di anggap bukan sebuah template engine. anggap saja ini adalah sebuah library yang memudahkan dalam pembuatan tampilan / partial template.

# #Install

install via composer.

`composer require dhenfie/template-system --no-dev`

> TemplateSystem membutuhkan PHP versi 8 atau lebih baru.

pertama saya harus mengimport autoloader composer agar bekerja.
dan buat sebuah Object dari class `dhenfie\TemplateSystem\TemplateSystem`

```php
require '../vendor/autoloader.php';  // sesuaikan dengan path autoloader anda

$engine = new Dhenfie\TemplateSystem\TemplateSystem();
$engine->setViewPath('example'); // set root viewpath
echo $engine->render('main.php'); // render template
```

perhatikan method `setViewPath()`, method ini berfungsi untuk mengatur directory dimana file template berada.

dalam contoh di atas method `render()` yang berfungsi untuk merender sebuah template dimana file 'main.php' berada di dalam directory 'example'

## #Me-render template
merender template bisa menggunakan method `TemplateSystem::render()`.

sebagai contoh merender template main.php
```php
$engine = new TemplateSystem();
$engine->setViewPath('example');
echo $engine->render('main.php');
```
kita juga dapat mengirim data ke template dengan menambahkan argument ke parameter kedua berupa pasangan array key value.

key dari array tersebut akan menjadi nama variabel.

```php
echo $engine->render('main.php', ['message' => 'hello world']);
``` 
**main.php**
```php
<?php 
 // 'hello world'
echo $message; 
?> 
```
data yang di kirimkan ke template juga tersedia di template master.

## #Menggunakan Block Section

block section adalah fitur dimana kita dapat membuat sebuah tampilan yang di bungkus di dalam sebuah block.

**block-section.php**

```php
 <?php // create section 'message'
  section('message');?>
  <h1> Hello World </h1>
<?php endSection();?>

<?= renderSection('message'); ?>
```

**view.php**

```php
// render template `block-section.php`
echo $engine->render('block-section.php');
```

perhatikan pada file view.php

dimana saya merender template 'block-section.php' dan outputnya adalah **hello world**

untuk membuat block section bisa menggunakan fungsi `section()` dimana argument pertama adalah nama sectionnya.

dan untuk menampilkan block section bisa menggunakan fungsi `renderSection()' dengan argument pertamanya adalah nama sectionnya yang ingin di tampilkan.

misalnya saya ingin membuat block section 'name' yang berisi nama saya dan menampilkannya.

```php
 <?php section('name');?>
   Fajar Susilo
<?php endSection(); ?>
<?= renderSection('name');?>
```

yang perlu di perhatikan adalah setiap membuat block section harus di akhiri dengan fungsi `endSection()`

> Block Section akan sangat memudahkan jika di implementasikan di konsep master template / template inherit.

## Template Inheritance

pada situasi tertentu kita ingin membuat banyak halaman / template namun setiap halaman mempunyai struktur tampilan yang sama tapi dengan konten yang berbeda setiap halamanya.

kita bisa menggunakan inheritance untuk skenario itu.

hal pertama yang harus di lakukan adalah membuat template master yang menjadi template induk yang mengatur seluruh struktur template.
dan juga menggunakan block section untuk mengatur kontennya.

**master.php**

```php
 <html>
 <head>
  <title> <?= renderSection('page_title');?> </title>
  </head>
  <body>
   <?= renderSection('body'); ?>
  </body>
  </html>
```

pada contoh kode di atas, `renderSection('page_title')` akan merender section 'page_title'. begitu juga dengan `renderSection('body')`.

dan nantinya konten dari section tersebut dapat kita di set di child menggunakan fungsi `section()`.

untuk mewarisi struktur template dan juga agar konsep di atas bisa berjalan kita perlu menggunakan fungsi `extend()` di child template.

fungsi `extend()` mempunyai satu parameter berupa path template masternya (path relative terhadapa viewPath yang di atur menggunakan method `setViewPath()`.

**child.php**

```php
<?php extend('master.php'); ?>
<?php section('page_title'); ?>
  this is section title
<?php endSection(); ?>
<?php section('body'); ?>
 <p> this section body </p>
<?php endSection(); ?>
```

## #Menyisipan script
Sangat umum kita membutuhkan javascript untuk membuat lebih interaktif.

_TemplateSystem_ menyediakan cara mudah untuk menyisipkan tag script di dalam template.

sebagai contoh kita ingin menyisipkan script foo.js dan juga bar.js di mana script tersebut membutuhkan ketergantungan dengan library jquery.js

tetapi foo.js tidak bergantung dengan dengan bar.js begitu juga sebaliknya.
jadi foo.js bar.js tidak perlu di sisipkan secara bersamaan. foo.js hanya di butuhkan di halaman tertentu begitu juga dengan bar.js.

jadi dari pada menyisipkan script jquery.js di setiap template.
lebih baik letakan jquery.js di template master menggunakan fungsi `stack()`.

dan gunakan fungsi `pushStack()` di child template untuk menambahkan script foo.js atau script bar.js di master template.

**master.php**
```php
<?php stack(); ?>
<script src="jquery.js"></script>
<?php endStack(); ?>
```

sekarang di child template.

**child.php**
```php
<?php extend('master.php');?>
<?php pushStack(); ?>
 <script src="foo.js"></script>
<?php endPushStack(); ?>
```
dengan menggunakan fungsi `stack()` dan `pushStack()` maka secara otomatis script di tambahkan ke atas atau master dan sesuai dengan urutannya di mana script yang di tambahkan akan berada di bawah script jquery.

```html
<script src="jquery.js"></script>
<script src="foo.js"></script>
```




