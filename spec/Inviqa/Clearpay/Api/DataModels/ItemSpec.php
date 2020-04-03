<?php

namespace spec\Inviqa\Clearpay\Api\DataModels;

use Inviqa\Clearpay\Api\DataModels\Item;
use Inviqa\Clearpay\JsonHandler;
use PhpSpec\ObjectBehavior;

class ItemSpec extends ObjectBehavior
{
    function let()
    {
        $json = <<<JSON
{
  "name": "Blue Carabiner",
  "sku": "12341234",
  "quantity": 1,
  "pageUrl": "https://merchant.example.com/carabiner-354193.html",
  "imageUrl": "https://merchant.example.com/carabiner-7378-391453-1.jpg",
  "price": {
    "amount": "40.00",
    "currency": "GBP"
  },
  "categories": [
    ["Sporting Goods", "Climbing Equipment", "Climbing", "Climbing Carabiners"],
    ["Sale", "Climbing"]
  ]
}
JSON;

        $this->beConstructedFromState(JsonHandler::decode($json, true));
    }

    function it_is_initializable()
    {
        $this->shouldHaveType(Item::class);
    }

    function it_has_properties()
    {
        $this->name()->shouldBe('Blue Carabiner');
        $this->sku()->shouldBe('12341234');
        $this->quantity()->shouldBe(1);
        $this->pageUrl()->shouldBe('https://merchant.example.com/carabiner-354193.html');
        $this->imageUrl()->shouldBe('https://merchant.example.com/carabiner-7378-391453-1.jpg');
        $this->price()->amount()->shouldBe('40.00');
        $this->price()->currency()->shouldBe('GBP');
        $this->categories()->shouldBe([
            ["Sporting Goods", "Climbing Equipment", "Climbing", "Climbing Carabiners"],
            ["Sale", "Climbing"]
        ]);
    }
}
