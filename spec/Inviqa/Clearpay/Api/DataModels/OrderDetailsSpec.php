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
        $this->consumer()->givenNames()->shouldBe('Joe');
        $this->consumer()->surname()->shouldBe('Consumer');
        $this->consumer()->phoneNumber()->shouldBe('07000000000');
        $this->consumer()->email()->shouldBe('test@example.com');

        $this->billing()->shouldBeAnInstanceOf(Contact::class);
        $this->billing()->name()->shouldBe('Joe Consumer');
        $this->billing()->line1()->shouldBe('1 Market Street');
        $this->billing()->line2()->shouldBe('');
        $this->billing()->area1()->shouldBe('');
        $this->billing()->area2()->shouldBe('');
        $this->billing()->region()->shouldBe('MANCHESTER');
        $this->billing()->postcode()->shouldBe('M4 3AT');
        $this->billing()->countryCode()->shouldBe('GB');
        $this->billing()->phoneNumber()->shouldBe('07000000000');

        $this->shipping()->shouldBeAnInstanceOf(Contact::class);
        $this->shipping()->name()->shouldBe('Joe Consumer');
        $this->shipping()->line1()->shouldBe('1 Market Street');
        $this->shipping()->line2()->shouldBe('');
        $this->shipping()->area1()->shouldBe('');
        $this->shipping()->area2()->shouldBe('');
        $this->shipping()->region()->shouldBe('MANCHESTER');
        $this->shipping()->postcode()->shouldBe('M4 3AT');
        $this->shipping()->countryCode()->shouldBe('GB');
        $this->shipping()->phoneNumber()->shouldBe('07000000000');

        $this->courier()->shouldBeAnInstanceOf(ShippingCourier::class);
        $this->courier()->name()->shouldBe('Parcelforce Worldwide');
        $this->courier()->tracking()->shouldBe('AAAA1234567890');
        $this->courier()->priority()->shouldBe('STANDARD');

        $this->items()->shouldBeAnInstanceOf(Collection::class);
        $this->items()->shouldHaveCount(2);
        $this->items()[0]->name()->shouldBe('Blue Carabiner');
        $this->items()[1]->name()->shouldBe('LED Lantern');

        $this->discounts()->shouldImplement(Collection::class);
        $this->discounts()->shouldHaveCount(1);
        $this->discounts()[0]->displayName()->shouldBe('10% Off Subtotal');

        $this->taxAmount()->shouldBeAnInstanceOf(Money::class);
        $this->taxAmount()->amount()->shouldBe('22.00');
        $this->taxAmount()->currency()->shouldBe('GBP');

        $this->shippingAmount()->shouldBeAnInstanceOf(Money::class);
        $this->shippingAmount()->amount()->shouldBe('20.00');
        $this->shippingAmount()->currency()->shouldBe('GBP');
    }

    function it_has_minimum_order_details()
    {
        $this->beConstructedFromState(
            $this->minimumOrderDetailsState()
        );

        $this->consumer()->shouldBeAnInstanceOf(Consumer::class);
        $this->consumer()->givenNames()->shouldBe('Joe');
        $this->consumer()->surname()->shouldBe('Consumer');
        $this->consumer()->phoneNumber()->shouldBe('07000000000');
        $this->consumer()->email()->shouldBe('test@example.com');

        $this->billing()->shouldBeAnInstanceOf(Contact::class);
        $this->billing()->name()->shouldBe('');
        $this->billing()->line1()->shouldBe('');
        $this->billing()->line2()->shouldBe('');
        $this->billing()->area1()->shouldBe('');
        $this->billing()->area2()->shouldBe('');
        $this->billing()->region()->shouldBe('');
        $this->billing()->postcode()->shouldBe('');
        $this->billing()->countryCode()->shouldBe('');
        $this->billing()->phoneNumber()->shouldBe('');

        $this->shipping()->shouldBeAnInstanceOf(Contact::class);
        $this->shipping()->name()->shouldBe('');
        $this->shipping()->line1()->shouldBe('');
        $this->shipping()->line2()->shouldBe('');
        $this->shipping()->area1()->shouldBe('');
        $this->shipping()->area2()->shouldBe('');
        $this->shipping()->region()->shouldBe('');
        $this->shipping()->postcode()->shouldBe('');
        $this->shipping()->countryCode()->shouldBe('');
        $this->shipping()->phoneNumber()->shouldBe('');

        $this->courier()->shouldBeAnInstanceOf(ShippingCourier::class);
        $this->courier()->name()->shouldBe('');
        $this->courier()->tracking()->shouldBe('');
        $this->courier()->priority()->shouldBe('');

        $this->items()->shouldBeAnInstanceOf(Collection::class);
        $this->items()->shouldHaveCount(0);

        $this->discounts()->shouldImplement(Collection::class);
        $this->discounts()->shouldHaveCount(0);

        $this->taxAmount()->shouldBeAnInstanceOf(Money::class);
        $this->taxAmount()->amount()->shouldBe('');
        $this->taxAmount()->currency()->shouldBe('');

        $this->shippingAmount()->shouldBeAnInstanceOf(Money::class);
        $this->shippingAmount()->amount()->shouldBe('');
        $this->shippingAmount()->currency()->shouldBe('');

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

    private function minimumOrderDetailsState()
    {
        $json = <<<JSON
{
    "consumer": {
        "phoneNumber": "07000000000",
        "givenNames": "Joe",
        "surname": "Consumer",
        "email": "test@example.com"
    }
}
JSON;

        return JsonHandler::decode($json, true);
    }
}
