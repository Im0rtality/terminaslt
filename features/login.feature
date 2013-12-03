Feature: login
  In order to use advanced features of system
  As a registered user
  I need to log in

Scenario: login
  Given I am on the homepage
  When I follow "Login"
  Then I should be on "/login/"
  And I should see "Prisijungimas"
  When I fill in "name" with "test"
  And I fill in "pass" with "test"
  And I press "Prisijungti"
  Then I should be on "/"
  And I should see "Logout (test)"

#  Scenario: fill in comment
#    Given I am on the homepage
#    When I follow "algoritmas"
#    Then I should be on "/term/view/algoritmas/"
#    And should see "Baigtinė seka aiškiai suformuluotų nurodymų"
#    When I fill in "comment" with "Testing comment system"
#    And press "Siųsti"
#    And I go to "/term/view/algoritmas/"
#    Then I should see "Baigtinė seka aiškiai suformuluotų nurodymų"

