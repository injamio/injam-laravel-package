# Injam Laravel Package

[![Build Status](https://travis-ci.org/injamio/injam-laravel-package.svg?branch=master)](https://travis-ci.org/injamio/injam-laravel-package)
[![styleci](https://styleci.io/repos/134127789/shield)](https://styleci.io/repos/134127789)
[![Scrutinizer Code Quality](https://scrutinizer-ci.com/g/injamio/injam-laravel-package/badges/quality-score.png?b=master)](https://scrutinizer-ci.com/g/injamio/injam-laravel-package/?branch=master)
[![SensioLabsInsight](https://insight.sensiolabs.com/projects/2aabff8c-7aa4-4c56-9569-a182f9a1801f/mini.png)](https://insight.sensiolabs.com/projects/CHANGEME)
[![Coverage Status](https://coveralls.io/repos/github/injamio/injam-laravel-package/badge.svg?branch=master)](https://coveralls.io/github/injamio/injam-laravel-package?branch=master)

[![Packagist](https://img.shields.io/packagist/v/injamio/injam-laravel-package.svg)](https://packagist.org/packages/injamio/injam-laravel-package)
[![Packagist](https://poser.pugx.org/injamio/injam-laravel-package/d/total.svg)](https://packagist.org/packages/injamio/injam-laravel-package)
[![Packagist](https://img.shields.io/packagist/l/injamio/injam-laravel-package.svg)](https://packagist.org/packages/injamio/injam-laravel-package)

"Injam" is a Next Generation Real-Time Machine that provides a set of Geolocation, Geospatial, Messaging and Streaming services in fast (almost-teleporting) and secure way. So this Package enables you to interact with them easily from server side.

## Installation

Install via composer
```bash
composer require injamio/injam-laravel-package
```

### Register Service Provider

Note: This and next steps are optional if you use Laravel >= 5.5 with package
auto discovery feature.

Add service provider to `config/app.php` in `providers` section
```php
Injamio\InjamLaravelPackage\ServiceProvider::class,
```

### Register Facade

Register package facade in `config/app.php` in `aliases` section
```php
Injamio\InjamLaravelPackage\Facades\InjamLaravelPackage::class,
```

### Publish Configuration File

```bash
php artisan vendor:publish --provider="Injamio\InjamLaravelPackage\ServiceProvider" --tag="config"
```

### API Key
Add `INJAM_API_KEY` to your `.env` file:
```bash
INJAM_API_KEY=YOUR_INJAM_API_KEY
```
[Here](https://dashboard.injam.io/applications) you can find you application api key.

## Usage

Use package in your controller:
```php
use Injamio\InjamLaravelPackage\InjamLaravelPackage;
```

Create instance of InjamLaravelPackage class:
```php
$injam = new InjamLaravelPackage;
```

#### Add Tracker:
```php
$tracker = $njam->addTracker(TRACKING_PHYSICAL_ID, TRACKER_MOBILE);
```
Example:
```php
$tracker = $njam->addTracker('zxcvbn', '09123456789');
```

#### Add Geofence webhook:
```php
$hook = $njam->addGeoFenceWebhook(OBJECT_TYPE, PHYSICAL_ID, TARGET_POINT, RADIUS_IN_METERS, ENDPOINT, DETECT_EVENTS);
```
Example:
```php
$hook = $njam->addGeoFenceWebhook('bike', 'zxcvbn', '35.7384336,51.4026536', 60, 'https://api.example.com/v1/do/action', 'enter,exit');
```