<p align="center">
    <a href="https://sylius.com" target="_blank">
        <img src="https://demo.sylius.com/assets/shop/img/logo.png" />
    </a>
</p>

<h1 align="center">SendInBlue Plugin</h1>

<p align="center">Integrate SendInBlue into Sylius.</p>
<p align="center">/!\ Currently in alpha /!\</p>

## Quickstart


```
$ composer require ikuzostudio/sendinblue-plugin
```

Add plugin dependencies to your `config/bundles.php` file:

```php
return [
  // ...
  Ikuzo\SyliusSendinbluePlugin\IkuzoSyliusSendinbluePlugin::class => ['all' => true],
];
```

Import required config in your `config/packages/_sylius.yaml` file:

```yaml
# config/packages/_sylius.yaml

imports:
  ...
  - { resource: "@IkuzoSyliusSendinbluePlugin/Resources/config/app/config.yaml" }
```

Extend your Channel entity
```php
// [...]
use Sylius\Component\Core\Model\Channel as BaseChannel;
use Ikuzo\SyliusSendinbluePlugin\Model\SendinblueChannelInterface;
use Ikuzo\SyliusSendinbluePlugin\Model\SendinblueChannelTrait;

/**
 * @ORM\Table(name="sylius_channel")
 * @ORM\Entity()
 */
class Channel extends BaseChannel implements SendinblueChannelInterface
{
  use SendinblueChannelTrait;
}
```

Update your database

```
$ bin/console doctrine:schema:update --force
```

<img src="doc/config.png" />
