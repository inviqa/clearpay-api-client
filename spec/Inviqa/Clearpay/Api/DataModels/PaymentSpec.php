<?php

namespace spec\Inviqa\Clearpay\Api\DataModels;

use Inviqa\Clearpay\Api\DataModels\OrderDetails;
use Inviqa\Clearpay\Api\DataModels\Payment;
use Inviqa\Clearpay\JsonHandler;
use PhpSpec\ObjectBehavior;

class PaymentSpec extends ObjectBehavior
{
    function let()
    {
        $state = JsonHandler::decode($this->fullJsonHttpResponseBody(), true);

        $this->beConstructedFromState($state);
    }

    function it_is_initializable()
    {
        $this->shouldHaveType(Payment::class);
    }

    function it_has_properties()
    {
        $this->id()->shouldBe('12345678');
        $this->token()->shouldBe('ltqdpjhbqu3veqikk95g7p3fhvcchfvtlsiobah3u4l5nln8gii9');
        $this->status()->shouldBe('APPROVED');
        $this->paymentState()->shouldBe('AUTH_APPROVED');

        $this->merchantReference()->shouldBe('merchantOrderId-1234');

        $this->createdAt()
            ->format('Y-m-d H:i:s')
            ->shouldBe('2019-01-01 00:00:00');

        $this->originalAmount()->amount()->shouldBe('100.00');
        $this->originalAmount()->currency()->shouldBe('GBP');

        $this->openToCaptureAmount()->amount()->shouldBe('100.00');
        $this->openToCaptureAmount()->currency()->shouldBe('GBP');

        $this->orderDetails()->shouldBeAnInstanceOf(OrderDetails::class);
        $this->orderDetails()->consumer()->givenNames()->shouldBe('Joe');
        $this->orderDetails()->consumer()->surname()->shouldBe('Consumer');
        $this->orderDetails()->items()->shouldHaveCount(2);
    }

    private function fullJsonHttpResponseBody()
    {
        return <<<JSON
{
    "id": "12345678",
    "token": "ltqdpjhbqu3veqikk95g7p3fhvcchfvtlsiobah3u4l5nln8gii9",
    "status": "APPROVED",
    "created": "2019-01-01T00:00:00.000Z",
    "originalAmount": {
        "amount": "100.00",
        "currency": "GBP"
    },
    "openToCaptureAmount": {
        "amount": "100.00",
        "currency": "GBP"
    },
    "paymentState": "AUTH_APPROVED",
    "merchantReference": "merchantOrderId-1234",
    "refunds": [
        {
            "id": "67890123",
            "refundedAt": "2019-01-01T00:00:00.000Z",
            "merchantReference": "merchantRefundId-1234",
            "amount": {
                "amount": "10.00",
                "currency": "GBP"
            }
        }
    ],
    "orderDetails": {
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
        "courier": {
            "shippedAt": "2019-01-01T00:00:00+01:00",
            "name": "Parcelforce Worldwide",
            "tracking": "AAAA1234567890",
            "priority": "STANDARD"
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
                    [
                        "Sporting Goods",
                        "Climbing Equipment",
                        "Climbing",
                        "Climbing Carabiners"
                    ],
                    [
                        "Sale",
                        "Climbing"
                    ]
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
                    [
                        "Camping & Outdoor",
                        "Lighting",
                        "Lanterns"
                    ]
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
    },
    "events": [
        {
            "id": "1OUR16OTqL3DgJ3ELlwKowU9v6K",
            "created": "2019-01-01T00:00:00.000Z",
            "expires": "2019-01-01T00:00:00.000Z",
            "type": "AUTH_APPROVED",
            "amount": {
                "amount": "100.00",
                "currency": "GBP"
            }
        }
    ]
}
JSON;

    }
}
