<?php
/**
 * MolecularLocation
 *
 * PHP version 5
 *
 * @category Class
 * @package  Lumminary\Client
 * @author   Swagger Codegen team
 * @link     https://github.com/swagger-api/swagger-codegen
 */

/**
 * Lumminary API
 *
 * A general-purpose API for accessing genomic data
 *
 * OpenAPI spec version: 1.0
 * 
 * Generated by: https://github.com/swagger-api/swagger-codegen.git
 * Swagger Codegen version: 2.3.1
 */

/**
 * NOTE: This class is auto generated by the swagger code generator program.
 * https://github.com/swagger-api/swagger-codegen
 * Do not edit the class manually.
 */

namespace Lumminary\Client\Models;

use \ArrayAccess;
use \Lumminary\Client\ObjectSerializer;

/**
 * MolecularLocation Class Doc Comment
 *
 * @category Class
 * @package  Lumminary\Client
 * @author   Swagger Codegen team
 * @link     https://github.com/swagger-api/swagger-codegen
 */
class MolecularLocation implements ModelInterface, ArrayAccess
{
    const DISCRIMINATOR = null;

    /**
      * The original name of the model.
      *
      * @var string
      */
    protected static $swaggerModelName = 'MolecularLocation';

    /**
      * Array of property to type mappings. Used for (de)serialization
      *
      * @var string[]
      */
    protected static $swaggerTypes = [
        'start' => 'int',
        'stop' => 'int',
        'chromosomeAccession' => 'string'
    ];

    /**
      * Array of property to format mappings. Used for (de)serialization
      *
      * @var string[]
      */
    protected static $swaggerFormats = [
        'start' => null,
        'stop' => null,
        'chromosomeAccession' => null
    ];

    /**
     * Array of property to type mappings. Used for (de)serialization
     *
     * @return array
     */
    public static function swaggerTypes()
    {
        return self::$swaggerTypes;
    }

    /**
     * Array of property to format mappings. Used for (de)serialization
     *
     * @return array
     */
    public static function swaggerFormats()
    {
        return self::$swaggerFormats;
    }

    /**
     * Array of attributes where the key is the local name,
     * and the value is the original name
     *
     * @var string[]
     */
    protected static $attributeMap = [
        'start' => 'start',
        'stop' => 'stop',
        'chromosomeAccession' => 'chromosome_accession'
    ];

    /**
     * Array of attributes to setter functions (for deserialization of responses)
     *
     * @var string[]
     */
    protected static $setters = [
        'start' => 'setStart',
        'stop' => 'setStop',
        'chromosomeAccession' => 'setChromosomeAccession'
    ];

    /**
     * Array of attributes to getter functions (for serialization of requests)
     *
     * @var string[]
     */
    protected static $getters = [
        'start' => 'getStart',
        'stop' => 'getStop',
        'chromosomeAccession' => 'getChromosomeAccession'
    ];

    /**
     * Array of attributes where the key is the local name,
     * and the value is the original name
     *
     * @return array
     */
    public static function attributeMap()
    {
        return self::$attributeMap;
    }

    /**
     * Array of attributes to setter functions (for deserialization of responses)
     *
     * @return array
     */
    public static function setters()
    {
        return self::$setters;
    }

    /**
     * Array of attributes to getter functions (for serialization of requests)
     *
     * @return array
     */
    public static function getters()
    {
        return self::$getters;
    }

    /**
     * The original name of the model.
     *
     * @return string
     */
    public function getModelName()
    {
        return self::$swaggerModelName;
    }

    

    

    /**
     * Associative array for storing property values
     *
     * @var mixed[]
     */
    protected $container = [];

    /**
     * Constructor
     *
     * @param mixed[] $data Associated array of property values
     *                      initializing the model
     */
    public function __construct(array $data = null)
    {
        $this->container['start'] = isset($data['start']) ? $data['start'] : null;
        $this->container['stop'] = isset($data['stop']) ? $data['stop'] : null;
        $this->container['chromosomeAccession'] = isset($data['chromosomeAccession']) ? $data['chromosomeAccession'] : null;
    }

