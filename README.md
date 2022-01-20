# Ülkemiz sınırları içerisinde Değer Görmeyen Framework
## Symfony

Symfony paketleri, PHP uygulamaları için oluşturlmuş açık kaynak kütüphanelerdir. Yüzbinlerce projede test edilmiş ve milyarlarca kez kullanılmıştır. Aşağadaki birçok projenin temelinde bu paketler bulunur.

### Framework
* [Laravel](https://symfony.com/projects/laravel)
* [Yii](https://symfony.com/projects/yii)
* [Symfony](https://symfony.com/projects/symfony)
* [Lumen](https://symfony.com/projects/lumen)
* [Zend Expressive](https://symfony.com/projects/zendexpressive)

### CMS
* [Drupal](https://symfony.com/projects/drupal)
* [Joomla](https://symfony.com/projects/joomla)
* [eZ Platform](https://symfony.com/projects/ezplatform)

### E-Commerce
* [Magento](https://symfony.com/projects/magento)
* [OpenCart](https://symfony.com/projects/opencart)
* [Sylius](https://symfony.com/projects/sylius)

Üşendiğimden bir çoğunu ekleyemiyorum, [Symfony kullanan projelerin](https://symfony.com/projects)  hepsine bakmak için linke tıklayabilirsiniz.

## Paketlerini yada bileşenlerini bir kenara bırakalım da frameworkün kendisini inceleyelim isterseniz.

Kod yazarak öğrenen bir kesim insan var onları da düşünerek basit bir symfony projesi oluşturalım.

```
composer create-project symfony/website-skeleton symfony-project
```
Bu komut bir symfony projesi hızlıca oluşturlur.

```
cd symfony-project
composer install
```
Proje dizinimize girelim ve composer ile paketlerimizi indirelim.
```
    Do you want to include Docker configuration from recipes?
    [y] Yes
    [n] No
    [p] Yes permanently, never ask again for this project
    [x] No permanently, never ask again for this project
    (defaults to y): no
```
Veritabanı için Docker kullanmak isterseniz 'yes' diyebilirsiniz.

Kurulum tamamlandıktan sonra, projemizi çalıştırabiliriz.
```
php -S localhost:8000 -t public
```
Bu komut public/ dizini altındaki `index.php` dosyasını çalıştırır.

Aslında bu işlemleri aşırı derecede kolaylaştıran bir [Symfony ClI](https://symfony.com/projects) isimli bir aracımız var. Link'e tıklayarak kurabilirsiniz.

### Oluşturulan klasörleri ve dosyaları inceleyelim.

Markdown İmage 

![Symfony Dizin](https://i.hizliresim.com/r6mizhe.jpg)

* `bin/`: CLI & Bash komutlarını içerir.
* `config/`: Symfony projesi için ayarlarını içerir.
* `migrations/`: Veritabanı migrasyonlarını içerir.
* `public/`: index.php dosyası ve assetsler burada durur.
* `src/`: Kaynak kodlarımızı burada yazarız.
* `templates/`: Twig ile çalışan şablonlarımız burada bulunur.
* `tests/`: Symfony projesi için testleri içerir.
* `translations/`: İhtiyac olursa çeviri dosyalrı burada bulunur..
* `var/`: Cache ve loglarımız burada bulunur.
* `vendor/`: Composer tarafından paketler buraya indirilir.

* `.env`: Projemizin ayarlarını içerir.
* `composer.json`: Paket ve PSR-4 ayarları bu dosya içindedir.

Diğer dosyaları şuanlık incelemize gerek yok.

Bir projede kodlamaya başlamak için diğer frameworklerde olduğu gibi bir controller oluşturmalıyız. Symfony bu tür angarya işlemler için oluşturduğu, benim de çok çok sevdiğim ve projemizde kurulu olarak gelen `maker bundle` paketi ile kolayca bir controller oluşturabiliriz.

```
php bin/console make:controller Home
```
Bu komut `src/Controller/` dizinine `HomeController.php` isimli bir controller ve `templates/home/` dizinine `home.html.twig` isimli bir twig şablonu oluşturur.

Önce Controller'ımızı inceleyelim.

```	
<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends AbstractController
{
    /**
     * @Route("/home", name="home")
     */
    public function index(): Response
    {
        return $this->render('home/index.html.twig', [
            'controller_name' => 'HomeController',
        ]);
    }
}
```
Birşey belki dikkatiniz çekmiştir.Annatationlar! Symfony framework ile rota oluşturmak aslında bu kadar basit bir işlem.
Gidip başka bir dosyada rota ayarlamanıza hiç gerek yok. Ama ben bu angarya işlemi isterim diyorsanız `YAML`, `PHP`veya `XML` formatında rotalarınız oluşturabilirsiniz.
Bunları daha sonra `config/` klasörünü incelerken anlatacağım.

Annatation'ınızın içinde bir `Route` annotation'ı var. Bu annotation'ın içinde bir `name` parametresi var. Bu parametre `home` olarak tanımlanmıştır. Bu parametreyi kullanarak bir URL'i oluşturabiliriz.