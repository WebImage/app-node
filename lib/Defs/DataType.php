<?php

namespace WebImage\Node\Defs;

use Exception;

/**
 * Represents a data types
 *
 * Class DataType
 * @package WebImage\Node\Defs
 */
class DataType {
	const OBJECT_TYPE_SIMPLE = 'type-simple';
	const OBJECT_TYPE_COMPLEX = 'type-complex';

	private $type;
	private $name; /* Friendly Name */
	private $phpType;
	private $phpClassName;
	/** @var DataTypeModelField[] */
	private $modelFields = [];
	/**
	 * @property string a class name that can be looked up against the CNodeTypeService (or extensibly the DictionaryService)
	 **/
	private $defaultInputElementClass;

	function __construct($type, $name, $object_type, $php_type_or_class_name, $input_element_class_name=null)
	{
		$this->setType($type);
		$this->setName($name);

		$this->defaultInputElementClass = $input_element_class_name;

		if ($object_type == self::OBJECT_TYPE_SIMPLE) {

			$this->setPhpType($php_type_or_class_name);

		} else if ($object_type == self::OBJECT_TYPE_COMPLEX) {

			$this->setPhpClass($php_type_or_class_name);

		} else {
			throw new Exception('Invalid object type.  Passed value was ' . $object_type . '.  Expecting ' . self::OBJECT_TYPE_SIMPLE . ' or ' . self::OBJECT_TYPE_COMPLEX);
		}
	}

	public function getType() { return $this->type; }
	public function getName() { return $this->name; }
	public function getPhpType() { return $this->phpType; }
	public function getPhpClassName() { return $this->phpClassName; }
	public function getPhpClassFile() { return $this->phpClassFile; }
	public function getModelFields() { return $this->modelFields; }
	public function getDefaultInputElementClass() { return $this->defaultInputElementClass; }
	/**
	 * Returns whether the PHP variable that represents this object is a simple type (i.e. string, int, boolean, etc.), or whether this type needs to be represented by a more complext type/class.  If $this->phpType is empty then assume it is a complex type
	 **/
	public function isSimplePhpType()
	{
		$php_type = $this->getPhpType();
		if (empty($php_type)) return false;
		else return true;
	}

	public function setType($type)
	{
		$this->type = $type;
	}

	public function setName($name)
	{
		$this->name = $name;
	}

	public function setPhpType($type)
	{
		$this->phpType = $type;
	}

	public function setDefaultInputElementClass()
	{
		return $this->defaultInputElementClass;
	}

	public function setPhpClass($php_class_name)
	{
		$this->setPhpClassName($php_class_name);
	}

	private function setPhpClassName($php_class_name)
	{
		$this->phpClassName = $php_class_name;
	}

	public function addModelField(DataTypeModelField $model_field)
	{
		$this->modelFields[] = $model_field;
	}

	/**
	 * Whether or not this data type contains a simple single-column storage field (which must not have a name)
	 *
	 * @return bool
	 */
	public function isSimpleStorage()
	{
		return (count($this->modelFields) == 1 && strlen($this->modelFields[0]->getName()) == 0);
	}
}