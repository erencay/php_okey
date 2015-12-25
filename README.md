>    Bir süre önce araştırma amaçlı olarak yazdığım "PHP ile online RPG" projesinin daha anlamlı olması için, kaynak kodlarını geliştirerek, "PHP ile online okey" olacak şekilde yeniden derledim. Bir önceki oyun sadece testler yapmak amacıyla yazıldığı için, "network" sınıflarını yeniden kullanılabilecek şekilde kodlamamıştım. Bu yüzden, bu sınıflarda iyileştirmeler yaparak ve daha soyut bir hâle getirerek, herhangi bir online oyun yazılabilecek şekilde, "MMOCore" adı altında bir kütüphaneye çevirdim ve okey oynunda bu kütüphaneyi kullandım.

>    Oyunun "client" tarafını ise, hem daha hızlı geliştirmek mümkün olduğu hem de pek çok PHP programcısı AS3 yerine JavaScript'i tercih edeceği için saf JavaScript ile yazdım. AS3 sadece soket iletişimini sağlamak için kullanıldı ve bir kaç satırlık kodlardan oluşan tek bir dosya halinde hazırlandı. Ancak AS3 içindeki "callback" metodları da tarayıcıdaki Javascript kodlarını çağıracak şekilde düzenlendiği için, Flash ile ilgili hiç bir düzenlemenin yapılmasına gerek yok. İkinci tercih olabilecek WebSocket iletişimini ise uyumluluk açısından tercih etmedim. 3. parti kütüphaneler arasından minumum gerekenler seçildi. Bir önceki oyun MooTools ile yazılmıştı ancak düzenlenmesi çok sorunlu olabiliyordu. Bu yüzden MooTools yerine, JQuery ile CoffeScript'i "client" tarafının asıl işlerini yapmak için, Less'i daha düzenli bir CSS dosyası oluşturmak için ve SWFObject'i projedeki tek flash dosyasının sayfaya yerleştirmek için kullandım. Bunların dışında, arayüz sadece CSS ile düzenlendi ve hiç bir imaj dosyası kullanılmadı. Bu düzenlemelerde daha çok -hatta tamamen- Opera 11.64 ile çalışacak şekilde test edildi. Diğer Opera sürümleri ve tarayıcılar ile nasıl bir görüntü elde edeceğinizden emin değilim.

>    Oyunu bitiş algoritmasına kadar yazmış olsam da, tam anlamıyla bitmiş değil. Yazılan sınıfların bir kısmı uygulamada henüz yerini almadı ve yazılmış olsalar da, bu sınıfları uygulamaya entegre etmeyeceğim. Bu yüzden pek çok "bug" ile karşılaşabilirsiniz. Özellikle sunucu kodları için "unit test" sınıfları olmadan, üzerinde çalışmak isteyen kişilere çok bir anlam ifade etmeyeceğini düşündüğüm için, daha fazla ilerlemeden bırakmak istedim. "Unit testing" ile geliştirme yapmamamın nedeni, daha önce Java ve AS3 ile yazdığım oyunu baz alarak kodlama yapmış olmamdı fakat sadece bu kodlardan yola çıkarak kodlanan bir proje, çalışır ve kullanılabilir olsa da, kaynak kodu geliştirmek isteyen programcılara yardımcı olmayacaktı. Bu sebepten, ileriki zamanlarda, oyunun hem "client" hem de sunucu taraflarını, testleri ile beraber geliştirmeyi daha uygun gördüm. Fakat PHP, TDD ile geliştirme yapmak için çok da uygun bir dil değil. Bu yüzden oyunun tamamlanmış örneğini Ruby ile yazmak bana daha mâkul geliyor ve Ruby ile özdeşleşmiş olarak sunulan diğer imkânlar bunu daha da cazip kılıyor. Hangi şekilde devam ederse etsin, mevcut kodlar üzerinde daha fazla çalışmayacağım için bunları paylaşıyorum.

>    30-03-2013, 23:10:43

>    http://www.r10.net/php/1018662-php-ile-online-okey.html#post1067048968

[![alt tag](http://imageshack.us/a/img163/4636/37706702.th.png)](http://img163.imageshack.us/img163/4636/37706702.png)

[![alt tag](http://imageshack.us/a/img14/2204/90726492.th.png)](http://img14.imageshack.us/img14/2204/90726492.png)

[![alt tag](http://imageshack.us/a/img11/525/38060477.th.png)](http://img11.imageshack.us/img11/525/38060477.png)

[![alt tag](http://imageshack.us/a/img194/8362/23122117.th.png)](http://img194.imageshack.us/img194/8362/23122117.png)

[![alt tag](http://imageshack.us/a/img20/9887/14780157.th.png)](http://img20.imageshack.us/img20/9887/14780157.png)