    /**
     * Show all the invalid properties with reasons.
     *
     * @return array invalid properties with reasons
     */
    public function listInvalidProperties()
    {
        $invalidProperties = [];

        if ($this->container['start'] === null) {
            $invalidProperties[] = "'start' can't be null";
        }
        if (($this->container['start'] < 0)) {
            $invalidProperties[] = "invalid value for 'start', must be bigger than or equal to 0.";
        }

        if ($this->container['stop'] === null) {
            $invalidProperties[] = "'stop' can't be null";
        }
        if (($this->container['stop'] < 0)) {
            $invalidProperties[] = "invalid value for 'stop', must be bigger than or equal to 0.";
        }

        if ($this->container['chromosomeAccession'] === null) {
            $invalidProperties[] = "'chromosomeAccession' can't be null";
        }
        if ((strlen($this->container['chromosomeAccession']) < 1)) {
            $invalidProperties[] = "invalid value for 'chromosomeAccession', the character length must be bigger than or equal to 1.";
        }

        return $invalidProperties;
    }

    /**
     * Validate all the properties in the model
     * return true if all passed
     *
     * @return bool True if all properties are valid
     */
    public function valid()
    {

        if ($this->container['start'] === null) {
            return false;
        }
        if ($this->container['start'] < 0) {
            return false;
        }
        if ($this->container['stop'] === null) {
            return false;
        }
        if ($this->container['stop'] < 0) {
            return false;
        }
        if ($this->container['chromosomeAccession'] === null) {
            return false;
        }
        if (strlen($this->container['chromosomeAccession']) < 1) {
            return false;
        }
        return true;
    }


    /**
     * Gets start
     *
     * @return int
     */
    public function getStart()
    {
        return $this->container['start'];
    }

    /**
     * Sets start
     *
     * @param int $start The gene's start position on the scaffold
     *
     * @return $this
     */
    public function setStart($start)
    {

        if (($start < 0)) {
            throw new \InvalidArgumentException('invalid value for $start when calling MolecularLocation., must be bigger than or equal to 0.');
        }

        $this->container['start'] = $start;

        return $this;
    }

    /**
     * Gets stop
     *
     * @return int
     */
    public function getStop()
    {
        return $this->container['stop'];
    }

    /**
     * Sets stop
     *
     * @param int $stop The gene's stop position on the scaffold
     *
     * @return $this
     */
    public function setStop($stop)
    {

        if (($stop < 0)) {
            throw new \InvalidArgumentException('invalid value for $stop when calling MolecularLocation., must be bigger than or equal to 0.');
        }

        $this->container['stop'] = $stop;

        return $this;
    }

    /**
     * Gets chromosomeAccession
     *
     * @return string
     */
    public function getChromosomeAccession()
    {
        return $this->container['chromosomeAccession'];
    }

    /**
     * Sets chromosomeAccession
     *
     * @param string $chromosomeAccession The cromosome on which the gene is placed
     *
     * @return $this
     */
    public function setChromosomeAccession($chromosomeAccession)
    {

        if ((strlen($chromosomeAccession) < 1)) {
            throw new \InvalidArgumentException('invalid length for $chromosomeAccession when calling MolecularLocation., must be bigger than or equal to 1.');
        }

        $this->container['chromosomeAccession'] = $chromosomeAccession;

        return $this;
    }
    /**
     * Returns true if offset exists. False otherwise.
     *
     * @param integer $offset Offset
     *
     * @return boolean
     */
    public function offsetExists($offset)
    {
        return isset($this->container[$offset]);
    }

    /**
     * Gets offset.
     *
     * @param integer $offset Offset
     *
     * @return mixed
     */
    public function offsetGet($offset)
    {
        return isset($this->container[$offset]) ? $this->container[$offset] : null;
    }

    /**
     * Sets value based on offset.
     *
     * @param integer $offset Offset
     * @param mixed   $value  Value to be set
     *
     * @return void
     */
    public function offsetSet($offset, $value)
    {
        if (is_null($offset)) {
            $this->container[] = $value;
        } else {
            $this->container[$offset] = $value;
        }
    }

    /**
     * Unsets offset.
     *
     * @param integer $offset Offset
     *
     * @return void
     */
    public function offsetUnset($offset)
    {
        unset($this->container[$offset]);
    }

    /**
     * Gets the string presentation of the object
     *
     * @return string
     */
    public function __toString()
    {
        if (defined('JSON_PRETTY_PRINT')) { // use JSON pretty print
            return json_encode(
                ObjectSerializer::sanitizeForSerialization($this),
                JSON_PRETTY_PRINT
            );
        }

        return json_encode(ObjectSerializer::sanitizeForSerialization($this));
    }
}

