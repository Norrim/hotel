<?php

namespace AdminBundle\Twig;

use Symfony\Component\PropertyAccess\PropertyAccess;
use Symfony\Component\HttpFoundation\RequestStack;

class TranslateExtension extends \Twig_Extension
{
    /**
     *
     * @var string
     */
    protected $locale;

    /**
     *
     * @var string
     */
    protected $defaultLocale;

    /**
     *
     * @var \Symfony\Component\PropertyAccess\PropertyAccessor
     */
    protected $propertyAccessor;

    public function __construct(RequestStack $requestStack)
    {
        if($requestStack->getMasterRequest())
        {
            $this->locale = $requestStack->getMasterRequest()->getLocale();
            $this->defaultLocale = $requestStack->getMasterRequest()->getDefaultLocale();
        }

        $this->propertyAccessor = PropertyAccess::createPropertyAccessor();
    }

    public function getFunctions()
    {
        return array(
            new \Twig_SimpleFunction('translate', array($this, 'translate')),
        );
    }

    public function translate($array, $key)
    {

        if(!is_array($array) && method_exists($array, 'toArray'))
        {
            $array = $array->toArray();
            
            foreach ($array as $k => $v) {
                $tab[$v->getLocale()] = $v;
            }
        }
        elseif(!is_array($array))
        {
            throw new \Exception('Translation need an array or an object wich implements "toArray"');
        }
        
        if(isset($tab[$this->locale]))
        {
            return $this->propertyAccessor->getValue($tab[$this->locale], $key);
        }
        
        if(isset($tab[$this->defaultLocale]))
        {
            return $this->propertyAccessor->getValue($tab[$this->defaultLocale], $key);
        }
        else
        {
            throw new \Exception('Object key "'.$key.'" not translated');
        }
    }


    public function getName()
    {
        return 'translate';
    }
}
