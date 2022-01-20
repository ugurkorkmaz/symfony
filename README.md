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

Aslında bu işlemleri aşırı derecede kolaylaştıran bir [Symfony ClI](https://symfony.com/download) isimli bir aracımız var. Link'e tıklayarak kurabilirsiniz.

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

Yorum satırlarımız içinde bir `@Route("/home", name="home")` annotation'ı var. Bu annotation'ın içinde bir `name` parametresi var. Bu parametre `home` olarak isimlendirilmiştir. Bu özelliği kullanarak `URL` oluşturabilirsiniz. Bunu daha sonra anlatacağım. Çok seveceğinize eminim.

Return edilen `$this->render()` fonksiyonu, `templates/home/index.html.twig` dosyasının içine gidip `controller_name` değişkenini oluşturur. Bu yöntemle, `Array`, `JSON` ve `İstediğiniz` tipte değer gönderebilirsiniz. `Twig` template engine bunları işlemek için bize bir sürü araç sağlar.

Basitçe kod yazmadan `Controller`'ımızı inceledik. Şimdi çok kullanmayı çok sevdiğim `Twig` ile yazılmış 
`templates/home/index.html.twig` dosyasını inceleyelim.

```	
{% extends 'base.html.twig' %}

{% block title %}Hello HomeController!{% endblock %}

{% block body %}
<div class="example-wrapper">
    <h1>Hello {{ controller_name }}! ✅</h1>
</div>
{% endblock %}
```	
Yazıya sığması için kodları biraz sadeleştirerek buraya ekledim, şaşırmayın.

`{% extends 'base.html.twig' %}` ile `base.html.twig` dosyasını kullanacağımızı belirtiyoruz. Bu dosya `templates/base.html.twig` konumunda bulunuyor, bu dosya içinde `header`,`footer` ve heryerde kulllanmak istedğimiz her `HTML` kodunu içerir. `{% extends 'base.html.twig' %}` komutu bunları miras almamızı sağlar yada `include` eder, nasıl söylemek isterseniz artık :)

Diğer komutlarda benzer olarak çalışır ama şimdilik bizi ilgilendiren `{{ controller_name }}` kısmını inceleyelim. Aslında inceleme demek biraz fazla kaçar ama kısaca `Controller`'ımızdan gelen `controller_name` değişkenini enjekte eder.

