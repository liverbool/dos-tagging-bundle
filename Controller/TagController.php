<?php

namespace DoS\TaggingBundle\Controller;

use DoS\ResourceBundle\Controller\ResourceController;
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
        $keyword = $request->get('keyword');
        $results = $this->get('dos.repository.tag')->search($keyword) ?: array();

        return $this->handleView($this->view($results));
    }
}
