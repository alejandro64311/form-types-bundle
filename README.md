# DSY - FormTypesBundle

## Instalación

### Via composer

Agregar repositorio de desarrollo




```json
    //composer.json
    "repositories": [
        ...
        {
            "type": "vcs",
            "url": "https://bitbucket.org/dsarhoya/form-types-bundle.git"
        }
    ],
```

Ejecutar e instalar el bundle desde la line a de comandos
```terminal
composer require dsarhoya/form-types-bundle
```

Agregar el bundle al kernel de Symfony
```php
// app/appKernel.php
public function registerBundles() {
  $bundles = array(
    ...
    new dsarhoya\FormTypesBundle\FormTypesBundle()
  );
}
```

Agregar las platillas del bundle a tu proyecto
```yaml
// app/config.yml
# Twig Configuration
twig:
    ...
    form_themes:
        ...
        - '@FormTypes/form/fields.html.twig'
```
El Bundle dispone de dos twig con los css y js necesarios para funcionar los diferentes *Types*, para hacer uso de ellos podemos usar el comando include de twig.

En tu twig principal o el twig donde carges los CSS y Js del proyecto *base.html.twig* agregar las siguientes lineas

```twig

<!DOCTYPE html>
<html lang="es">
<head>
    ...
    {% block stylesheets %}
        ...
        {% include "@FormTypes/stylesheets.html.twig" %}
        ...
    {% endblock stylesheets %}
</head>
<body>
    ...

    {% block javascripts %}
        ...
        {% include "@FormTypes/javascripts.html.twig" %}
        ...
    {% endblock %}
</body>
</html>
```

## Uso

El bundle dispone de los siguientes Types:

* DatePickerType
* DateTimePickerType
* StarRatingType

El uso de estos es el mismo que cualquier FormType de symfony. Simplemente hay que tener en cuenta sus propias opciones.

Ej.

```php
// AppBudle/Form/TestType.php
<?php

namespace AppBundle\Form\Post;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use dsarhoya\FormTypesBundle\Form\Type\DatePickerType;
use dsarhoya\FormTypesBundle\Form\Type\DatetimePickerType;
use dsarhoya\FormTypesBundle\Form\Type\StarRatingType;

class TestType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('date', DatePickerType::class, [
                'label'=>'Desde',
                'required'=>true,
                'language' => 'es',
                'format' => 'dd/mm/yyyy'
            ])
            ->add('star', StarRatingType::class, [
                'theme' => 'krajee-fa5', //FontAwesome 5
                'required' => false,
            ])
        ;
    }
    ...
}

```
## Opciones

### StarRatingType

* min: integer
* max: integer
* step: float
* disabled: boolean
* readonly: boolean
* size: 'xs'|'sm'|'md'|'lg'
* showClear: boolean
* showCaption: boolean
* ratingDetail: string
* theme: string
  * 'krajee-fa': (FontAwesome,por defecto)
  * 'krajee-svg'
  * 'krajee-uni': (unicode)
  * 'krajee-fa5': (fontAwesome v5)
* language: 'es'|'en'
* containerClass: string para agregar clases al contenedor

### DatePickerType

* startDate: \DateTime,
* endDate: \DateTime,
* language: => 'es'|'en', ..., Por defecto tiene Español e ingles cargados, si quiere otro lenguaje tiene que carcar el js correspondiente.

### DatetimePickerType
NOTA *type en desarrollo no funciona bien aún, no esta probado*

* language: 'en'|'en'
* formatPicker: 'dd/mm/yyyy'
