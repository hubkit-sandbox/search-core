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

namespace Rollerworks\Component\Search\Extension\Core\ChoiceList\Loader;

use Rollerworks\Component\Search\Extension\Core\ChoiceList\ChoiceList;

/**
 * Loads a choice list.
 *
 * The methods {@link loadChoicesForValues()} and {@link loadValuesForChoices()}
 * can be used to load the list only partially in cases where a fully-loaded
 * list is not necessary.
 *
 * @author Bernhard Schussek <bschussek@gmail.com>
 * @author Sebastiaan Stok <s.stok@rollerscapes.net>
 */
interface ChoiceLoader
{
    /**
     * Loads a list of choices.
     *
     * Optionally, a callable can be passed for generating the choice values.
     * The callable receives the choice as first and the array key as the second
     * argument.
     *
     * @param callable|null $value The callable which generates the values
     *                             from choices
     */
    public function loadChoiceList(callable $value = null): ChoiceList;

    /**
     * Loads the choices corresponding to the given values.
     *
     * The choices are returned with the same keys and in the same order as the
     * corresponding values in the given array.
     *
     * Optionally, a callable can be passed for generating the choice values.
     * The callable receives the choice as first and the array key as the second
     * argument.
     *
     * @param string[]      $values An array of choice values. Non-existing
     *                              values in this array are ignored
     * @param callable|null $value  The callable generating the choice values
     */
    public function loadChoicesForValues(array $values, callable $value = null): array;

    /**
     * Loads the values corresponding to the given choices.
     *
     * The values are returned with the same keys and in the same order as the
     * corresponding choices in the given array.
     *
     * Optionally, a callable can be passed for generating the choice values.
     * The callable receives the choice as first and the array key as the second
     * argument.
     *
     * @param array         $choices An array of choices. Non-existing choices in
     *                               this array are ignored
     * @param callable|null $value   The callable generating the choice values
     *
     * @return string[] An array of choice values
     */
    public function loadValuesForChoices(array $choices, callable $value = null): array;

    /**
     * Returns whether the values are constant (not dependent of there position).
     *
     * {@see \Rollerworks\Component\Search\Extension\Core\ChoiceList\ChoiceList::isValuesConstant}
     */
    public function isValuesConstant(): bool;
}
