<?php

namespace Drupal\city_search\Controller;

use Symfony\Component\HttpFoundation\Request;
use Drupal\Core\Controller\ControllerBase;
use Symfony\Component\HttpFoundation\JsonResponse;
use Drupal\city_search\Ajax\CitySearchAjax;

class CitySearchController extends ControllerBase {

    /**
     * Main module page.
     * @return array
     */
    public function main() {
        $form = \Drupal::formBuilder()->getForm('Drupal\city_search\Form\FieldForm');
        $hotels = \Drupal::service('city_search.db_logic')->getHotelByLocation();

        $page = array(
            '#title' => 'City Search',
            '#theme' => 'city_search',
            '#name' => 'Hello',
            '#form' => $form,
            '#list' => $hotels,
        );

        return $page;
    }

    public function search($slug) {
        $form = \Drupal::formBuilder()->getForm('Drupal\city_search\Form\FieldForm');
        $hotels = \Drupal::service('city_search.db_logic')->getHotelByLocation($slug);

        $page = array(
            '#title' => 'City Search by ' . $slug,
            '#theme' => 'city_search__search',
            '#name' => 'Hello',
            '#form' => $form,
            '#list' => $hotels,
        );

        return $page;
    }

    /**
     * Create node page.
     * @return array
     */
    public function createNode() {
        $form = \Drupal::formBuilder()->getForm('Drupal\city_search\Form\CreateHotelNodeForm');

        $page = array(
            '#title' => 'Create Node',
            '#theme' => 'city_search_create',
            '#name' => 'Create Node',
            '#form' => $form,
        );

        return $page;
    }

    /**
     * Page for Ajax requests.
     * @return JsonResponse
     */
    public function ajax() {
        $request = Request::createFromGlobals();
        $postValue = $request->request->get('message');
        $DbRequest = new CitySearchAjax();
        $list = $DbRequest->getCities($postValue);

        return new JsonResponse(array(
//            'item' => $cities,
            //'dump' => var_dump($cities),
            //'test_dump' => var_dump($arr),
            'list' => $list,
        ));

    }

    public function taxonomy() {
        $form = \Drupal::formBuilder()->getForm('Drupal\city_search\Form\Taxonomy');
        $name = \Drupal::currentUser()->getDisplayName();
        $list = \Drupal\taxonomy\Entity\Vocabulary::loadMultiple();

        $page = array(
            '#title' => 'Taxonomy Create',
            '#theme' => 'city_search__taxonomy',
            '#name' => $name,
            '#form' => $form,
            '#list' =>$list,
        );

        return $page;
    }
}
