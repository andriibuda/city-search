<?php

namespace Drupal\city_search\Ajax;

class CitySearchAjax
{
    /**
     * @param $request
     * @return string
     */
    public function getCities($request)
    {
        $db_logic = \Drupal::service('city_search.db_logic');
        $cities = $db_logic->getByName($request);
        $list = '';

        if ($cities[0]->city) {

            for ($i = 0; $i < count($cities); $i++) {
                $list .= '<li class="cities__list-item">'.'<a href="#">'.$cities[$i]->city.' '.$cities[$i]->country.'</a>'.'</li>';
            }

            return $list;

        } else {
            $list .= '<li class="cities__list-item item-not-found">'.'Sorry, no matches...'.'</li>';
            return $list;
        }
    }
}