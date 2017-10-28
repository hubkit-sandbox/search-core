<?php

declare(strict_types=1);

/*
 * This file is part of the RollerworksSearch package.
 *
 * (c) Sebastiaan Stok <s.stok@rollerscapes.net>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace Rollerworks\Component\Search\Field;

use Rollerworks\Component\Search\Extension\Core\Type\SearchFieldType;
use Rollerworks\Component\Search\Util\StringUtil;
use Symfony\Component\OptionsResolver\OptionsResolver;

/**
 * The AbstractFieldType can be used as a base class implementation for FieldTypes.
 *
 * An added bonus for extending this class rather then the implementing the the
 * {@link FieldTypeInterface} is that any new methods added the
 * FieldTypeInterface will not break existing implementations.
 *
 * @author Sebastiaan Stok <s.stok@rollerscapes.net>
 */
abstract class AbstractFieldType implements FieldType
{
    /**
     * {@inheritdoc}
     */
    public function buildType(FieldConfig $config, array $options): void
    {
    }

    /**
     * {@inheritdoc}
     */
    public function buildView(SearchFieldView $view, FieldConfig $config, array $options): void
    {
    }

    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver): void
    {
    }

    /**
     * {@inheritdoc}
     */
    public function getParent(): ?string
    {
        return SearchFieldType::class;
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix(): string
    {
        return StringUtil::fqcnToBlockPrefix(get_class($this));
    }
}
