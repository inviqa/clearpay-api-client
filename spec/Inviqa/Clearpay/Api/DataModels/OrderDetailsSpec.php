<?php

namespace spec\Inviqa\Clearpay\Api\DataModels;

use Inviqa\Clearpay\Api\DataModels\Consumer;
use Inviqa\Clearpay\Api\DataModels\Contact;
use Inviqa\Clearpay\Api\DataModels\Money;
use Inviqa\Clearpay\Api\DataModels\OrderDetails;
use Inviqa\Clearpay\Api\DataModels\ShippingCourier;
use Inviqa\Clearpay\Collection;
use Inviqa\Clearpay\JsonHandler;
use PhpSpec\ObjectBehavior;

class OrderDetailsSpec extends ObjectBehavior
{
    function let()
    {
        $this->beConstructedFromState(
            $this->fullOrderDetailsState()
        );
    }

    function it_is_initializable()
    {
        $this->shouldHaveType(OrderDetails::class);
    }

    function it_has_data_models()
    {
        $this->consumer()->shouldBeAnInstanceOf(Consumer::class);
        $this->billing()->shouldBeAnInstanceOf(Contact::class);
        $this->shipping()->shouldBeAnInstanceOf(Contact::class);
        $this->courier()->shouldBeAnInstanceOf(ShippingCourier::class);

        $this->items()->shouldBeAnInstanceOf(Collection::class);
        $this->items()->shouldHaveCount(2);
        $this->items()[0]->name()->shouldBe('Blue Carabiner');
        $this->items()[1]->name()->shouldBe('LED Lantern');

        $this->discounts()->shouldImplement(Collection::class);
        $this->discounts()->shouldHaveCount(1);
        $this->discounts()[0]->displayName()->shouldBe('10% Off Subtotal');

        $this->taxAmount()->shouldBeAnInstanceOf(Money::class);
        $this->shippingAmount()->shouldBeAnInstanceOf(Money::class);
    }

    private function fullOrderDetailsState()
    {
        $json = <<<JSON
{
  "consumer": {
    "phoneNumber": "07000000000",
    "givenNames": "Joe",
    "surname": "Consumer",
    "email": "test@example.com"
  },
  "billing": {
    "name": "Joe Consumer",
    "line1": "1 Market Street",
    "region": "MANCHESTER",
    "postcode": "M4 3AT",
    "countryCode": "GB",
    "phoneNumber": "07000000000"
  },
  "shipping": {
    "name": "Joe Consumer",
    "line1": "1 Market Street",
    "region": "MANCHESTER",
    "postcode": "M4 3AT",
    "countryCode": "GB",
    "phoneNumber": "07000000000"
  },
  "courier" : {
    "shippedAt" : "2019-01-01T00:00:00+01:00",
    "name" : "Parcelforce Worldwide",
    "tracking" : "AAAA1234567890",
    "priority" : "STANDARD"
  },
  "items": [
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
    },
    {
      "name": "LED Lantern",
      "sku": "12346789",
      "quantity": 1,
      "pageUrl": "https://merchant.example.com/lantern-836599.html",
      "imageUrl": "https://merchant.example.com/lantern-3417-983451-1.jpg",
      "price": {
        "amount": "60.00",
        "currency": "GBP"
      },
      "categories": [
        ["Camping & Outdoor", "Lighting", "Lanterns"]
      ]
    }
  ],
  "discounts": [
    {
      "displayName": "10% Off Subtotal",
      "amount": {
        "amount": "10.00",
        "currency": "GBP"
      }
    }
  ],
  "taxAmount": {
    "amount": "22.00",
    "currency": "GBP"
  },
  "shippingAmount": {
    "amount": "20.00",
    "currency": "GBP"
  }
}
JSON;

        return JsonHandler::decode($json, true);
    }
}