Oluşturulan sayfamızı inceleyelim.
[Bu link'e](http://localhost:8000/home) tıklayın:
![lOCALHOST/HOME](https://i.hizliresim.com/34mczzq.jpg)

Böyle bir mesaj ile karşılaşmız olmanız lazım.

Alt taraftaki bu araç dikkatiniz çekti mi?
Bu `Symfony Profiler` aracı, yazılımcının uykusuz gecelerine neden olan bugları incelemek için oluşturlmuş bir debug aracıdır.
Okumaya biraz ara verip içinde dolaşabilirsiniz.
![Symfony/Debug](https://i.hizliresim.com/aram7hx.jpg)

Ne kadar incelediniz bilmiyorum ama proje geliştirirken çok kullanacağınza yemin edebilirim :)

### Database ve Doctrine ORM

Symfony Framework verileri ve veritabanın `Doctrine ORM` ile yönetir. Verileri ise `Entity` isimli PHP objeleri olarak saklar.

Şu iki cümle o kadar çok şey içeriyor ki hepsini anlatmama imkan yok. Mesela `Doctrine ORM` bize o kadar çok esneklik sağlıyor ki bir satırda istediğimiz veritabanını kullanabilir veya daha sonrada istediğimiz veritabanına sorunsuzca geçiş yapabiliriz.

Ee nasıl yapıcağız diye soruyorsanız, veritabınımızı `.env` dosyasına şu kodu ekleyelim.
```	
DATABASE_URL="sqlite:///%kernel.project_dir%/var/data.db"
```
Database olarak `sqlite` veritabanı kullanacağız. Yaptığımız değikliği inceleyin ve  `.env` dosyanızda aynısını yapabilirsiniz.

Şimdi veritanını oluşturmadan bir tane `Entity` oluşturalım.

```
php bin/console make:entity Home
```
Sonra şu adımları yapalım. Ben buraya birkaç türkçe yorum ekleyeceğim sizin terminalinizde bu yorumlar olmayacak.

```	

 created: src/Entity/Home.php
 created: src/Repository/HomeRepository.php
 
 Entity generated! Now let's add some fields!
 You can always add more fields later manually or by re-running this command.

Bir değer ismi belirlemenizi istiyor. Tablodaki sütün adına denk geliyor.
 New property name (press <return> to stop adding fields):
 > Title

Verinin hangi tipte olacağını belirleyen bir seçim yapmanız isteniyor.
 Field type (enter ? to see all types) [string]:
 > string

 Field length [255]:
 > 255

Verinin `nullable` olup olmadığını belirleyen bir seçim yapmanız isteniyor.
 Can this field be null in the database (nullable) (yes/no) [no]:
 > no

Entity dosyamız bu şekilde oluşturulacak.
 updated: src/Entity/Home.php

Daha fazla değer eklemek istiyorsanız devam edebilirsiniz, şimdilik ihtiyacımız yok. `Enter` tuşuna basarak işlemi bitirin.
 Add another property? Enter the property name (or press <return> to stop adding fields):
 >


 
  Success! 
 
`Migration` özelliği işlevsel bir özelliktir, birazdan anlatacağım.
 Next: When you're ready, create a migration with php bin/console make:migration
 ```

 Şu komutları sırasıyla çalıştırın.

 ```
 php bin/console doctrine:database:create
 php bin/console make:migration
 php bin/console doctrine:migrations:migrate
```

```
[notice] finished in 150.7ms, used 18M memory, 1 migrations executed, 1 sql queries
```
Eğer bu mesajı gördüyseniz, veritabanı oluşturuldu.
Migration ile veritabınızın içinde bir tablo oluşturdu.
Tebrikler, herşey yolunda demektir.
<br />
`src/Entity/Home.php` dosyasını inceleyelim.
```
<?php

namespace App\Entity;

use App\Repository\HomeRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=HomeRepository::class)
 */
class Home
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $Title;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitle(): ?string
    {
        return $this->Title;
    }

    public function setTitle(string $Title): self
    {
        $this->Title = $Title;

        return $this;
    }
}
```
Symfony yada daha doğrusu `Doctrine ORM` tüm herşeyi objeler halinde tutar, bu da biz geliştiricilere büyük esneklik sağlar.

Bu dosyayı verileri veritanımıza eklerken kullanacağız o yüzden tekrardan:
<br />
 `src/Controller/HomeController.php` dosyasına gidelim ve ilk kodumuzu yazalım.
```
<?php

namespace App\Controller;

use App\Entity\Home;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends AbstractController
{
    /**
     * @Route("/home", name="home")
     */
    public function index(ManagerRegistry $manager): Response
    {   /**
         * Home isimli Entity sınıfımızı çağırıyoruz.
         */
        $homeEntity = new Home();
         /**
         * setTitle metodu ile title değerini belirliyoruz.
         */
        $homeEntity->setTitle('My Name is HomeController');

        /**
         * Entity Manager'ımızı çağırıyoruz.
         */
        $em = $manager->getManager();

        /**
         * Verilerimizi persist ediyoruz.
         */
        $em->persist($homeEntity);

        /**
         * Verileri database'e kaydediyoruz.
         */
        $em->flush(); 
        return $this->render('home/index.html.twig', [
            'controller_name' => 'HomeController',
        ]);
    }
}

```	
Yorum satırları ile tüm işemi açıkladım, tekrar etmeye gerek duymuyorum. Tüm bu işlem sonunda veriniz veritanına kaydelir.

`var/data.db` Sqlite dosyası içinde verilerinizi inceleyebilirsiniz.

Şimdi kaydetğimiz verileri görmek için biraz kod yazalım.

```
<?php

namespace App\Controller;

use App\Entity\Home;
use App\Repository\HomeRepository;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends AbstractController
{
    /**
     * @Route("/home", name="home")
     */
    public function index(ManagerRegistry $manager, HomeRepository $homeRepository): Response
    {   /**
         * Home isimli Entity sınıfımızı çağırıyoruz.
         */
        $homeEntity = new Home();
         /**
         * setTitle metodu ile title değerini belirliyoruz.
         */
        $homeEntity->setTitle('My Name is HomeController');

        /**
         * Entity Manager'ımızı çağırıyoruz.
         */
        $em = $manager->getManager();

        /**
         * Verilerimizi persist ediyoruz.
         */
        $em->persist($homeEntity);

        /**
         * Verileri database'e kaydediyoruz.
         */
        $em->flush(); 

        /**
         * HomeRepository sınıfımızı Symfony'nin
         * Auto-Wiring'i ile 'index()' içinde çağırıyoruz.
         * Buna dikkat edin!
         * 
         * Repository sınıfı Doctrine ile iletşime geçen basit
         * bir sınıftır. Ek ayarlar yapmamıza olanak sağlar.
         * 
         * $homeRepository->find(1) ile veritabanından
         * id 1 bir olan veriyi çekiyoruz.
         */
        $homeRepository = $homeRepository->find(1);
        return $this->render('home/index.html.twig', [
            /**
             * 'controller_name' değişkenine Title 
             *  değerini atıyoruz. 
             */
            'controller_name' => $homeRepository->getTitle(),
        ]);
    }
}
```
Başka bir değişiklik yapmadan [Bu link'e](http://localhost:8000/home) tıklayarak, veritabanından gelen verinizi görebilirsiniz.
