<?php

namespace Kerox\Messenger\Test\TestCase\Model;

use Kerox\Messenger\Model\Persona;
use Kerox\Messenger\Test\TestCase\AbstractTestCase;

class PersonaTest extends AbstractTestCase
{
    public function testConstructor()
    {
        $data = [
            'id' => $this->randomIntegerString(),
            'name' => 'John Doe',
            'profile_picture_url' => 'https://unsplash.com/post/51492538696/download-by-alejandro-escamilla',
            'unexpected_field' => true,
        ];

        $model = new Persona($data);

        $this->assertAttributeEquals($data['id'], 'id', $model);
        $this->assertAttributeEquals($data['name'], 'name', $model);
        $this->assertAttributeEquals($data['profile_picture_url'], 'profile_picture_url', $model);
    }

    public function testSetId()
    {
        $id = $this->randomIntegerString();

        $model = new Persona();
        $this->assertAttributeEquals(null, 'id', $model);

        $model->setId($id);
        $this->assertAttributeEquals($id, 'id', $model);
    }

    public function testSetName()
    {
        $name = 'John Doe';

        $model = new Persona();
        $this->assertAttributeEquals(null, 'name', $model);

        $model->setName($name);
        $this->assertAttributeEquals($name, 'name', $model);
    }

    public function testSetProfilePictureUrl()
    {
        $url = 'https://unsplash.com/post/51492538696/download-by-alejandro-escamilla';

        $model = new Persona();
        $this->assertAttributeEquals(null, 'profile_picture_url', $model);

        $model->setProfilePictureUrl($url);
        $this->assertAttributeEquals($url, 'profile_picture_url', $model);
    }

    public function testGetId()
    {
        $data = [
            'id' => $this->randomIntegerString(),
        ];

        $model = new Persona($data);

        $this->assertEquals($data['id'], $model->getId());
    }

    public function testGetName()
    {
        $data = [
            'name' => 'John Doe',
        ];

        $model = new Persona($data);

        $this->assertEquals($data['name'], $model->getName());
    }

    public function testGetProfilePictureUrl()
    {
        $data = [
            'profile_picture_url' => 'https://unsplash.com/post/51492538696/download-by-alejandro-escamilla',
        ];

        $model = new Persona($data);

        $this->assertEquals($data['profile_picture_url'], $model->getProfilePictureUrl());
    }

    public function testToArray()
    {
        $id = $this->randomIntegerString();
        $data = [
            'id' => $id,
            'name' => 'John Doe',
            'profile_picture_url' => '',
        ];
        $expected = [
            'id' => $id,
            'name' => 'John Doe',
        ];

        $model = new Persona($data);

        $this->assertEquals($expected, $model->toArray());
    }

    public function testJsonSerialize()
    {
        $data = [
            'id' => $this->randomIntegerString(),
            'name' => 'John Doe',
            'profile_picture_url' => '',
        ];

        $model = new Persona($data);
        $result = json_encode($model);

        $this->assertEquals('{"id":"' . $data['id'] . '","name":"John Doe"}', $result);
    }
}
