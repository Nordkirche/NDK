# NDK - Das NAPI Development Kit

Das NDK unterstützt bei der Entwicklung von PHP-Clients, um die Datenbank der Evangelisch-Lutherischen Kirche in 
Norddeutschland (Nordkirche) anzubinden. Dazu greift es auf die Nordkirche API (kurz "NAPI") zu, um z.B. Adress- und 
Veranstaltungsdaten zu beziehen.

Welchen Daten über die NAPI ausgelesen werden können, findet man in der 
[Dokumentation zur NAPI](https://nordkirche.gitlab.nordkirche.de/NAPI-blueprint/). Die selben Filter und Objekteigenschaften,
finden sich im NDK wieder. Daher kann diese Dokumentation zusammen mit IntelliSense/Autocomplete einer IDE oder eines
passenden Editors benutzt werden, um das NDK und seine Objekte einzusetzen.

Das NDK ist nicht Vorausetzung, um mit der NAPI zu kommunizieren. Es stellt nur Hilfsmittel zur Verfügung, um eigene
Anwendungen zu erstellen.

Die verwendeten Namespaces in diesem Projekt entsprechen dem [PSR-4-Standard](http://www.php-fig.org/psr/psr-4/). 
Deshalb wird in dieser Dokumentation nicht direkt auf Dateien, sondern auf Namespaces und Klassenamen verwiesen.

## Installation

Es wird mindestens PHP 7.0 vorausgesetzt.

Die neuste Version installieren:

```bash
$ composer require nordkirche/ndk
```

## Setup

```php
<?php
$configuration = new \Nordkirche\Ndk\Configuration(
    getenv('NAPI_ID'),
    getenv('NAPI_ACCESSTOKEN')
);
$configuration->setNapiHost('www.nordkirche.de')->setNapiPath('api/');
$api = new \Nordkirche\Ndk\Api($configuration);
```

Das NDK stützt sich auf ein Konfigurationsobjekt, welches minimal mit Zugangsdaten in Form einer ID und eines Accesstoken,
sowie dem offiziellen NAPI-Endpunkt initialisiert werden muss.

Damit lässt sich die API des NDK initalisieren, um weitere Objekte im Rahmen der Konfiguration zu erhalten.

## Daten Abfragen

Daten lassen sich über Repository-Klassen abfragen. Alle verfügbaren Klassen befinden sich unter 
`\Nordkirche\Ndk\Domain\Repository`.

Filter und Parameter für Abfragen lassen sich über Query-Klassen definieren. Alle Query-Klassen befinden sich unter 
`\Nordkirche\Ndk\Domain\Query`.

Alle Repositories lassen sich mit den Queries `\Nordkirche\Ndk\Domain\Query\PageQuery` oder 
`\Nordkirche\Ndk\Domain\Query\SimpleQuery` anfragen. Einige, aber nicht alle, Repositories haben spezifische 
Query-Klassen, um besondere Filter anzuwenden. Diese folgenden dem Namenschema

    \Nordkirche\Ndk\Domain\Repository\*Repository -> \Nordkirche\Ndk\Domain\Query\*Query 
    
und sind immer von der Klasse `\Nordkirche\Ndk\Domain\Query\PageQuery` abgeleitet.

Die Verfügbaren Repositories und Filter-Optionen in Queries sind equivalent zu den Endpunkten und Filter-Optionen in der
[Dokumentation der NAPI](https://nordkirche.gitlab.nordkirche.de/NAPI-blueprint/).

### Beispiel-Abfrage

```php
<?php
$api = new \Nordkirche\Ndk\Api($configuration);
$repository = $api->factory(\Nordkirche\Ndk\Domain\Repository\InstitutionRepository::class);
$result = $repository->get(new \Nordkirche\Ndk\Domain\Query\InstitutionQuery());
foreach ($result as $institution) {
    echo $institution->getLabel() . ' (' . $institution->getName() . ')' . PHP_EOL;
}
```

Dieses Beispiel besteht aus zwei Teilen. Zum einen der Initialisierung der API und dem erstellen eine Repository-Objektes
mit dem Methode `factory()`, zum anderen dem Abfragen der Daten mit Hilfe eines Query-Objektes.

```php
<?php
$api = new \Nordkirche\Ndk\Api($configuration);
$repository = $api->factory(\Nordkirche\Ndk\Domain\Repository\InstitutionRepository::class);
```

Das NDK arbeitetet mit Repositories, welche die verschiedenen Endpunkte der NAPI repräsentieren. In diesem Beispiel
benutzten wir das `InstitutionRepository`, um Institutionen abfragen zu können. Die Methode `factory()` der API 
instanziiert unser Repository mit der vorher definierten Konfiguration.

```php
<?php
$result = $repository->get(new \Nordkirche\Ndk\Domain\Query\InstitutionQuery());
foreach ($result as $institution) {
    echo $institution->getLabel() . ' (' . $institution->getName() . ')' . PHP_EOL;
}
```

Mit der Methode `get()` und einem Query-Objekt fragen wir eine Liste der Institutionen ab. Das NDK verpackt diese in ein 
Objekt der Klasse `\Nordkirche\Ndk\Service\Result`, welches neben den Ressourcen-Objekten in Form von 
`\Nordkirche\Ndk\Domain\Model\Institution\Instituion` Objekten zusätzliche Meta-Daten zu einer Anfrage enthält.

Die NAPI liefert Ergebnisse paginiert. Deshalb erhalten wir mit dieser Anfrage nur die erste Seite.

Meta-Daten sind z.B. die Anzahl aller gefundenen Objekte, wieviel Objekte auf der aktuellen Seite sind, 
evtl. zugehörige Facetten zur Suchanfrage, um weitere Filter anwenden zu können etc.

Dieses Beispiel kann unter `examples/2_simple_request.php` direkt ausgeführt werden.

### Queries

Welche Seite man erhält, ob nach bestimmten Daten gesucht/gefiltert werden soll etc., wird über ein Query-Objekt 
bestimmt. Im vorherigen Beispiel über die Klasse `\Nordkirche\Ndk\Domain\Query\InstitutionQuery`. 

Da die meisten Anfragen paginiert sind, bildet die Klasse `\Nordkirche\Ndk\Domain\Query\PageQuery` oft die Elternklasse
für `*Query` Klassen. Diese lässt sich auch für alle Anfrage nutzen, vermisst dann allerdings die speziellen
Filtermöglichkeiten z.B. nach Postleitzahl.

```php
<?php
$query = new \Nordkirche\Ndk\Domain\Query\InstitutionQuery();
$query->setPageSize(30)->setPageNumber(2)->setZipCodes([24103]);
$result = $repository->get($query);
```

Objekte wie das `InstitutionQuery` bieten verschiedene Optionen, um eine Anfrage zu modifizieren. Neben den allgemeinen
Optionen die gewünschte Seite `setPageNumber()` und die Einträge pro Seite `setPageSize()` zu definieren,
können wir bei Institutionen und Personen z.B. nach Postleitzahl filtern.

Hier empfiehlt es sich, einmal alle Setter einer `*Query` Klasse anzusehen. Auch die 
[Dokumentation der NAPI](https://nordkirche.gitlab.nordkirche.de/NAPI-blueprint/) bietet hier Aufschluss über die 
möglichen Filter.

## Resourcen-Objekte

Im NDK unterscheiden wir zwischen zwei Arten von Models welche auf zwei abstrakten Klassen aufbauen:

    \Nordkirche\Ndk\Domain\Model\AbstractModel
    \Nordkirche\Ndk\Domain\Model\AbstractResourceObject

Das `AbstractResourceObject` ist eine erweiterung des generischen `AbstractModels` und zeichent ein Objekt als Resource 
der NAPI aus. Diese Objekte haben eine ID, einen Typ und Relationen zu anderen Resourcen. Sie werden über Repositories bezogen.

Alle `AbstractModels` sind fast auschließlich Unterobjekte einer Resource und gliedern die teilweise komplexen Daten
der Resourcen-Objekte.

### Includes

Die NAPI selbst basiert auf der [JSON API 1.0 Spezifikation](http://jsonapi.org/) und arbeitet deshalb mit der Option,
Relationen zu anderen Resourcen nicht unmittelbar zurück zu geben, sondern nur zu referenzieren.

Dies führt dazu, dass verwandte Resourcen-Objekte nicht automatisch inkludiert sind, sondern vom NDK bei Bedarf
nachgeladen werden. Wir erklären dieses Verhalten einmal Anhand der Institutionen:

Instituionen haben Relationen zu anderen Ressourcen-Objekten, z.B. zu Ihrer Adresse oder ihrem Typ. 
Ein Aufruf der Methode `getAddress()` führt dazu, dass eine weitere Anfrage an die NAPI gestellt wird, 
um die Adressdaten der Institution zu erhalten.

Möchte man auf diese Weise eine Adressliste ausgeben, wird für jeden Eintrag in der Adressliste eine weitere Anfrage
gegen die NAPI gestellt.

Ist bekannt, dass man zu allen Institutionen die Adresse benötigt, lässt sich die Relation in die Antwort der NAPI 
inkludieren und man verhindert unnötige Anfragen. Dazu wird dem Query-Objekt eine Liste mit Relationen mitgegeben:

```php
<?php
use Nordkirche\Ndk\Domain\Model\Institution\Institution;

$query->setInclude([Institution::RELATION_ADDRESS, Institution::RELATION_INSTITUTION_TYPE]);
```

Eine Liste mit allen möglichen Relationen gibt es nicht, da diese spezifisch für das Resourcen-Objekt sind.

Alle Resourcen-Klassen mit Relationen enthalten Konstanten, beginnend mit `RELATION_`, welche mögliche Relationen 
ausweisen und mit denen ein Include-Array gebaut werden kann. 

Aus dem Namen des Repositories lässt sich immer auf die zugehörige Resourcen-Klasse schließen:

    \Nordkirche\Ndk\Domain\Repository\PersonRepository -> \Nordkirche\Ndk\Domain\Model\Person\Person

Includes können auch verschachtelt werden, um die Relationen von Relationen zu laden:

```php
<?php

use Nordkirche\Ndk\Domain\Model\Institution\Institution;

$query->setInclude([
    Institution::RELATION_ADDRESS,
    Institution::RELATION_PARENT_INSTITUTIONS => [
        Institution::RELATION_ADDRESS
    ]
]);
```

Wir inkludieren in obigem Beispiel die Adressen für alle Institutionen die wir Angefragt haben, inkludieren die 
übergeordneten Institutionen und wiederum die dazu gehörigen Adressen.

Man könnte dazu tendieren, immer alle Relationen zu inkludieren, um unter allen Umständen keine unnötigen Anfragen
gegen die NAPI zu schicken. Dabei sei angemerkt, dass das Inkludieren von Daten die Abfragen langsamer macht.
Daher sollte ganz bewusst ausgewählt werden, welche Relationen für welche Abfragen benötigt werden.

Anhand des Beispiels `examples/3_includes.php` lässt sich der Unterschied zwischen Anfragen mit und ohne `setIncludes()`
nachvollziehen.

### Eigene Relationen zu Resourcen-Objekten

Manchmal ist es gewünscht, Relationen z.B. zu Personen der Nordkirche an eigene Objekten in einer Datenbank herzustellen.
Dazu ist es möglich ein Resourcen-Objekt des NDK in eine URI umzuwandeln, welche gespeichert werden kann.

Diese URIs erhält man beim Casten eines Ressourcen-Objektes zu einem String oder durch Aufruf der Methode `__toString()`.

```php
<?php
$uri = (string)$institution;

// oder

$uri = $institution->__toString();
```

Der String der daraus resultiert, ist im Format: `napi://resource/type/1234`. 
Diese URIs lassen sich komfortabel wieder auflösen:

```php
<?php
$napi = $api->factory(\Nordkirche\Ndk\Service\NapiService::class);
$result = $napi->resolveUrl($uri);
``` 

Auch ganze Listen von URIs lassen direkt mit dem NDK auflösen und fehlende Objekte behandeln:

```php
<?php
$uris = ['napi://resource/typeA/1234', 'napi://resource/typeB/4567', 'napi://resource/typeC/891011'];
$napi = $api->factory(\Nordkirche\Ndk\Service\NapiService::class);
foreach ($napi->resolveUrls($uris) as $result) {
    if ($result instanceof \Nordkirche\Ndk\Domain\Model\ResourcePlaceholder) {
        echo "Resource not found: " . $result->getLabel() . PHP_EOL;
    } else {
        echo "Found: " . $result->getName() . ' (' . $result->getId() . ')' . PHP_EOL;
    }
}
```

In diesem Arrays können gemischt Personen, Institutionen, Verstanstaltungen etc. vorkommen.

Das Beispiel `examples/5_napi_urls.php` führt die Umwandlung und Auflösung einmal praktisch aus.

### Bilder

Resourcen-Objekte können mit Bildern versehen sein. Zum Beispiel hat eine Institution ein Logo `getLogo()` oder eine
Veranstaltung ein beschreibendes Bild `getPicture()`. Ein Bild wird durch ein Objekt der Klasse 
`\Nordkirche\Ndk\Domain\Model\File\Image` repräsentiert. 

```php
<?php
$repository = $api->factory(\Nordkirche\Ndk\Domain\Repository\InstitutionRepository::class);
$instituion = $repository->getById(1930);
$imageUrl = $instituion->getLogo()->render(150);
echo $imageUrl . PHP_EOL;
```

Neben üblichen Bild- und Datei-Eigenschaften bietet es die Methode `render($width, $height)`, 
um die URL zu einer skalierte Version des Bildes zu erhalten. Die Argumente `$width` und `$height` sind beide optional.
Werden beide Argumente angegeben und eines (oder beide) mit dem Postifx `c` versehen, so wird das Bild gecroppt:

```php
<?php
$imageUrl = $event->getPicture()->render('100c', '100c');
```

Weiter Bild- und Datei-Eigenschaften erhält man über `getDetails()`. Dazu gehören Bildunterschriften, 
Copyright-Angaben usw.

## Erweiterte Konfiguration des NDK

Dem im ersten Abschnitt erstellten Konfigurations-Objekt `\Nordkirche\Ndk\Configuration` können noch weitere 
Optionen mitgegeben werden, um das Verhalten des NDK anzupassen.

### Logging

Über PSR-3 kompatible Logger können Anfragen des NDK an die NAPI mitgeschnitten werden.

```php
<?php
$logger = new \Monolog\Logger(
    'stdout',
    [new \Monolog\Handler\StreamHandler('php://stdout')]
);

$configuration->setLogger($logger);
```

Siehe `examples/5_logging.php` für ein Anwendungsbeispiel mit Monolog.

### Caching

Per Default werden HTTP-Anfragen an die NAPI und interne Daten flüchtig in einem Doctrine ArrayCache hinterlegt.

Es ist möglich PSR-6 kompatible Caches für bestimmte Aspekte der Anwendung einzurichten, z.B. mit dem diversen Treibern
aus `doctrine/cache`.

Eine beispielhafte Konfiguration lässt sich unter `6_Caching.php` einsehen und ausführen.

Das Paket `doctrine/cache` selbst bietet 
[Support für diverse Backends](http://docs.doctrine-project.org/projects/doctrine-common/en/latest/reference/caching.html).

Für alle konfigurierbaren Caches ist ein InMemory-Cache als Backend zu empfehlen. Beispielsweise
[APCu](https://github.com/krakjoe/apcu), [Redis](https://redis.io/) oder [Memcache](https://memcached.org/).

#### HTTP-Cache

```php
<?php
$configuration->setHttpCacheProvider(new \Doctrine\Common\Cache\FilesystemCache('./cache/http'));
```

Konfiguriert das Backend für die HTTP-Caching-Middleware. Die NAPI prüft ob Anfragen im Cache neue Daten enthalten und 
nimmt ggf. die bestehenden Daten aus dem eigenen HTTP-Cache.

#### NDK-Spezifische Caches

```php
<?php
$configuration->setReflectionCacheProvider(new \Doctrine\Common\Cache\FilesystemCache('./cache/reflection'));
$configuration->setDependencyInjectionCacheProvider(new \Doctrine\Common\Cache\FilesystemCache('./cache/di'));
```

Diese internen Caches heben die allgemeine Ausführungsgeschwindikeit des NDK an.