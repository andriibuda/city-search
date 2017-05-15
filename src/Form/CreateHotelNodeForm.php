<?php

namespace Drupal\city_search\Form;

use Drupal\Core\Form\FormBase;
use Drupal\Core\Form\FormStateInterface;
use Drupal\Core\Url;
use \Symfony\Component\HttpFoundation\RedirectResponse;

class CreateHotelNodeForm extends FormBase
{
    /**
     * {@inheritdoc}
     */
    public function getFormId()
    {
        return 'create_hotel_node_form';
    }

    /**
     * @param array $form
     * @param FormStateInterface $form_state
     * @return array
     */
    /**
     * @param array $form
     * @param FormStateInterface $form_state
     * @return array
     */
    public function buildForm(array $form, FormStateInterface $form_state)
    {
        $form['hotel_title'] = array(
            '#type' => 'textfield',
            '#title' => $this->t('Name of Hotel'),
            '#required' => TRUE,
        );

        $form['hotel_image'] = array(
            '#type' => 'managed_file',
            '#title' => $this->t('Upload image'),
            '#upload_validators' => array(
                'file_validate_extensions' => array('gif png jpg jpeg'),
                'file_validate_size' => array(25600000),
            ),
            '#upload_location' => 'public://images/',
            '#required' => TRUE,
        );

        $form['hotel_descr'] = array(
            '#type' => 'textarea',
            '#title' => $this->t('Some additional description about Hotel'),
            '#required' => TRUE,
        );

        $form['hotel_location'] = array(
            '#type' => 'textfield',
            '#title' => $this->t('Location'),
            '#required' => TRUE,
        );

        $form['submit'] = array(
            '#type' => 'submit',
            '#value' => $this->t('Create'),
        );

        return $form;
    }

    /**
     * @param array $form
     * @param FormStateInterface $form_state
     */
    public function submitForm(array &$form, FormStateInterface $form_state)
    {
        $language = \Drupal::languageManager()->getCurrentLanguage()->getId();
        $uid = \Drupal::currentUser()->id();

        $title = $form_state->getValue(array('hotel_title'));
        $image = $form_state->getValue(array('hotel_image'));
        $body = array($form_state->getValue(array('hotel_descr')));
        $date = date('Y-m-d');
        $hotel_location_input = $form_state->getValue(array('hotel_location'));
        $arr = explode(',', $hotel_location_input);
        $location = $arr[0];

        $vocabularies = \Drupal\taxonomy\Entity\Vocabulary::loadMultiple();

        $checkTerm = \Drupal::service('city_search.db_logic')->checkTermByName($location);

        if (!$checkTerm) {
            $term = \Drupal\taxonomy\Entity\Term::create([
                'vid' => 'locations',
                'name' => $location,
            ]);
            $term->save();
            $tid = \Drupal::service('city_search.db_logic')->getLastTermId();
        } else {
            $tid = $checkTerm['tid'];
        }



        $node = \Drupal\node\Entity\Node::create(array(
            'type' => 'hotel',
            'title' => $title,
            'langcode' => $language,
            'uid' => $uid,
            'status' => 1,
            'body' => $body,
            'field_image' => $image,
            'field_location'  => [
                ['target_id' => $tid]
            ],
            'field_date' => $date,
        ));

        $node->save();

        $nid = \Drupal::service('city_search.db_logic')->getMaxHotelNodeId();
        $url = Url::fromRoute('entity.node.canonical', ['node' => $nid]);
        $form_state->setResponse(new RedirectResponse($url->toString()));
    }
}

