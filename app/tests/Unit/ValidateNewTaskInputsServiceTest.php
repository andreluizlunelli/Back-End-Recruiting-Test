<?php

namespace Tests\Unit;

use App\Services\ValidateNewTaskInputsService;
use Tests\TestCase;

class ValidateNewTaskInputsServiceTest extends TestCase
{
    /**
     * @var ValidateNewTaskInputsService
     */
    private $service;

    protected function setUp(): void
    {
        parent::setUp();

        $this->service = new ValidateNewTaskInputsService();
    }

    public function testValidateInputsCorrect()
    {
        $inputs = [
            'title' => 'my title',
            'description' => 'my description',
            'type' => 'work',
            'priority' => 0,
        ];

        self::assertTrue($this->service->validate($inputs));

        $inputs = [
            'title' => 'my title',
            'description' => 'my description',
            'type' => 'shopping',
            'priority' => 0,
        ];

        self::assertTrue($this->service->validate($inputs));
    }

    public function testValidateInputsWithoutTitle()
    {
        $inputs = [
            'description' => 'my description',
            'type' => 'shopping',
            'priority' => 0,
        ];

        self::expectException(\InvalidArgumentException::class);
        self::expectErrorMessage('The title field is required.');

        $this->service->validate($inputs);
    }

    public function testValidateTypeOfTask()
    {
        $inputs = [
            'description' => 'my description',
            'type' => 'test',
            'priority' => 0,
        ];

        self::expectException(\InvalidArgumentException::class);
        self::expectErrorMessage('The title field is required., The task type you provided is not supported. You can only use shopping or work.');

        $this->service->validate($inputs);
    }

    public function testValidateEmpyRequest()
    {
        $inputs = [];

        self::expectException(\InvalidArgumentException::class);
        self::expectErrorMessage('Try sending these parameters here: [title => string, description => string, type => work|shopping, priority => int]');

        $this->service->validate($inputs);
    }

    public function testValidateInputsWithoutType()
    {
        $inputs = [
            'description' => 'my description',
            'priority' => 0,
        ];

        self::expectException(\InvalidArgumentException::class);
        self::expectErrorMessage('The type field is required.');

        $this->service->validate($inputs);
    }

}
