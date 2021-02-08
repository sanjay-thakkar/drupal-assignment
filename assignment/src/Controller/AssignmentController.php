<?php

namespace Drupal\assignment\Controller;
use Drupal\node\Entity\Node;

/**
 * Implementing JSON render functionality.
 */
class AssignmentController {

  public function renderApi() {
    // Node load from the argument of url and fetch the node type
    $current_path = \Drupal::service('path.current')->getPath();
    $path_args = explode('/', $current_path);
    $nid = $path_args[2];

    if (!is_numeric($nid)) {
      return drupal_set_message(t('Node id is not valid.'), 'error');
    } else {
      $node = Node::load($nid);
      if ($node) {
        // Fetch the status of node.
        $nodeIsPublished = $node->isPublished();
        // Fetch the content type of node.
        $type = $node->getType();
        // Get site api key from the site configuration page
        $site_api = \Drupal::config('siteapikey.configuration')->get('siteapikey');

        // Validation Criteria.
        if (!isset($site_api)) {
          // Redirect to access denied page if site api key is not set.
          throw new \Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException();
        } elseif (!$nodeIsPublished) {
          // Error message if not is not published.
          return drupal_set_message(t('This node is not published.'), 'error');
        } elseif ($type != 'page') {
          // Redirect to access denied page if node type is not page.
          throw new \Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException();
        }
      } else {
        // Error message for node is valid or not.
        return drupal_set_message(t('Node with give node id is not exists.'), 'error');
      }

      // Node data in json format using serialization services.
      $serializer = \Drupal::service('serializer');
      $data = $serializer->serialize($node, 'json', ['plugin_id' => 'entity']);

      // Render the 'assignment' theme.
      return array(
        '#theme' => 'assignment',
        '#items' => $data,
      );
    }
  }
}
