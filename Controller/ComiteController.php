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
use Asbo\WhosWhoBundle\Validator\AnnoValidator;
use Asbo\WhosWhoBundle\Validator\Constraints\Anno;
use Asbo\ResourceBundle\Controller\ResourceController;
use JMS\SecurityExtraBundle\Annotation\Secure;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

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
        $manager      = $this->getFraHasPostManager();
        $posts        = $manager->findByTypes(array(Post::TYPE_COMITE, Post::TYPE_CONSEIL));
        $postsByYears = array();

        foreach ($posts as $post) {
            $postsByYears[$post->getAnno()][] = $post;
        }

        return $this->renderResponse(
            'list.html',
            array('posts' => $postsByYears)
        );
    }

    /**
     * @Secure(roles="ROLE_WHOSWHO_USER")
     */
    public function annoAction($anno)
    {
        $error = $this->container->get('validator')->validateValue($anno, new Anno());

        if (count($error) != 0) {
            throw new NotFoundHttpException(sprintf("Anno '%s' doens't exists", $anno));
        }

        $manager = $this->getFraHasPostManager();
        $posts   = $manager->findByTypesAndYear(array(Post::TYPE_COMITE, Post::TYPE_CONSEIL), $anno);

        /**
         * Lors de la phase de transition avec le synode il n'y a pas encore de comité
         * La solution ici n'est pas correcte parce que l'url correspondra à l'année actuel
         * alors qu'elle affichera l'année précédente. Il faut, je pense, faire une rediretion
         * temporaire (307).
         */
        if (count($posts) == 0) {
            return $this->annoAction(--$anno);
        }

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

    protected function getFraHasPostManager()
    {
        return $this->container->get('asbo_whoswho.fra_has_post_manager');
    }
}
