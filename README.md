# Ask

Library containing a PHP implementation of the Ask query language.

The implementation consists out of domain objects that represent various parts of Ask queries.

[![Build Status](https://secure.travis-ci.org/wmde/Ask.png?branch=master)](http://travis-ci.org/wmde/Ask)
[![Coverage Status](https://coveralls.io/repos/wmde/Ask/badge.png?branch=master)](https://coveralls.io/r/wmde/Ask?branch=master)
[![Scrutinizer Quality Score](https://scrutinizer-ci.com/g/wmde/Ask/badges/quality-score.png?s=ea4d657f3222ea00305d57bea0339a489882ee95)](https://scrutinizer-ci.com/g/wmde/Ask/)

On Packagist:
[![Latest Stable Version](https://poser.pugx.org/ask/ask/version.png)](https://packagist.org/packages/ask/ask)
[![Download count](https://poser.pugx.org/ask/ask/d/total.png)](https://packagist.org/packages/ask/ask)

## Requirements

* PHP 5.3 or later
* [DataValues](https://github.com/DataValues/DataValues) 0.1 or later

## Installation

You can use [Composer](http://getcomposer.org/) to download and install
this package as well as its dependencies. Alternatively you can simply clone
the git repository and take care of loading yourself.

### Composer

To add this package as a local, per-project dependency to your project, simply add a
dependency on `ask/ask` to your project's `composer.json` file.
Here is a minimal example of a `composer.json` file that just defines a dependency on
Ask 1.0:

    {
        "require": {
            "ask/ask": "1.0.*"
        }
    }

### Manual

Get the Ask code, either via git, or some other means. Also get all dependencies.
You can find a list of the dependencies in the "require" section of the composer.json file.
Load all dependencies and the load the Ask library by including its entry point:
Ask.php.

## Structure

The Ask library defines the Ask query language. Its important components are:

* Ask\Language - everything part of the ask language itself

    * Ask\Language\Description - descriptions (aka concepts)
    * Ask\Language\Option - QueryOptions object and its parts
    * Ask\Language\Selection - selection requests
    * Ask\Language\Query.php - the object defining what a query is

### Description

Each query has a single description which specifies which entities match. This is similar to the
WHERE part of an SQL string. There different types of descriptions are listed below. Since several
types of descriptions can be composed out of one or more sub descriptions, tree like structures can
be created.

* Description - abstract base class

    * AnyValue - A description that matches any object
    * Conjunction - Description of a collection of many descriptions, all of which must be satisfied (AND)
    * Disjunction - Description of a collection of many descriptions, at least one of which must be satisfied (OR)
    * SomeProperty - Description of a set of instances that have an attribute with some value that fits another (sub)description
    * ValueDescription - Description of one data value, or of a range of data values

All descriptions reside in the Ask\Language\Description namespace.

### Option

The options a query consist out of are defined by the <code>QueryOptions</code> class. This class
contains limit, offset and sorting options.

Sorting options are defined by the <code>SortOptions</code> class, which contains a list of
<code>SortExpression</code> objects.

All options related classes reside in the Ask\Language\Option namespace.

### Selection

Specifying what information a query should select from matching entities is done via the selection
requests in the query object. Selection requests are thus akin to the SELECT part of an SQL string.
They thus have no effect on which entities match the query and are returned. All types of selection
request implement abstract base class SelectionRequest and can be found in the Ask\Language\Selection
namespace.

## Usage

#### A query for the first hundred entities that are compared

```php
use Ask\Language\Query;
use Ask\Language\Description\AnyValue;
use Ask\Language\Option\QueryOptions;

$myAwesomeQuery = new Query(
    new AnyValue(),
    array(),
    new QueryOptions( 100, 0 )
);
```

#### A query with an offset of 50

```php
$myAwesomeQuery = new Query(
    new AnyValue(),
    array(),
    new QueryOptions( 100, 50 )
);
```

#### A query to get the ''cost'' of the first hundred entities that have a ''cost'' property

This is assuming 'p42' is an identifier for a ''cost'' property.

```php
$awesomePropertyId = new PropertyValue( 'p42' );

$myAwesomeQuery = new Query(
    new SomeProperty( $awesomePropertyId, new AnyValue() ),
    array(
        new PropertySelection( $awesomePropertyId )
    ),
    new QueryOptions( 100, 0 )
);
```

#### A query to get the first hundred entities that have 9000.1 as value for their ''cost'' property.

This is assuming 'p42' is an identifier for a ''cost'' property.

```php
$awesomePropertyId = new PropertyValue( 'p42' );
$someCost = new NumericValue( 9000.1 );

$myAwesomeQuery = new Query(
    new SomeProperty( $awesomePropertyId, new ValueDescription( $someCost ) ),
    array(),
    new QueryOptions( 100, 0 )
);
```

#### A query getting the hundred entities with highest ''cost'', highest ''cost'' first

This is assuming 'p42' is an identifier for a ''cost'' property.

```php
$awesomePropertyId = new PropertyValue( 'p42' );

$myAwesomeQuery = new Query(
    new AnyValue(),
    array(),
    new QueryOptions(
        100,
        0,
        new SortOptions( array(
            new PropertyValueSortExpression( $awesomePropertyId, SortExpression::DESCENDING )
        ) )
    )
);
```

#### A query to get the hundred first entities that have a ''cost'' either equal to 42 or bigger than 9000

This is assuming 'p42' is an identifier for a ''cost'' property.

```php
$awesomePropertyId = new PropertyValue( 'p42' );
$costOf42 = new NumericValue( 42 );
$costOf9000 = new NumericValue( 9000 );

$myAwesomeQuery = new Query(
    new SomeProperty(
        $awesomePropertyId,
        new Disjunction( array(
            new ValueDescription( $costOf42 ),
            new ValueDescription( $costOf9000, ValueDescription::COMP_GRTR ),
        ) )
    ),
    array(),
    new QueryOptions( 100, 0 )
);
```

## Tests

This library comes with a set up PHPUnit tests that cover all non-trivial code. You can run these
tests using the PHPUnit configuration file found in the root directory. The tests can also be run
via TravisCI, as a TravisCI configuration file is also provided in the root directory.

## Authors

Ask has been written by [Jeroen De Dauw](https://www.mediawiki.org/wiki/User:Jeroen_De_Dauw)
as [Wikimedia Germany](https://wikimedia.de) employee for the [Wikidata project](https://wikidata.org/).

This library is a reimplementation of the Ask language domain objects in
[Semantic MediaWiki](https://semantic-mediawiki.org/), which have been written by
[Markus Krötzsch](http://korrekt.org/). This reimplementation is conceptually almost
entirely based on the original code and contains small portions of it.

## Release notes

### 1.0.2 (2014-10-16)

* Installation together with DataValues 1.x is now supported.

### 1.0.1 (2014-01-21)

* Removed custom autoloader. The Composer support for PSR-4 is now used.
* The PHPUnit bootstrap file now automatically runs "composer update".

### 1.0 (2013-11-17)

Initial release with these features:

* PHP implementation of the Ask language core
* Implementation of descriptions, selection requests and sort options initially needed for Wikidata

## Links

* [Ask on Packagist](https://packagist.org/packages/ask/ask)
* [Ask on Ohloh](https://www.ohloh.net/p/ask)
* [Ask on coveralls.io](https://coveralls.io/r/wmde/Ask?branch=master)
* [Ask on ScrutinizerCI](https://scrutinizer-ci.com/g/wmde/Ask/)
* [Ask on TravisCI](https://travis-ci.org/wmde/Ask)
* [NodeJS implementation of Ask](https://github.com/JeroenDeDauw/AskJS)
