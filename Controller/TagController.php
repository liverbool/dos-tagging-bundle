<?php

namespace DoS\TaggingBundle\Controller;

use DoS\ResourceBundle\Controller\ResourceController;
use FOS\RestBundle\View\View;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;

class TagController extends ResourceController
{
    /**
     * @param Request $request
     *
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function searchJsonAction(Request $request)
    {
        $configuration = $this->requestConfigurationFactory->create($this->metadata, $request);
        $keyword = $request->get('keyword');
        $results = $this->get('dos.repository.tag')->search($keyword) ?: array();

        return $this->viewHandler->handle($configuration, View::create($results));
    }
}
