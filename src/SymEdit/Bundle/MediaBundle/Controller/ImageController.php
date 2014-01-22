<?php

/*
 * This file is part of the SymEdit package.
 *
 * (c) Craig Blanchette <craig.blanchette@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace SymEdit\Bundle\MediaBundle\Controller;

use Gedmo\Sluggable\Util as Sluggable;
use JMS\SecurityExtraBundle\Annotation\PreAuthorize;
use SymEdit\Bundle\ResourceBundle\Controller\ResourceController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;

/**
 * Image controller.
 *
 * @PreAuthorize("hasRole('ROLE_ADMIN_IMAGE')")
 */
class ImageController extends ResourceController
{
    public function jsonAction()
    {
        $images = $this->getRepository()->findAll();
        $out = array();
        $webPath = $this->container->getParameter('symedit_media.paths.image');

        foreach($images as $image){
            $out[] = array(
                'thumb' => $this->getThumbnail($image->getPath()),
                'image' => $this->getWebPath($image->getPath()),
            );
        }

        return new JsonResponse($out);
    }

    protected function getWebPath($path)
    {
        return sprintf('%s/%s', $this->container->getParameter('symedit_media.paths.image'), $path);
    }

    protected function getThumbnail($path, $size = 'symedit_64x64')
    {
        $this->container->get('liip_imagine.controller')->filterAction(
            $this->getRequest(),
            $path,
            $size
        );

        $cacheManager = $this->container->get('liip_imagine.cache.manager');

        return $cacheManager->getBrowserPath($path, $size);
    }

    public function quickUploadAction(Request $request)
    {
        $file = $request->files->get('file');
        $name = pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME);
        $nameSlug = Sluggable\Urlizer::urlize($name, '-');

        $image = $this->getRepository()->createNew();
        $image->setFile($file);
        $image->setName($nameSlug);

        try {
            $this->persistAndFlush($image);

            return new JsonResponse(array(
                'filelink' => $this->getWebPath($image->getPath()),
            ));

        } catch (\Exception $ex) {

            return new JsonResponse(array(
                'error' => 'Error uploading, try renaming your image file.',
            ));
        }
    }
}
