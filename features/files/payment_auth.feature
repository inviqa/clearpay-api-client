Feature: Initiate Clearpay payment Auth process

    Scenario: Successful payment auth request
        Given I have checkout token "003.plo9306h9kntg5bd6rhjgj7rua2qh718dphvkckg7gd54f72"
        And I have have request id "successful-request"
        And I have merchant reference "success"
        When I make a payment auth request
        Then I should have an "APPROVED" payment status
        And I should have an "AUTH_APPROVED" payment state

    @end2end
    Scenario: Blank checkout token passed to API raises an error
        Given I have checkout token ""
        When I make a payment auth request
        Then I should have an "invalid_object" error

    @end2end
    Scenario: Expired checkout token raises an error
        Given I have checkout token "expired-token"
        When I make a payment auth request
        Then I should have an "invalid_token" error

    @end2end
    Scenario: Order has not been confirmed raises an error
        Given I have a fresh checkout token
        When I make a payment auth request
        Then I should have an "invalid_order_transaction_status" error
