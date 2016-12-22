<?php

namespace AdminBundle;

use AdminBundle\Lib\Globals;
use Symfony\Component\HttpKernel\Bundle\Bundle;

class AdminBundle extends Bundle
{
    public function boot()
    {
        Globals::setLocales($this->container->getParameter('locales'));
        Globals::setUploadImageDir($this->container->getParameter('uploadImageDir'));
        Globals::setUploadImageRootDir($this->container->getParameter('uploadImageRootDir'));
    }
}
