# Kavégép Automata

Ez egy Laravel Vue Applikáció, amely alkalmas több gép üzemeltetésére, karbantartására. Minden gépnek külön tárolói lehetnek, amikből különböző termékeket  tudd előállítani. A tárolók artisan paranccsal egyesével tölthetők fel, illletve az adott gép tárolóinak állapotát tudjuk lekérni (külön paranccsal). Az utolsó szervízelés óta felhasznált alapanyagok és eladott termékek listáját szintén artisan paranccsal tudjuk megkapni. Rendelni webes felületen és artisan paranccsal is tudunk, amennyiben a gép nincs szerviz üzemmódban.

## Demo

[Tovább a demo oldalra](http://coffee-machine.lara-dev.com)


## Installálás

```bash
git clone git@github.com:mrTonyKvcs/coffee-machine.git
```
```bash
cd coffe-machine
```
```bash
composer install
```
Hozd létre a .env fájlt! 

Állítsd be az adatbázist!
```bash
php artisan migrate
```
```bash
php artisan db:seed
```

## Artisan Parancsok
Kávégép szervíz üzemmódba helyezése (be/ki)
```bash
php artisan coffee:service-toggle 
```

Kávégép tárolóinak állapotának ellenőrzése
```bash
php artisan coffee:inventory 
```

Kávégép tárolóinak feltöltése
```bash
php artisan coffee:add-ingredient  
```

Az utolsó szervízelés óta felhasznált alapanyagok és eladott termékek listája
```bash
php artisan coffee:selling-informations 
```

Termék vásárlása
```bash
php artisan coffee:order
```

## API
Machine id-ja alapján megkapjuk az adott gépet és figyelembe véve a tárolók állapotát az elkészíthető termékeket
```bash
GET /api/machines/{machine_id}
```
Vásárlás esetén levonja az adott gép tárolóiból kiválasztott termékhez szükséges alapanyagot
```bash
POST /api/order-product/{machine_id}/{product_id}'
```

## License
mrTonyKvcs (Github Név)
