# canapecrm-client
Canape CRM API implementation

Package provides basic integration methods implementation.
Deal creation and retrieving DealType and Event lists are available in the current version.

Installation
------------

The preferred way to install this extension is through [composer](http://getcomposer.org/download/).

Either run

```
php composer.phar require --prefer-dist canapecrm/api-client
```

or add

```
canapecrm/api-client
```

to the require section of your `composer.json` file.


Usage
-----

Configure your canapecrm.ru domain and access token.
The Deal creation example is below:

```
$oClient = new CanapeCrmApi\ClientLib( '<domain>.canapecrm.ru', CANAPECRM_ACCESS_TOKEN );
```

> For security, keep access token definition CANAPECRM_ACCESS_TOKEN in the secure place out from version control.

```
try {
    $oResponse = $oClient->createDeal(
        (new CanapeCrmApi\models\NewDeal())
            ->setDomain( $_SERVER['SERVER_NAME'] )
            ->setDealTitle( 'Deal Castle Manufacture website ' . date( "H:i:s d.m.Y" ) )
            ->setDealContent( 'A cannonball for riding on' )
            ->setContactClient( 'Baron Munchausen' )
            ->setContactEmail( 'baron@crm.saas' )
            ->setContactPhone( '+1720 (0511) 97-02-22' )
            /* Works only with auto invoice settings */
            ->addCatalogItem(
                (new CanapeCrmApi\models\Catalog())
                    ->setIndex('CB690')
                    ->setTitle( 'Pumhart von Steyr cannonball' )
                    ->setCount( 1 )
                    ->setPrice( 2000 )
            )
    );

    /**
     * Array with new deal id
     * [ 'id' => <id> ]
     * Optionally returns a href to the generated document
     * [ 'id' => <id>,
     *    'form|offer|invoice' => <url>
     * ]
     */
    $oResponse->json();

} catch ( \CanapeCrmApi\exception\CanapeCrmClientException $e ) {

    /**
     * Catch api-client exceptions such as required fields validation errors
     */

} catch ( GuzzleHttp\Exception\RequestException $e ) {
    echo $e->getRequest() . "\n";
    if ( $e->hasResponse() ) {


        $e->getResponse()->json();
    }
}
```

To perform Deal separation by type and event use method results:

```
$oResponse = $oClient->getDealTypes(); // ->getEvents()
$oResponse->json();
```
Then you can set it on deal creation:
```
$oResponse = $oClient->createDeal(
    (new CanapeCrmApi\models\NewDeal())
        ...
        ->setEventId( <id> )
        ->setDealTypeId( <id> )
        ...
);
```

Provide a result of javascript counter via method:
 ```
    ...
    ->setCanapeUuid( <uuid> )
    ...
 ```
