<?php

namespace ConceptIt\OrientDbBundle\Services;

use Doctrine\OrientDB\Binding\HttpBinding;
use Doctrine\ODM\OrientDB\Mapper;
use Doctrine\ODM\OrientDB as ODM;
use Doctrine\ODM\OrientDB\Manager;

class OrientDbService
{
	protected $binding;
	protected $mapper;
	protected $manager;

	public function __construct(Mapper $mapper, HttpBinding $binding, Manager $manager)
	{
		$this->mapper = $mapper;
		$this->binding = $binding;
		$this->manager = $manager;
	}

	public function getBinding()
	{
		return $this->binding;
	}

	protected function getMapper()
	{
		return $this->mapper;
	}

	public function getManager()
	{
		return $this->manager;
	}

	public function getRepository($name)
	{
		return $this->getManager()->getRepository($name);
	}

	public function persist($object)
	{
		$json = $this->toJson($object);
    if ($this->checkExists($object) === false) {
      $response = $this->getBinding()->postDocument($json);
      $rid = $response->getData();
      $object->setRid($rid);
    } else {
      $response = $this->getBinding()->putDocument($object->getRid(), $json);
      $result = $response->getData();
    }

    return $object;
	}

	/**
   *
   * @param \stdClass $object
   */
  public function remove($object)
  {
  	if ($this->checkExists($object) === false) {
      return false;
    }
    $response = $this->getBinding()->deleteDocument($object->getRid());
    $result = $response->getData();
    $object->setRid(null);

    return $result;
  }

  public function flush()
  {
  	return;
  }

	protected function toJson($object)
  {
        $data = (array) $object;
        foreach ($data as $key => $value) {
            $newKey = preg_replace('/[^a-z]/i', null, $key);
            if (is_string($value)) {
                $data[$newKey] = str_replace('%', 'pr.', $value);
            } else {
                $data[$newKey] = $value;
            }
            unset($data[$key]);
            if ($value instanceof \Doctrine\ODM\OrientDB\Proxy\Value) {
                $object = $value->__invoke();
                $data[$newKey] = $object->getRid();
            } elseif ($value instanceof \DateTime) {
                $data[$newKey] = $value->format('Y-m-d H:i:s');
            }
        }
        $data['@class'] = join('', array_slice(explode('\\', get_class($object)), -1));
        if(array_key_exists('rid', $data)){
            unset($data['rid']);
        }
        if(array_key_exists('version', $data)){
            $data['@version'] = $data['version'];
            unset($data['version']);
        }

        return json_encode($data);
  }

  protected function checkExists($object)
  {
        $rid = $object->getRid();
        if (empty($rid)) {
            return false;
        }

        return true;
  }




}
