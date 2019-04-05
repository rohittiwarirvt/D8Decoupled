<?php

namespace Drupal\rt_block\Utility;


use Drupal\Core\Database\Connection;
use Drupal\Core\Messenger\MessengerInterface;
use Drupal\Core\Messenger\MessengerTrait;
use Drupal\Core\StringTranslation\StringTranslationTrait;
use Drupal\Core\StringTranslation\TranslationInterface;



class DbtngExampleRepository {

  use MessengerTrait;
  use StringTranslationTrait;


  protected $connection;

  public function __construct(Connection $connection, TranslationInterface $translation, MessengerInterface $messenger) {
    $this->connection = $connection;
    $this->setStringTranslation($translation);
    $this->setMessenger($messenger);
  }


  public function load(array $entry = []) {
    $select = $this->connection
      ->select('dbtng_example')
      ->fields('dbtng_example');

      foreach ($entry as $field => $value) {
        $select->condition($field, $value);
      }

    return $select->execute()->fetchAll();
  }


  public function insert(array $entry) {
    $return_value = NULL;

    try {
      $return_value = $this->connection->insert('dbtng_example')
        ->fields($entry)
        ->execute();
    }
    catch( Exception $e) {
      $this->messenger()->addMessage(t('db_insert failed. Message = %message', ['%message' => $e->getMessage()], 'error'));
    }

    return $return_value;
  }

  public function update(array $entry) {
    try {
      // Connection->update()...->execute() returns the number of rows updated.
      $count = $this->connection->update('dbtng_example')
        ->fields($entry)
        ->condition('pid', $entry['pid'])
        ->execute();
    }
    catch (\Exception $e) {
      $this->messenger()->addMessage(t('db_update failed. Message = %message, query= %query', [
        '%message' => $e->getMessage(),
        '%query' => $e->query_string,
      ]
      ), 'error');
    }
    return $count;
  }


  public function advancedLoad() {
    $select = $this->connection->select('dbtng_example', 'e');
    $select->join('users_field_data', 'u', 'e.uid = u.uid');

    $select->addField('e', 'pid');
    $select->addField('u','name','username');
    $select->addField('e', 'name');
    $select->addField('e', 'surname');
    $select->addField('e', 'age');

    $select->condition('e.name', 'John');
    $select->condition('e.age', 18, '>');
    $select->range(0, 50);

    $entries = $select->execute()->fetchAll(\PDO::FETCH_ASSOC);

    return $entries;

  }
}
