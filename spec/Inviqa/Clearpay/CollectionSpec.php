<?php

namespace spec\Inviqa\Clearpay;

use Inviqa\Clearpay\Collection;
use PhpSpec\ObjectBehavior;

class CollectionSpec extends ObjectBehavior
{
    function let()
    {
        $this->beConstructedThrough('make', [['one', 'two']]);
    }

    function it_is_initializable()
    {
        $this->shouldHaveType(Collection::class);
    }

    function it_can_be_created_statically()
    {
        $this->shouldHaveType(Collection::class);
    }

    function its_an_iterator()
    {
        $this->shouldImplement(\IteratorAggregate::class);
    }

    function its_countable()
    {
        $this->shouldImplement(\Countable::class);
        $this->count()->shouldBe(2);
    }

    function it_has_array_features()
    {
        $this->beConstructedThrough('make', [['one', 'two', 'three', 'four']]);

        $this->shouldImplement(\ArrayAccess::class);

        $this->offsetExists(1)->shouldBe(true);
        $this->offsetGet(2)->shouldBe('three');

        $this->offsetUnset(0);
    }

    function it_can_map_items()
    {
        $data = [
            [
                'name' => 'shirt',
                'price' => '10.00'
            ],
            [
                'name' => 'jumper',
                'price' => '20.00'
            ],
            [
                'name' => 'trousers',
                'price' => '5.00'
            ]
        ];

        $this->beConstructedThrough('make', [$data]);

        $function = function ($item) {
            return $item['name'];
        };

        $expectedCollection = Collection::make([
            'shirt',
            'jumper',
            'trousers'
        ]);

        $this->map($function)->shouldBeLike($expectedCollection);
    }
}
