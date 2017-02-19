# Работа с тегами

## Требования:
- php 7
- symfony 3.2

## Установка

1. Прописать пакет и ссылку на репозиторий в `composer.json`
```json
{
    // ...
    "require": {
        // ...
        "SmartInformationSystems/tags-bundle": "dev-master"
    },
    "repositories": [
        {
            "type" : "vcs",
            "url" : "https://github.com/SmartInformationSystems/TagsBundle.git"
        }
    ]
}
```

2. Включить бандл в `app/AppKernel.php`
```php
class AppKernel extends Kernel
{
    public function registerBundles()
    {
        $bundles = array(
            // ...
            new SmartInformationSystems\FileBundle\SmartInformationSystemsTagsBundle(),
            // ...
        );
    }
}
```

3. Включить необходимые шаблоны
```yaml
twig:
    form_themes:
        - 'SmartInformationSystemsTagsBundle:form:fields.html.twig'

```

4. Добавить настроки в `app/config/routing.yml`
```yaml
smart_information_systems.tags:
    resource: "@SmartInformationSystemsTagsBundle/Resources/config/routing.yml"
    prefix: /tags
```

## Использование
