<p align="center"><img src="https://i.ibb.co/cccf74t/logo.png"></p>


<p align="center">
<a href="https://packagist.org/packages/hacklabsde/laravel-trends"><img src="https://poser.pugx.org/hacklabsdev/laravel-trends/d/total" alt="Total Downloads"></a> <a href="https://packagist.org/packages/hacklabsde/laravel-trends"><img src="https://poser.pugx.org/hacklabsdev/laravel-trends/v/stable" alt="Latest Stable Version"></a> <a href="https://packagist.org/packages/hacklabsde/laravel-trends"><img src="https://poser.pugx.org/hacklabsdev/laravel-trends/license" alt="License"></a>
</p>

## Introduction

Have you ever wondered how Twitter's Hashtag system works? Laravel Trends provides a lightweight trending system to your application.

## Prerequisites

Before you install the package make sure you have queues working as Trends uses it to control the tendences. Refer to Laravel [official documentation](https://laravel.com/docs/master/queues#introduction "official documentation") in order to configure queues in your project.

## Installation

You may install Laravel Trends via Composer:

`$ composer require hacklabs/laravel-trends`

Next, publish the Trends configuration and migration files using the vendor:publish command. The configuration file will be placed in your config directory:

`$ php artisan vendor:publish --provider="Hacklabs\Trends\TrendsServiceProvider"`

And finally, you should run your database migrations:

`php artisan migrate`

## How it works

Trends allows you to create a trending system for any model you want. Let's take Twitter as an example. Everytime a hashtag is tweeted it receives 1 point of energy, but after 30 minutes this single point of energy decays 0.25 of it's value. After more 30 minutes it decays 0.45 points of it's value. Finally, after another 30 minutes it decays 0.30 of its value returning to 0. But how can a trend be detected? Imagine that thousands of people hits the same hashtag at the same time, this hashtag will have thousands of energy points and if you have an ordered list of hashtags this one will surely be on top, but after a few minutes if this hashtag doesn't receive any more energy points it will start to loose it's energy and decay over time.

## Configuration

To configure your decaying time you can set the `energy_decay` parameter in `config/trends.php`. The decaying time is measured in hours.

## Preparing your model

To allow your model to work with Trends you'll need to implement the HasEnergy trait. And in order to return the current model's energy value, add `energy_amount` to your serialization.
```php
use Hacklabs\Trends\Traits\HasEnergy;
    
class Hashtag extends Model
{
    use HasEnergy;
    
    protected $appends = ['energy_amount'];
}
```
## Usage

To add energy to your model use the following method:
```php
$hashtag->addEnergy(1);
```

To get the current value:

```php
$hashtag->energy->amount;
```

## Examples

```php
$hashtags = Hashtag::all();

$orderedHashtags = $hashtags->sortByDesc('energy_amount');
```

The above code creates a ordered list of hashtags based on trends.

## License

Laravel Trends is open-sourced software licensed under the [MIT license](LICENSE.md).
