<?php
/**
 * Created by PhpStorm.
 * User: nickgeleedst
 * Date: 13/03/2018
 * Time: 12:42
 */

namespace Drupal\bluebirdday_jms;

use JMS\Serializer\SerializationContext;
use JMS\Serializer\SerializerBuilder;
use Doctrine\Common\Annotations\AnnotationRegistry;

/**
 * Serializer wrapper class.
 */
class Serializer {

  protected $serializer;

  /**
   * Create our JMS serializer.
   */
  public function __construct() {
    AnnotationRegistry::registerLoader('class_exists');
    $this->serializer = SerializerBuilder::create()
     ->setSerializationContextFactory(function () {
       return SerializationContext::create()->setSerializeNull(TRUE);
     })->build();
  }

  /**
   * Serialize the given data to a specific format.
   *
   * @param mixed $data
   *   Original data.
   * @param string $format
   *   The format we want to serialize to.
   *
   * @return mixed
   *   Serialized data
   */
  public function serialize($data, string $format = 'json') {
    return $this->serializer->serialize($data, $format);
  }

  /**
   * Deserialze the data.
   *
   * @param mixed $data
   *   Original serialized data.
   * @param mixed $type
   *   Class to deserialize to.
   * @param string $format
   *   The format the data is in.
   *
   * @return mixed
   *   Returns the deserialized data
   */
  public function deserialize($data, $type, string $format = 'json') {
    if (is_object($data)) {
      $data = json_encode($data);
    }
    return $this->serializer->deserialize($data, $type, $format);
  }

  /**
   * Convert data to array.
   *
   * @param mixed $data
   *   Data to be converted to array.
   *
   * @return array|mixed
   *   The data as an array.
   */
  public function toArray($data) {
    return $this->serializer->toArray($data);
  }

}