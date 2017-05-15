<?php

/**
 * @file
 * Contains \Drupal\city_search\Plugin\Block\CityNavigationBlock.
 */

namespace Drupal\city_search\Plugin\Block;

use Drupal\Core\Block\BlockBase;

/**
 * Provides a 'navigation' block.
 *
 * @Block(
 *   id = "city_search_navigation_block",
 *   admin_label = @Translation("City Search Navigation block"),
 *   category = @Translation("Navigation for this custom module")
 * )
 */
class CityNavigationBlock extends BlockBase {

    /**
     * {@inheritdoc}
     */
    public function build() {
        return array(
            '#theme' => 'city_search_navigation_block',
            '#text' => 'Heellllooooo!',
            '#attached' => array(
                'library' => array(
                    'city_search/city_search.navigation'
                ),
            ),
        );
    }
}