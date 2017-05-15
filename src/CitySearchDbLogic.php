<?php

namespace Drupal\city_search;

use Drupal\Core\Database\Connection;

/**
 * This is used to build query access.
 *
 * @ingroup city_search
 */
class CitySearchDbLogic {
    /**
     * Database Connection.
     *
     * @var \Drupal\Core\Database\Connection
     */
    protected $database;

    /**
     * Construct object
     */
    public function __construct(Connection $database)
    {
        $this->database = $database;
    }

    /**
     * Add new record
     */
    public function add($latitude, $longitude)
    {
        if (empty($latitude) || empty($longitude)) {
            return false;
        }
        $query = $this->database->insert('ajase');
        $query->fields(array(
            'latitude' => $latitude,
            'longitude' => $longitude,
        ));
        return $query->execute();
    }

    /**
     * Get records from database by Name
     */
    public function getByName($name = NULL, $reset = FALSE)
    {
        if (strlen(trim($name, " ")) > 0) {
            $query = $this->database->select('location');
            $query->fields('location', array(/*'id', */'country', 'city'));
            if ($name) {
                $query->condition('city', $this->database->escapeLike($name) . "%", 'LIKE');
            }
            $result = $query->execute()->fetchAll();
            if (count($result)) {
                if ($reset) {
                    $result = reset($result);
                }
                return $result;
            }
            return 'Not Found';
        } else {
            return 'Not valid input';
        }
    }

    /**
     * Get all records for database
     */
    public function getAll()
    {
        return $this->getById();
    }

    /**
     * Get Last Hotel Node Id.
     */
    public function getMaxHotelNodeId() {
        $query = $this->database->select('node');
        $query->addExpression('MAX(nid)');
        $max= $query->execute()->fetchField();
        return $max;
    }

    /**
     * Get Last Term Id.
     */
    public function getLastTermId() {
        $query = $this->database->select('taxonomy_term_data');
        $query->addExpression('MAX(tid)');
        $max = $query->execute()->fetchField();
        return $max;
    }

    public function checkTermByName($name) {
        $query = $this->database->select('taxonomy_term_field_data');
        $query->fields('taxonomy_term_field_data', array('tid', 'vid','name'));
        $query->condition('name', $name);
        $query->condition('vid', 'locations');
        $term = $query->execute()->fetchAll();
        $name = $term[0]->name;
        if ($name != '') {
            return array(
                'name' => $term[0]->name,
                'tid' => $term[0]->tid,
            );
        } else {
            return FALSE;
        }
    }

    /**
     * @param null $location
     * @return mixed
     */
    public function getHotelByLocation($location = NULL) {
        $entityFieldQuery = \Drupal::service('entity.query');
        if ($location == NULL) {
            $nids = $entityFieldQuery->get('node')
                ->condition('type', 'hotel')
                ->condition('status', 1)
                ->execute();
        } else {
            $nids = $entityFieldQuery->get('node')
                ->condition('type', 'hotel')
                ->condition('status', 1)
                ->condition('field_location.entity.name', $location)
                ->execute();
        }



//        $nids = $entityFieldQuery->execute();
        if (count($nids) == 0) {
            return 'Sorry, we can\'t found anything...';
        }

        $nodes =  \Drupal\node\Entity\Node::loadMultiple($nids);
        $view_builder = \Drupal::entityTypeManager()->getViewBuilder('node');
        $build = $view_builder->viewMultiple($nodes, 'teaser');
        return $build;
    }
}