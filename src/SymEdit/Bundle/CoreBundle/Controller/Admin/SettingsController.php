<?php

namespace SymEdit\Bundle\CoreBundle\Controller\Admin;

use SymEdit\Bundle\CoreBundle\Controller\ResourceController;
use JMS\SecurityExtraBundle\Annotation\PreAuthorize;
use Symfony\Component\HttpFoundation\Request;

/**
 * Settings controller.
 *
 * @PreAuthorize("hasRole('ROLE_ADMIN_SETTING')")
 */
class SettingsController extends ResourceController
{
    public function indexAction(Request $request)
    {
        $settings = $this->findOr404();
        $form = $this->getForm($settings);

        $view = $this
            ->view()
            ->setTemplate('@SymEdit/Admin/Settings/index.html.twig')
            ->setData(array(
                'settings' => $settings->getSettings(),
                'form' => $form->createView(),
            ));

        return $this->handleView($view);
    }

    public function findOr404(array $criteria = null)
    {
        return $this->get('isometriks_settings.settings');
    }

    public function persistAndFlush($resource, $action = 'create')
    {
        $this->dispatchEvent($action, $resource);
        $resource->save();
        $this->dispatchEvent(sprintf('post_%s', $action), $resource);
    }
}
