<?php

/*
 * This file is part of the ASBO package.
 *
 * (c) De Ron Malian <deronmalian@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Asbo\WhosWhoBundle\Controller;

use Asbo\WhosWhoBundle\Entity\Post;
use Asbo\WhosWhoBundle\Util\AnnoManipulator;
use Asbo\ResourceBundle\Controller\ResourceController;
use JMS\SecurityExtraBundle\Annotation\Secure;

/**
 * Controller of comite page
 *
 * @author De Ron Malian <deronmalian@gmail.com>
 */
class ComiteController extends ResourceController
{
    /**
     * @Secure(roles="ROLE_WHOSWHO_USER")
     */
    public function listAction()
    {
        $fraHasPostManager = $this->container->get('asbo_whoswho.fra_has_post_manager');
        $posts             = $fraHasPostManager->findByTypes(array(Post::TYPE_COMITE, Post::TYPE_CONSEIL));
        $postsByYears      = array();

        foreach ($posts as $post) {
            $postsByYears[$post->getAnno()][] = $post;
        }

        return $this->renderResponse(
            'list.html',
            array('posts' => $postsByYears)
        );
    }

    public function annoAction($anno)
    {
        $fraHasPostManager = $this->container->get('asbo_whoswho.fra_has_post_manager');
        $posts             = $fraHasPostManager->findByTypesAndYear(array(Post::TYPE_COMITE, Post::TYPE_CONSEIL), $anno);

        return $this->renderResponse(
            'listByAnno.html',
            array(
                'posts' => $posts,
                'anno' => $anno
            )
        );
    }

    public function lastAction()
    {
        return $this->annoAction(AnnoManipulator::getCurrentAnno());
    }
}
