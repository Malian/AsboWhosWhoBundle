<?php

/*
 * This file is part of the ASBO package.
 *
 * (c) De Ron Malian <deronmalian@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Asbo\WhosWhoBundle\Filter;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;

use Doctrine\ORM\QueryBuilder;

use Lexik\Bundle\FormFilterBundle\Filter\FilterBuilderExecuterInterface;
use Lexik\Bundle\FormFilterBundle\Filter\ORM\Expr;
use Lexik\Bundle\FormFilterBundle\Filter\Extension\Type\FilterTypeSharedableInterface;
use Lexik\Bundle\FormFilterBundle\Filter\FilterOperands;

use Asbo\WhosWhoBundle\Entity\Post;

/**
 * Embbed filter type.
 */
class FraHasPostsFilterType extends AbstractType implements FilterTypeSharedableInterface
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('anno', 'filter_number', array('condition_operator' => FilterOperands::OPERAND_SELECTOR))
                ->add('post', 'filter_entity', array('class' => 'AsboWhosWhoBundle:Post', 'property' => 'name', 'expanded' => false, 'multiple' => true));
    }

    public function getName()
    {
        return 'fra_has_posts_filter';
    }

    /**
     * This method aim to add all joins you need
     */
    public function addShared(FilterBuilderExecuterInterface $qbe)
    {
        $closure = function (QueryBuilder $filterBuilder, $alias) {
            // add the join clause to the doctrine query builder
            // the where clause for the label and color fields
            // will be added automatically with the right alias
            // later by the Lexik\Filter\QueryBuilderUpdater
            $filterBuilder->leftJoin($alias . '.fraHasPosts', 'posts');
        };

        // then use the query builder executor to define the join,
        // the join's alias and things to do on the doctrine query builder.
        $qbe->addOnce($qbe->getAlias().'.fraHasPosts', 'posts', $closure);
    }
}
