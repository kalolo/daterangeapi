<?php

use PHPUnit\Framework\TestCase;
use App\Entities\DateRangeEntity;
use App\DateRangeHelper;

final class DateRangeTest extends TestCase
{

    public function testEntityBuild()
    {
        $entity = DateRangeEntity::build(['id' => 1, 'start' => 1, 'end' => 4, 'price' => 8]);
        $entity2 = DateRangeEntity::build((object)['id' => 1, 'start' => 1, 'end' => 4, 'price' => 8]);

        $this->assertIsObject($entity);
        $this->assertEquals(8, $entity->getPrice());
        $this->assertEquals(4, $entity->getEnd());
        $this->assertEquals(1, $entity->getStart());
        $this->assertEquals($entity->getId(), $entity2->getId());
    }

    public function testMerge()
    {
        $input = [
            DateRangeEntity::build(['start' => 1, 'end' => 4, 'price' => 8]),
            DateRangeEntity::build(['start' => 2, 'end' => 10, 'price' => 8]),
        ];

        $output = DateRangeHelper::merge($input, DateRangeEntity::build(['start' => 15, 'end' => 20, 'price' => 18]));

        $this->assertEquals([
            ['id' => null, 'start' => 1, 'end' => 10, 'price' => 8],
            ['id' => null, 'start' => 15, 'end' => 20, 'price' => 18],
        ], $output);
    }

    public function testExample1()
    {
        $step1Input = [];

        $this->assertEquals([
            ['id' => null, 'start' => 1, 'end' => 10, 'price' => 15]
        ], DateRangeHelper::merge([], DateRangeEntity::build(['start' => 1, 'end' => 10, 'price' => 15])));

        $step2Input = [
            DateRangeEntity::build(['start' => 1, 'end' => 10, 'price' => 15])
        ];

        $this->assertEquals([
            ['id' => null, 'start' => 1, 'end' => 20, 'price' => 15]
        ], DateRangeHelper::merge($step2Input, DateRangeEntity::build(['start' => 5, 'end' => 20, 'price' => 15])));

        $step3Input = [
            DateRangeEntity::build(['start' => 1, 'end' => 20, 'price' => 15])
        ];

        $this->assertEquals([
            ['id' => null, 'start' => 1, 'end' => 1, 'price' => 15],
            ['id' => null, 'start' => 2, 'end' => 8, 'price' => 45],
            ['id' => null, 'start' => 9, 'end' => 20, 'price' => 15],
        ], DateRangeHelper::merge($step3Input, DateRangeEntity::build(['start' => 2, 'end' => 8, 'price' => 45])));

        $step4Input = [
            DateRangeEntity::build(['start' => 1, 'end' => 1, 'price' => 15]),
            DateRangeEntity::build(['start' => 2, 'end' => 8, 'price' => 45]),
            DateRangeEntity::build(['start' => 9, 'end' => 20, 'price' => 15])
        ];

        $this->assertEquals([
            ['id' => null, 'start' => 1, 'end' => 1, 'price' => 15],
            ['id' => null, 'start' => 2, 'end' => 10, 'price' => 45],
            ['id' => null, 'start' => 11, 'end' => 20, 'price' => 15],
        ], DateRangeHelper::merge($step4Input, DateRangeEntity::build(['start' => 9, 'end' => 10, 'price' => 45])));
    }

    public function testExample2()
    {
        $this->assertEquals([
            ['id' => null, 'start' => 1, 'end' => 5, 'price' => 15]
        ], DateRangeHelper::merge([], DateRangeEntity::build(['start' => 1, 'end' => 5, 'price' => 15])));

        $step2Input = [
            DateRangeEntity::build(['start' => 1, 'end' => 5, 'price' => 15])
        ];

        $this->assertEquals([
            ['id' => null, 'start' => 1, 'end' => 5, 'price' => 15],
            ['id' => null, 'start' => 20, 'end' => 25, 'price' => 15],
        ], DateRangeHelper::merge($step2Input, DateRangeEntity::build(['start' => 20, 'end' => 25, 'price' => 15])));


        $step3Input = [
            DateRangeEntity::build(['start' => 1, 'end' => 5, 'price' => 15]),
            DateRangeEntity::build(['start' => 20, 'end' => 25, 'price' => 15])
        ];

        $this->assertEquals([
            ['id' => null, 'start' => 1, 'end' => 3, 'price' => 15],
            ['id' => null, 'start' => 4, 'end' => 21, 'price' => 45],
            ['id' => null, 'start' => 22, 'end' => 25, 'price' => 15],
        ], DateRangeHelper::merge(
            $step3Input,
            DateRangeEntity::build(['start' => 4, 'end' => 21, 'price' => 45])
        ));

        $step4Input = [
            DateRangeEntity::build(['start' => 1, 'end' => 3, 'price' => 15]),
            DateRangeEntity::build(['start' => 4, 'end' => 21, 'price' => 45]),
            DateRangeEntity::build(['start' => 22, 'end' => 25, 'price' => 15])
        ];

        $this->assertEquals(
            [
                ['id' => null, 'start' => 1, 'end' => 25, 'price' => 15]
            ],
            DateRangeHelper::merge($step4Input, DateRangeEntity::build(['start' => 3, 'end' => 21, 'price' => 15]))
        );
    }
}

