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
use Asbo\WhosWhoBundle\Validator\Constraints\Anno;
use Asbo\ResourceBundle\Controller\ResourceController;
use JMS\SecurityExtraBundle\Annotation\Secure;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;

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

    public function annoAction($anno, Request $request, $security = true)
    {
        $error = $this->container->get('validator')->validateValue($anno, new Anno());

        if (count($error) != 0) {
            throw new NotFoundHttpException(sprintf("Anno '%s' doens't exists", $anno));
        }

        if ($security && !$this->container->get('security.context')->isGranted('ROLE_WHOSWHO_USER')) {
            throw new AccessDeniedException();
        }

        $manager = $this->getFraHasPostManager();
        $posts   = $manager->findByTypesAndYear(array(Post::TYPE_COMITE, Post::TYPE_CONSEIL), $anno);

        // Lors de la phase de transition avec le synode il n'y a pas encore de comité
        // On prend le comité de l'anno précédente comme référence
        if (0 === count($posts)) {

            --$anno;

            // Dans ce cas, on fait appel au controller depuis "lastAction"
            if (null === $request->attributes->get('anno')) {
                return $this->annoAction($anno, $request, $security);
            }

            // Sinon on redirige en précisiant que c'est une redirection temporaire
            $url = $this->getRouter()->generate('asbo_whoswho_comite_anno', array('anno' => $anno));

            return new RedirectResponse($url, 307);
        }

        return $this->renderResponse(
            'listByAnno.html',
            array(
                'posts' => $posts,
                'anno' => $anno
            )
        );
    }

    public function lastAction(Request $request)
    {
        return $this->annoAction(AnnoManipulator::getCurrentAnno(), $request, false);
    }

    protected function getFraHasPostManager()
    {
        return $this->container->get('asbo_whoswho.fra_has_post_manager');
    }

    protected function getRouter()
    {
        return $this->container->get('router');
    }
}
