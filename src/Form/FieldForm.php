<?php

namespace Drupal\city_search\Form;

use Drupal\Core\Ajax\InvokeCommand;
use Drupal\Core\Ajax\RedirectCommand;
use Drupal\Core\Ajax\RestripeCommand;
use Drupal\Core\Form\FormBase;
use Drupal\Core\Form\FormStateInterface;
use \Symfony\Component\HttpFoundation\RedirectResponse;
use Drupal\Core\Url;

use Drupal\Core\Ajax\AjaxResponse;
use Drupal\Core\Ajax\HtmlCommand;

class FieldForm extends FormBase
{
    /**
     * {@inheritdoc}
     */
    public function getFormId()
    {
        return 'field_form';
    }

    /**
     * @param array $form
     * @param FormStateInterface $form_state
     * @return array
     */
    public function buildForm(array $form, FormStateInterface $form_state)
    {
        $form['search_country'] = array(
            '#type' => 'textfield',
            '#title' => $this->t('Search City'),
            '#placeholder' => $this->t('Search here...'),
            '#required' => TRUE,
        );

        $form['submit'] = array(
            '#type' => 'submit',
            '#value' => $this->t('Search'),
        );

        return $form;
    }

    public function ajaxGetCities(array &$form, FormStateInterface $form_state) {
        $ajax_response = new AjaxResponse();

        $ajax_response->addCommand(new InvokeCommand(NULL, 'ajax', /*[$form_state->getValue('latitude'),  $form_state->getValue('longitude')] */ array() ));

        return $ajax_response;

    }

    public function submitForm(array &$form, FormStateInterface $form_state)
    {
        $input = $form_state->getValue(array('search_country'));
        $arr = explode(',', $input);
        $location = $arr[0];

        $url = Url::fromRoute('city_search.search', ['slug' => $location]);
        $form_state->setResponse(new RedirectResponse($url->toString()));
    }
}
