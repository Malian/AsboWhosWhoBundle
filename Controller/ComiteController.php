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
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
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
     * Displays all comite
     *
     * @throws AccessDeniedException if the user are not allowed
     */
    public function listAction()
    {
        if (!$this->isGranted('ROLE_WHOSWHO_USER')) {
            throw new AccessDeniedException();
        }

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
     * Displays a specific comite by anno.
     *
     * @param integer $anno The anno
     *
     * @throws AccessDeniedException if the user are not allowed.
     */
    public function annoAction($anno)
    {
        if (!$this->isGranted('ROLE_WHOSWHO_USER')) {
            throw new AccessDeniedException();
        }

        return $this->getByAnno($anno);
    }

    /**
     * Displays current comite.
     */
    public function lastAction()
    {
        return $this->getByAnno(AnnoManipulator::getCurrentAnno());
    }

    /**
     * Displays a specific comite by anno.
     *
     * @param integer $anno The anno
     *
     * @throws NotFoundHttpException if the anno doesn't exist
     */
    protected function getByAnno($anno)
    {
        $error = $this->getValidator()->validateValue($anno, new Anno());

        if (count($error) != 0) {
            throw new NotFoundHttpException(sprintf("Anno '%s' doens't exists", $anno));
        }

        $manager = $this->getFraHasPostManager();
        $posts   = $manager->findByTypesAndYear(array(Post::TYPE_COMITE, Post::TYPE_CONSEIL), $anno);

        // Lors de la phase de transition avec le synode il n'y a pas encore de comité
        // On prend le comité de l'anno précédente comme référence
        // Codexialement c'est correct ! ;-)
        if (0 === count($posts)) {

            --$anno;

            // Dans ce cas, on fait appel au controller depuis "lastAction"
            if (null === $this->getRequest()->attributes->get('anno')) {
                return $this->getByAnno($anno);
            }

            // Sinon on redirige en précisiant que c'est une redirection temporaire
            $url = $this->generateUrl('asbo_whoswho_comite_anno', array('anno' => $anno));

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

    /**
     * Get validator.
     *
     * @return \Symfony\Component\Validator\ValidatorInterface
     */
    protected function getValidator()
    {
        return $this->get('validator');
    }

    /**
     * Get fraHasPost manager.
     *
     * @return \Asbo\WhosWhobundle\Entity\FraHasPostManager
     */
    protected function getFraHasPostManager()
    {
        return $this->get('asbo_whoswho.fra_has_post_manager');
    }

    /**
     * Checks if the attributes are granted against the current authentication token and optionally supplied object.
     *
     * @param mixed      $attributes
     * @param mixed|null $object
     *
     * @return boolean
     */
    protected function isGranted($attributes, $object = null)
    {
        return $this->get('security.context')->isGranted($attributes, $object);
    }
}
